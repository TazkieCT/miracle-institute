export default function assessmentApp(initialAnswers = {}, limit = null, startedAt = null, persistKey = 'assessment-answers', initialIndex = 0, questionCount = 0) {
    return {
        answers: { ...initialAnswers },
        openSubmit: false,
        timeLimit: limit,
        startedAt: startedAt,
        timeLeft: null,
        interval: null,
        submitting: false,
        currentIndex: Number(initialIndex ?? 0),
        questionCount: Number(questionCount ?? 0),
        persistKey,

        init() {
            this.loadFromStorage();
            this.syncIndexToServer();
            this.initTimer();
        },

        answeredCount() {
            return Object.values(this.answers).filter(v => v !== null && v !== '').length;
        },

        setAnswer(q, val) {
            const key = String(q);
            const value = val === null ? '' : String(val);

            this.answers[key] = value;
            this.persist();
            this.$wire.saveAnswer(Number(q), value);
        },

        goTo(index) {
            const nextIndex = Number(index);

            if (Number.isNaN(nextIndex)) return;
            if (nextIndex < 0 || nextIndex >= this.questionCount) return;

            this.currentIndex = nextIndex;
            this.persist();
            this.$wire.goToQuestion(nextIndex);
        },

        next() {
            if (this.currentIndex < this.questionCount - 1) {
                this.goTo(this.currentIndex + 1);
            }
        },

        prev() {
            if (this.currentIndex > 0) {
                this.goTo(this.currentIndex - 1);
            }
        },

        syncIndexToServer() {
            this.$wire.goToQuestion(this.currentIndex);
        },

        persist() {
            localStorage.setItem(
                this.persistKey,
                JSON.stringify({
                    answers: this.answers,
                    currentIndex: this.currentIndex,
                })
            );
        },

        loadFromStorage() {
            const saved = localStorage.getItem(this.persistKey);
            if (!saved) return;

            try {
                const parsed = JSON.parse(saved);

                if (parsed && typeof parsed === 'object') {
                    if (parsed.answers && typeof parsed.answers === 'object') {
                        Object.assign(this.answers, parsed.answers);
                    }

                    if (Number.isInteger(parsed.currentIndex)) {
                        this.currentIndex = parsed.currentIndex;
                    }

                    Object.entries(this.answers).forEach(([questionId, value]) => {
                        this.$wire.saveAnswer(Number(questionId), value);
                    });
                }
            } catch (e) {
                localStorage.removeItem(this.persistKey);
            }
        },

        clearTimer() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        initTimer() {
            if (!this.timeLimit || !this.startedAt) return;

            const tick = () => {
                const now = Math.floor(Date.now() / 1000);
                const elapsed = now - Number(this.startedAt);
                const remaining = (Number(this.timeLimit) * 60) - elapsed;

                if (remaining <= 0) {
                    this.timeLeft = 0;
                    this.clearTimer();
                    this.submitNow();
                    return;
                }

                this.timeLeft = remaining;
            };

            tick();
            this.interval = setInterval(tick, 1000);
        },

        formatTime(sec) {
            const total = Math.max(0, Number(sec) || 0);
            const m = Math.floor(total / 60);
            const s = total % 60;

            return `${m}:${s.toString().padStart(2, '0')}`;
        },

        async submitNow() {
            if (this.submitting) return;

            this.submitting = true;
            this.openSubmit = false;
            this.clearTimer();
            localStorage.removeItem(this.persistKey);

            try {
                await this.$wire.submit(this.answers);
            } finally {
                this.submitting = false;
            }
        }
    };
}