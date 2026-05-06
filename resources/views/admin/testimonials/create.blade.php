@extends('admin.layout')

@section('page-title', 'Add Testimonial')

@section('content')
<form action="/admin/testimonials" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
            <input type="text" name="company" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
            <textarea name="message" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg" required></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Avatar</label>
            <div class="flex items-start gap-4">
                <div id="testimonial-avatar-preview" class="w-20 h-20 border-2 border-dashed border-gray-300 rounded-full overflow-hidden flex items-center justify-center bg-gray-50">
                    <span class="text-gray-400 text-xs">No avatar</span>
                </div>
                <div class="space-y-2">
                    <button type="button" onclick="selectFromLibrary('testimonial-avatar')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Choose from Library
                    </button>
                    <input type="hidden" name="avatar_url" id="testimonial-avatar-url" value="">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4">
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        <a href="/admin/testimonials" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
    </div>
</form>

<script>
function selectFromLibrary(prefix) {
    openMediaLibrary({
        mode: 'single',
        callback: function(ids) {
            var img = mediaLibraryState.allImages.find(i => i.id === ids[0]);
            if (img) {
                document.getElementById(prefix + '-url').value = img.url;
                document.getElementById(prefix + '-preview').innerHTML = '<img src="' + img.url + '" alt="" class="w-full h-full object-cover">';
            }
        }
    });
}
</script>

@include('admin.partials.media-library')
@endsection
