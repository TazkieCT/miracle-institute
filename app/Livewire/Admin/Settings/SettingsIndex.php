<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Company;
use Livewire\Component;

class SettingsIndex extends Component
{
    public string $name = '';
    public string $description = '';
    public string $address = '';
    public string $vision = '';
    public string $mission = '';
    public string $logo = '';
    public string $facebook = '';
    public string $instagram = '';
    public string $youtube = '';
    public string $whatsapp = '';

    public function mount(): void
    {
        $company = Company::first();

        if ($company) {
            $this->fill($company->only([
                'name','description','address','vision','mission','logo',
                'facebook','instagram','youtube','whatsapp',
            ]));
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'logo' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'whatsapp' => 'nullable|url',
        ]);

        Company::updateOrCreate(
            ['id' => 1],
            [
                'name' => $this->name,
                'description' => $this->description,
                'address' => $this->address,
                'vision' => $this->vision,
                'mission' => $this->mission,
                'logo' => $this->logo,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
                'whatsapp' => $this->whatsapp,
            ]
        );

        session()->flash('success', 'Settings saved.');
    }

    public function render()
    {
        return view('livewire.admin.settings.index')->layout('layouts.admin');
    }
}