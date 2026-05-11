<div class="space-y-5 rounded-[2rem] border border-[#004777]/10 bg-white/95 p-6 shadow-[0_20px_60px_-24px_rgba(0,71,119,0.25)] backdrop-blur">
    <div>
        <h1 class="text-2xl font-black text-[#004777]">Reset Password</h1>
        <p class="text-sm text-[#004777]/70">Buat password baru.</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <input type="email" required autocomplete="email" wire:model.debounce.300ms="email"
                   placeholder="Email" class="w-full rounded-xl border border-[#004777]/15 bg-[#f4faff] px-4 py-2.5 text-[#004777] outline-none transition placeholder:text-[#004777]/35 focus:border-[#35A7FF] focus:bg-white">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" required minlength="8" autocomplete="new-password"
                   wire:model.debounce.300ms="password" placeholder="New password"
                   class="w-full rounded-xl border border-[#004777]/15 bg-[#f4faff] px-4 py-2.5 text-[#004777] outline-none transition placeholder:text-[#004777]/35 focus:border-[#35A7FF] focus:bg-white">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" required minlength="8" autocomplete="new-password"
                   wire:model.debounce.300ms="password_confirmation"
                   placeholder="Confirm new password" class="w-full rounded-xl border border-[#004777]/15 bg-[#f4faff] px-4 py-2.5 text-[#004777] outline-none transition placeholder:text-[#004777]/35 focus:border-[#35A7FF] focus:bg-white">
            @error('password_confirmation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full rounded-xl bg-[#004777] py-2.5 text-white transition hover:bg-[#004777]/90">
            Reset password
        </button>
    </form>
</div>