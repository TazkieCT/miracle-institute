<div class="space-y-6">
    <x-ui.page-header title="Users" subtitle="Daftar pengguna dan role yang mereka miliki." />

    <div class="rounded-2xl bg-white border p-4">
        <input wire:model.live="search" class="w-full border rounded-xl px-4 py-2" placeholder="Search user...">
    </div>

    <div class="rounded-2xl bg-white border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Roles</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="border-t">
                        <td class="p-4 font-medium">{{ $row->full_name }}</td>
                        <td class="p-4">{{ $row->email }}</td>
                        <td class="p-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($row->roles as $role)
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-xs">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('admin.users.roles', $row->id) }}" class="text-slate-900 underline">Manage roles</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-6 text-center text-slate-500">No users.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $rows->links() }}</div>
</div>