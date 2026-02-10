<div>
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-header header-light pt-2 pb-2 ">
                    <h5 class="card-title mb-0">{{ __('Dateien') }} ({{ $order?->attachments?->count() }})</h5>
                </div>
                <div class="card-body">
                    @if ($order?->attachments?->count() > 0)
                        <div class="table-responsive overflow-y-scroll" style="max-height: 240px">
                            <table class="table table-vcenter table-sm table-hover">
                                <tbody>
                                <tr class="table-active table-dark">
                                    <th class="p-2 text-white" style="width: 50px;"></th>
                                    <th class="p-2">{{ __('Datei') }}</th>
                                    <th class="text-center p-2 text-white"><span class="text-muted">{{ __('Datum') }}</span></th>
                                    <th class="text-center p-2 text-white">{{ __('Aktion') }}</th>
                                </tr>
                                    @foreach($order->attachments()?->orderBy('created_at', 'desc')->get() as $attachment)
                                        <tr x-data="{ editing: false }">
                                            {{-- Icon --}}
                                            <td class="table-success text-center py-2 px-2">
                                                <i class="fas {{ $attachment->getFileIcon() }} text-success pe-auto"></i>
                                            </td>

                                            <td class="py-2 px-2">
                                                {{-- normal view --}}
                                                <div x-show="!editing" x-cloak>
                                                    <a target="_blank" href="{{ route('orderbook.orders.attachments.view', [$order, $attachment]) }}" class="fw-medium" title="{{ $attachment->fileName }}">
                                                        {{ substr($attachment->fileName, 0, 25) }}
                                                    </a>
                                                </div>

                                                {{-- edit mode --}}
                                                <div x-show="editing" x-cloak>
                                                    <livewire:order-book.components.attachment-rename :attachment="$attachment" wire:key="{{ rand() }}" />
                                                </div>
                                            </td>

                                            {{-- Date --}}
                                            <td class="text-center text-muted py-2 px-2">
                                                {{ $attachment->created_at?->format('d.m.Y') }}
                                            </td>

                                            {{-- ACTION button group --}}
                                            <td class="text-center py-0 px-0">
                                                <div class="d-flex justify-content-center gap-1" aria-label="Aktion">
                                                    {{-- Bearbeiten (toggle on) --}}
                                                    @can(config('perm.orderbook.orders.renameFile'))
                                                        <button type="button" class="btn btn-sm btn-offwhite btn-border-gray-2 py-0 px-1" x-show="!editing" x-cloak @click="editing = true" title="{{ __('Bearbeiten') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Save (✓) -->
                                                        <button type="button" class="btn btn-outline-success btn-sm py-0 px-1"
                                                                x-show="editing" x-cloak
                                                                @click="$dispatch('attachment-rename:save', { id: {{ $attachment->id }} }); editing = false"
                                                                title="{{ __('Speichern') }}">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <!-- Cancel (✕) -->
                                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-1"
                                                                x-show="editing" x-cloak
                                                                @click="$dispatch('attachment-rename:cancel', { id: {{ $attachment->id }} }); editing = false"
                                                                title="{{ __('Abbrechen') }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endcan

                                                    {{-- Ansehen --}}
                                                    <a target="_blank" href="{{ route('orderbook.orders.attachments.view', [$order, $attachment]) }}" class="btn btn-sm btn-offwhite btn-border-gray-2 py-0 px-1" title="{{ __('Ansehen') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- Löschen --}}
                                                    @can(config('perm.orderbook.orders.removeFile'))
                                                        <button type="button" class="btn btn-danger py-0 px-1" title="{{ __('Löschen') }}" wire:click.prevent="$dispatch('swal:confirm', {{ collect(['method' => 'removeFile', 'params' => [$attachment->id] ]) }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(($dropZone ?? true) === true)
                            <div class="mt-3" style="max-width: 400px; margin: 0 auto;">
                                <livewire:dropzone
                                    wire:model="attachments"
                                    :rules="['max:10420']"
                                    :files="$attachments ?? []"
                                    :multiple="true"
                                    :key="rand()" />
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
