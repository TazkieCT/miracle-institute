<div class="max-w-md mx-auto bg-white border rounded-2xl p-6 space-y-5">
    <div>
        <h1 class="text-2xl font-bold">Sign Up</h1>
        <p class="text-sm text-gray-500">Buat akun baru.</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <input type="text" required minlength="2" wire:model.debounce.300ms="first_name"
                       placeholder="First name" class="w-full border rounded-lg px-4 py-2">
                @error('first_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="text" required minlength="2" wire:model.debounce.300ms="last_name"
                       placeholder="Last name" class="w-full border rounded-lg px-4 py-2">
                @error('last_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <input type="email" required autocomplete="email" wire:model.debounce.300ms="email"
                   placeholder="Email" class="w-full border rounded-lg px-4 py-2">
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" required minlength="8" autocomplete="new-password"
                   wire:model.debounce.300ms="password" placeholder="Password"
                   class="w-full border rounded-lg px-4 py-2">
            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" required minlength="8" autocomplete="new-password"
                   wire:model.debounce.300ms="password_confirmation"
                   placeholder="Confirm password" class="w-full border rounded-lg px-4 py-2">
            @error('password_confirmation') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-black text-white rounded-lg py-2">
            Create account
        </button>
    </form>

    <div class="text-sm text-center">
        <a href="{{ route('login') }}" class="underline">Already have an account?</a>
    </div>
</div>