@if($product->allow_artwork_upload)
<div class="mt-6 p-4 border border-gray-200 rounded-lg">
    <h4 class="font-semibold text-gray-900 mb-3">Upload Your Artwork</h4>
    @if($product->artwork_instructions)
    <p class="text-sm text-gray-600 mb-3">{!! $product->artwork_instructions !!}</p>
    @endif
    <div id="artwork-drop-zone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
        <div id="artwork-drop-content">
            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <p class="mt-2 text-sm text-gray-600">Drag and drop or <span class="text-blue-600 font-medium">browse</span></p>
            <p class="text-xs text-gray-500">PDF, AI, PSD, PNG, JPG - Max 25MB</p>
        </div>
        <div id="artwork-preview" class="hidden">
            <div id="artwork-files" class="space-y-2"></div>
            <button type="button" onclick="clearArtwork()" class="mt-3 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Clear</button>
        </div>
    </div>
    <input type="file" name="artwork_file[]" id="artwork-file-input" accept=".pdf,.ai,.psd,.png,.jpg,.jpeg" multiple class="hidden">
    <input type="hidden" name="artwork_uploaded" id="artwork-uploaded" value="">
</div>
@endif
