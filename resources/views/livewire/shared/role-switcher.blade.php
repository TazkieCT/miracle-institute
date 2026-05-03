<div class="flex items-center gap-2">
    @foreach($roles as $role)
        <button
            type="button"
            wire:click="switchRole('{{ $role['name'] }}')"
            class="px-3 py-2 rounded-md text-sm border
                   {{ $activeRole === $role['name'] ? 'bg-black text-white' : 'bg-white text-gray-700' }}"
        >
            {{ $role['label'] }}
        </button>
    @endforeach
</div>