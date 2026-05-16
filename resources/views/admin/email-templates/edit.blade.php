@extends('admin.layout')

@section('page-title', 'Edit Email Template')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate->id) }}">
            @csrf @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
                <input type="text" name="name" value="{{ $emailTemplate->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" value="{{ $emailTemplate->slug }}" disabled class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                <input type="hidden" name="slug" value="{{ $emailTemplate->slug }}">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Subject</label>
                <input type="text" name="subject" value="{{ $emailTemplate->subject }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Body (HTML)</label>
                <textarea name="body" rows="10" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 wysiwyg">{{ $emailTemplate->body }}</textarea>
                <small class="text-gray-500">Available variables: {{ '{' }}{{ '{' }}customer_name{{ '}' }}, {{ '{' }}{{ '{' }}order_number{{ '}' }}, {{ '{' }}{{ '{' }}order_total{{ '}' }}, {{ '{' }}{{ '{' }}order_items{{ '}' }}, {{ '{' }}{{ '{' }}order_date{{ '}' }}{{ '}' }}</small>
            </div>
            
            <div class="mb-4 flex gap-6 flex-wrap">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ $emailTemplate->is_active ? 'checked' : '' }} class="w-4 h-4">
                    <span>Active</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="send_to_customer" value="1" {{ $emailTemplate->send_to_customer ? 'checked' : '' }} class="w-4 h-4">
                    <span>Send to Customer</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="send_to_admin" value="1" {{ $emailTemplate->send_to_admin ? 'checked' : '' }} class="w-4 h-4">
                    <span>Send to Admin</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="attach_invoice" value="1" {{ $emailTemplate->attach_invoice ? 'checked' : '' }} class="w-4 h-4">
                    <span class="text-blue-700 font-medium">Attach Invoice PDF</span>
                </label>
            </div>
            
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.email-templates.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection