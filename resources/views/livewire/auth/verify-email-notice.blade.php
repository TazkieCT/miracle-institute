<div class="space-y-5 rounded-[2rem] border border-[#004777]/10 bg-white/95 p-6 shadow-[0_20px_60px_-24px_rgba(0,71,119,0.25)] backdrop-blur">
    <div>
        <h1 class="text-2xl font-black text-[#004777]">Verify your email</h1>
        <p class="text-sm text-[#004777]/70">
            Cek inbox email kamu. Jika belum menerima, kirim ulang link verifikasi.
        </p>
    </div>

    @if (session('status'))
        <div class="rounded-xl bg-[#35A7FF]/10 px-4 py-3 text-sm text-[#004777]">
            {{ session('status') }}
        </div>
    @endif

    <button wire:click="resend" class="w-full rounded-xl bg-[#004777] py-2.5 text-white transition hover:bg-[#004777]/90">
        Resend verification email
    </button>
</div>