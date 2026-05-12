@extends('admin.layout')

@section('page-title', 'Software Request - ' . $softwareDevelopmentRequest->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Request Details</h1>
        <a href="{{ route('admin.software-development') }}" class="text-blue-600 hover:text-blue-800">← Back to List</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Client Info</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-500 block">Name</span>
                    <span class="font-medium">{{ $softwareDevelopmentRequest->name }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Email</span>
                    <a href="mailto:{{ $softwareDevelopmentRequest->email }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $softwareDevelopmentRequest->email }}</a>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Phone</span>
                    <span class="font-medium">{{ $softwareDevelopmentRequest->phone ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Company</span>
                    <span class="font-medium">{{ $softwareDevelopmentRequest->company ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Received</span>
                    <span class="font-medium">{{ $softwareDevelopmentRequest->created_at->format('F d, Y g:i A') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Service Details</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-500 block">Service</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @switch($softwareDevelopmentRequest->service)
                            @case('web_development') bg-blue-100 text-blue-800 @break
                            @case('mobile_development') bg-green-100 text-green-800 @break
                            @case('ux_ui_design') bg-purple-100 text-purple-800 @break
                            @case('custom_software') bg-orange-100 text-orange-800 @break
                            @case('cloud_solutions') bg-cyan-100 text-cyan-800 @break
                            @case('consulting') bg-rose-100 text-rose-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        {{ str_replace('_', ' ', ucwords($softwareDevelopmentRequest->service, '_')) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Budget</span>
                    <span class="font-medium">{{ $softwareDevelopmentRequest->budget ? '$' . number_format($softwareDevelopmentRequest->budget, 0) : 'Not specified' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-500 block">Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @switch($softwareDevelopmentRequest->status)
                            @case('pending') bg-yellow-100 text-yellow-800 @break
                            @case('contacted') bg-green-100 text-green-800 @break
                            @case('closed') bg-gray-100 text-gray-800 @break
                        @endswitch
                    ">
                        {{ ucfirst($softwareDevelopmentRequest->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold mb-4">Project Details</h3>
        <div class="bg-gray-50 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $softwareDevelopmentRequest->message }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold mb-4">Update Status</h3>
        <form method="POST" action="{{ route('admin.software-development.status', $softwareDevelopmentRequest) }}" class="flex items-center gap-4">
            @csrf
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="pending" {{ $softwareDevelopmentRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="contacted" {{ $softwareDevelopmentRequest->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="closed" {{ $softwareDevelopmentRequest->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Update</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4">Admin Notes</h3>
        <form method="POST" action="{{ route('admin.software-development.notes', $softwareDevelopmentRequest) }}">
            @csrf
            <div class="mb-4">
                <textarea name="admin_notes" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Add internal notes about this request...">{{ $softwareDevelopmentRequest->admin_notes }}</textarea>
                @error('admin_notes')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Save Notes</button>
        </form>
    </div>
</div>
@endsection
