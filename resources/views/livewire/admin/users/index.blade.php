<div class="space-y-6">

    <x-ui.page-header 
        title="Users" 
        subtitle="Daftar pengguna dan role yang mereka miliki." 
    />

    {{-- FILTER + SEARCH --}}
    <div class="rounded-2xl bg-white border p-4 grid grid-cols-1 md:grid-cols-3 gap-3">

        {{-- SEARCH --}}
        <input 
            wire:model.live="search" 
            class="w-full border rounded-xl px-4 py-2" 
            placeholder="Search user..."
        >

        {{-- ROLE FILTER --}}
        <select 
            wire:model.live="roleFilter" 
            class="border rounded-xl px-4 py-2"
        >
            <option value="">All roles</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">
                    {{ $role->name }}
                </option>
            @endforeach
        </select>

        {{-- SORT --}}
        <select 
            wire:model.live="sort" 
            class="border rounded-xl px-4 py-2"
        >
            <option value="latest">Latest</option>
            <option value="name_asc">Name A-Z</option>
            <option value="name_desc">Name Z-A</option>
            <option value="email_asc">Email A-Z</option>
            <option value="email_desc">Email Z-A</option>
        </select>

    </div>

    {{-- TABLE --}}
    <div class="rounded-2xl bg-white border overflow-hidden">
        <table class="w-full text-sm table-fixed">

            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="p-4 w-1/4">Name</th>
                    <th class="p-4 w-1/4">Email</th>
                    <th class="p-4 w-1/3">Roles</th>
                    <th class="p-4 w-1/6">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rows as $row)
                    <tr class="border-t align-top">

                        {{-- NAME --}}
                        <td class="p-4 font-medium break-words">
                            {{ $row->full_name }}
                        </td>

                        {{-- EMAIL --}}
                        <td class="p-4 break-words">
                            {{ $row->email }}
                        </td>

                        {{-- ROLES --}}
                        <td class="p-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($row->roles as $role)
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-xs">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        {{-- ACTION --}}
                        <td class="p-4">
                            <a 
                                href="{{ route('admin.users.roles', $row->id) }}" 
                                class="text-slate-900 underline"
                            >
                                Manage roles
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-slate-500">
                            No users.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $rows->links() }}
    </div>

</div>