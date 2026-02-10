<div
    wire:ignore
    x-data
    x-init="
        () => {
            const pond = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
            pond.setOptions({
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        $wire.upload('{{ $attributes->whereStartsWith('wire:model.live')->first() }}', file, load, error, progress);
                    },
                    revert: (filename, load) => {
                        $wire.removeUpload('{{ $attributes->whereStartsWith('wire:model.live')->first() }}', filename, load)
                    },
                },
                allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
                imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!},
                allowRevert: {!! $attributes->has('allowRevert') ? "'".$attributes->get('allowRevert')."'" : 'true' !!}
            });

            pond.on('processfiles', (error, file) => {
                console.log('File added', file);
                //pond.removeFiles();
            });

            window.addEventListener('clearPond', () => {
                pond.removeFiles();
            })
        }
    "
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>
