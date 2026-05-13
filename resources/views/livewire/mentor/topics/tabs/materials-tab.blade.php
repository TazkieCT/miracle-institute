<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="flex flex-col h-full w-full rounded-2xl border border-slate-200 bg-white p-5 md:p-6 shadow-sm">
        <!-- Header Section -->
        <div class="mb-5 border-b border-slate-100 pb-4 text-center sm:text-left">
            <h2 class="text-xl font-semibold text-slate-800">Selected Material</h2>
            <p class="mt-1 text-sm text-slate-500">Preview dan detail data material.</p>
        </div>

        <!-- Content Section -->
        <div class="flex w-full flex-col flex-grow">
            @if($selectedMaterial)

                @if($selectedMaterial->type === 'video' && $selectedMaterial->external_url)
                    @php
                        $url = $selectedMaterial->external_url;
                        $ytId = null;
                        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|shorts\/)([^"&?\/\s]{11})/i', $url, $match)) {
                            $ytId = $match[1];
                        }
                        $finalThumbnailUrl = $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : null;
                        $finalWatchUrl = $ytId ? "https://www.youtube.com/watch?v={$ytId}" : $url;
                    @endphp

                    <div class="mx-auto flex w-full max-w-3xl flex-col space-y-5">
                        <!-- Thumbnail / Video Wrapper -->
                        <div class="group relative aspect-video w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 shadow-md">
                            @if($finalThumbnailUrl)
                                <img
                                    src="{{ $finalThumbnailUrl }}"
                                    alt="Thumbnail {{ $selectedMaterial->name }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover opacity-80 transition-all duration-500 group-hover:scale-105 group-hover:opacity-100"
                                >
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-slate-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-slate-400">Thumbnail tidak tersedia</span>
                                </div>
                            @endif

                            @if($finalWatchUrl)
                                <a href="{{ $finalWatchUrl }}" target="_blank" rel="noopener noreferrer" class="absolute inset-0 flex items-center justify-center">
                                    <div class="grid h-16 w-16 place-items-center rounded-full bg-white/90 text-[#004777] shadow-xl transition-all duration-300 group-hover:scale-110 group-hover:bg-[#004777] group-hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </a>
                            @endif
                        </div>

                        <!-- Actions -->
                        @if($finalWatchUrl)
                            <div class="flex flex-col items-center gap-3">
                                <a
                                    href="{{ $finalWatchUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#004777] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#003560] hover:shadow-md sm:w-auto"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                    </svg>
                                    Tonton di YouTube
                                </a>
                                <p class="text-center text-xs text-slate-400">
                                    Video akan dibuka di tab baru untuk menghindari error restriksi.
                                </p>
                            </div>
                        @endif
                    </div>

                @elseif($materialPreviewUrl)
                    <div class="mx-auto flex w-full max-w-4xl flex-col space-y-5">
                        <div class="aspect-video w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                            <iframe src="{{ $materialPreviewUrl }}" class="h-full w-full" allowfullscreen></iframe>
                        </div>
                        <div class="flex justify-center">
                            <a href="{{ $materialPreviewUrl }}" target="_blank" class="inline-flex w-full items-center justify-center rounded-xl bg-[#004777] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#003560] hover:shadow-md sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Buka / Download Dokumen
                            </a>
                        </div>
                    </div>

                @else
                    <div class="flex min-h-[250px] flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-medium text-slate-500">Material ini belum memiliki preview.</p>
                    </div>
                @endif

            @else
                <div class="flex min-h-[300px] flex-grow flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-6 text-center transition-colors hover:border-[#004777]/30 hover:bg-[#004777]/5">
                    <div class="mb-4 grid h-16 w-16 place-items-center rounded-full bg-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#004777]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-700">Belum Ada Material Terpilih</h3>
                    <p class="mt-1 max-w-sm text-sm text-slate-500">Silakan pilih salah satu material dari daftar di sebelah kanan untuk melihat detail dan preview.</p>
                </div>
            @endif
        </div>
    </div>

    <aside class="rounded-2xl border bg-white p-5">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-lg font-semibold">Materials List</h2>

            @if($canAddMaterial)
                <button type="button"
                        wire:click="openMaterialModal"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white hover:bg-slate-700">
                    Add Material
                </button>
            @else
                <span class="rounded-full border px-3 py-1 text-xs text-slate-500">
                    Limit reached
                </span>
            @endif
        </div>

        <div class="mt-4 space-y-2">
            @forelse($materials as $material)
                <button type="button"
                        wire:click="selectMaterial('{{ $material->id }}')"
                        class="w-full rounded-xl border p-4 text-left transition
                               {{ $selectedMaterial?->id === $material->id ? 'border-slate-900 bg-slate-900 text-white shadow-sm' : 'hover:border-slate-400' }}">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-medium">
                                #{{ $material->sort_order }} · {{ $material->name }}
                            </div>
                            <div class="mt-1 text-xs {{ $selectedMaterial?->id === $material->id ? 'text-slate-300' : 'text-slate-500' }}">
                                {{ strtoupper($material->type) }} · {{ ucfirst($material->status) }}
                            </div>
                        </div>

                        <span class="rounded-full border px-2 py-1 text-[11px] uppercase text-slate-600">
                            Edit
                        </span>
                    </div>
                </button>
            @empty
                <div class="rounded-xl border border-dashed p-5 text-sm text-slate-500">
                    Belum ada material.
                </div>
            @endforelse
        </div>
    </aside>

    <x-ui.mentor.modal
        :show="$showMaterialModal"
        title="{{ $editingMaterialId ? 'Edit Material' : 'Add Material' }}"
        subtitle="Gunakan external path untuk Google Drive atau YouTube."
        wire:click="closeMaterialModal"
    >
        <form wire:submit.prevent="saveMaterial" class="space-y-4">

            <div wire:loading wire:target="materialFile,saveMaterial" class="animate-pulse space-y-2 mb-2">
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-1/2"></div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">

                <div class="sm:col-span-2">
                    <label class="text-xs font-medium text-slate-500">Material Name</label>
                    <input wire:model="materialName" class="mt-1 w-full rounded-xl border px-4 py-2" placeholder="Material name">
                    @error('materialName') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-slate-500">Type</label>
                    <select wire:model.live="materialType" class="mt-1 w-full rounded-xl border px-4 py-2">
                        <option value="">Select</option>
                        @foreach($materialTypeOptions as $type)
                            <option value="{{ $type }}">{{ strtoupper($type) }}</option>
                        @endforeach
                    </select>
                    @error('materialType') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    @if(empty($materialTypeOptions))
                        <p class="mt-1 text-xs text-slate-500">Semua tipe sudah dipakai pada topic ini.</p>
                    @endif
                </div>

                <div>
                    <label class="text-xs font-medium text-slate-500">Status</label>
                    <select wire:model="materialStatus" class="mt-1 w-full rounded-xl border px-4 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('materialStatus') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                @if(in_array($materialType, ['pdf','ppt']))
                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-slate-500">Material File</label>
                        <input type="file" wire:model="materialFile" class="mt-1 w-full rounded-xl border px-4 py-2" accept=".pdf,.ppt,.pptx">
                        @error('materialFile') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                @endif

                @if($materialType === 'video')
                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-slate-500">External URL</label>
                        <input wire:model="materialExternalUrl"
                            class="mt-1 w-full rounded-xl border px-4 py-2"
                            placeholder="YouTube URL / video ID">
                        @error('materialExternalUrl') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror

                        @if($materialExternalUrl)
                            <div class="mt-2 aspect-video overflow-hidden rounded-2xl bg-slate-100">
                                <iframe src="{{ app(\App\Services\Materials\MaterialAssetService::class)->youtube->toEmbedUrl($materialExternalUrl) }}"
                                        class="h-full w-full" allowfullscreen
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                </iframe>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="sm:col-span-2">
                    <label class="text-xs font-medium text-slate-500">Sort Order</label>
                    <input wire:model="materialSortOrder" type="number" min="0" class="mt-1 w-full rounded-xl border px-4 py-2">
                    @error('materialSortOrder') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex items-center justify-end gap-3 border-t pt-4">
                <button type="button" wire:click="closeMaterialModal"
                        class="rounded-xl border px-4 py-2 text-sm text-slate-600">
                    Cancel
                </button>
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                    {{ $editingMaterialId ? 'Update Material' : 'Save Material' }}
                </button>
            </div>

        </form>
    </x-ui.mentor.modal>
</section>