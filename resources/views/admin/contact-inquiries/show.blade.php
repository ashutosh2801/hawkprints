@extends('admin.layout')

@section('page-title', 'Contact Inquiry - ' . $contactInquiry->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Inquiry Details</h1>
        <a href="{{ route('admin.contact-inquiries') }}" class="text-blue-600 hover:text-blue-800">← Back to List</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Sender Info</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-500 block">Name</span>
                    <span class="font-medium">{{ $contactInquiry->name }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Email</span>
                    <a href="mailto:{{ $contactInquiry->email }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $contactInquiry->email }}</a>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Phone</span>
                    <span class="font-medium">{{ $contactInquiry->phone ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Received</span>
                    <span class="font-medium">{{ $contactInquiry->created_at->format('F d, Y g:i A') }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Status</span>
                    @if($contactInquiry->replied_at)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Replied on {{ $contactInquiry->replied_at->format('M d, Y') }}</span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending Reply</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Message</h3>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $contactInquiry->message }}</div>
        </div>
    </div>

    @if($contactInquiry->replied_at)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            Your Reply
        </h3>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $contactInquiry->admin_reply }}</div>
        <p class="text-sm text-gray-500 mt-2">Sent on {{ $contactInquiry->replied_at->format('F d, Y g:i A') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Reply to {{ $contactInquiry->name }}</h3>
        <p class="text-sm text-gray-500 mb-4">Your reply will be stored and visible in the admin panel. Currently this is an internal note — email sending can be added later.</p>
        <form method="POST" action="{{ route('admin.contact-inquiries.reply', $contactInquiry) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Reply</label>
                <textarea name="admin_reply" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Type your reply here..." {{ $contactInquiry->replied_at ? '' : '' }}>{{ old('admin_reply', $contactInquiry->admin_reply) }}</textarea>
                @error('admin_reply')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    {{ $contactInquiry->replied_at ? 'Update Reply' : 'Send Reply' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
