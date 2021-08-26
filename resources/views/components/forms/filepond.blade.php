<div
    class="h-48 flex items-center justify-center"
    wire:ignore
    x-data
    x-init="
        () => {
            const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
            post.setOptions({
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                    },
                },
                allowImagePreview: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
        });
    }
"
>
    <input class="h-full w-full opacity-1" type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>

@once
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
    .filepond--root{
        margin-bottom: 0 !important;
    }
    .filepond--panel-root{
        background-color: transparent !important;
    }
    .filepond--browser.filepond--browser{
        height: 100%;
    }
    .filepond--root .filepond--credits{
        display: none;
    }
</style>
@endonce


    @once
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);
    </script>
    @endonce

