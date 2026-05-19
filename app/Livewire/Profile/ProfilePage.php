<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePage extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $gender = '';
    public string $dob = '';

    public ?string $currentImage = null;
    public $imageFile = null;

    public function mount(): void
    {
        $user = Auth::user();

        abort_unless($user, 401);

        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
        $this->phone = (string) ($user->phone ?? '');
        $this->gender = (string) ($user->gender ?? '');
        $this->dob = $user->dob?->format('Y-m-d') ?? '';
        $this->currentImage = $user->image;
    }

    protected function rules(): array
    {
        $userId = Auth::id();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'dob' => ['nullable', 'date', 'before_or_equal:today'],
            'imageFile' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function updatedImageFile(): void
    {
        $this->validateOnly('imageFile');
    }

    public function getProfileImageUrlProperty(): ?string
    {
        try {
            if ($this->imageFile) {
                return $this->imageFile->temporaryUrl();
            }

            if ($this->currentImage && filter_var($this->currentImage, FILTER_VALIDATE_URL)) {
                return $this->currentImage;
            }

            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                return Storage::disk('public')->url($this->currentImage);
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    public function save(): mixed
    {
        $validated = $this->validate();
        $user = Auth::user();

        abort_unless($user, 401);

        $imagePath = $this->currentImage;

        if ($this->imageFile) {
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            $imagePath = $this->imageFile->store('profiles', 'public');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'gender' => $validated['gender'] ?: null,
            'dob' => $validated['dob'] ?: null,
            'image' => $imagePath,
        ]);

        $this->currentImage = $imagePath;
        $this->imageFile = null;

        session()->flash('success', __('general.profile.flash.saved'));

        return null;
    }

    public function render()
    {
        $user = Auth::user()?->loadMissing('roles');
        $activeRole = session('active_role');
        $layout = $activeRole === 'admin' ? 'layouts.app' : 'layouts.learning';

        return view('livewire.profile.profile-page', [
            'user' => $user,
            'activeRole' => $activeRole,
        ])->layout($layout);
    }
}
