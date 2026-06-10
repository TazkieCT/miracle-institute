<div class="space-y-6">
    <x-ui.page-header title="{{ __('admin.roles.page_title') }}" subtitle="{{ __('admin.roles.page_subtitle') }}" />

    {{-- <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
        Role saat ini bersifat read-only. Anda masih bisa melihat daftar role dan permission yang dimiliki, tetapi tidak bisa menambah, mengubah, atau menghapus role.
    </div> --}}

    <section class="space-y-4">
        <div class="overflow-hidden rounded-2xl border bg-white">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full text-sm">
                    <thead class="admin-table-head text-left text-slate-600">
                        <tr>
                            <th class="px-4 py-3 font-medium">{{ __('admin.roles.table.name') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('admin.roles.table.label') }}</th>
                            <th class="px-4 py-3 font-medium">{{ __('admin.roles.table.permissions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($rows as $row)
                            <tr class="align-top transition-colors hover:bg-slate-50/60">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-900">{{ $row->name }}</td>

                                <td class="px-4 py-3 text-slate-700">{{ $row->label }}</td>

                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($row->permissions as $perm)
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 ring-1 ring-slate-200">
                                                {{ $perm->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">{{ __('admin.roles.empty_permissions') }}</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-500">
                                    {{ __('admin.roles.empty') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>{{ $rows->links() }}</div>
    </section>
</div>
