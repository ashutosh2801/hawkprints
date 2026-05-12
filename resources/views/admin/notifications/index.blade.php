@php
$typeLabels = [
    'order' => ['New Order', 'blue'],
    'signup' => ['New Signup', 'green'],
    'newsletter' => ['Newsletter', 'purple'],
    'contact' => ['Contact Inquiry', 'orange'],
];
@endphp

@extends('admin.layout')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div class="text-sm text-gray-500">
        {{ $notifications->total() }} total notifications
    </div>
    <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
            Mark All Read
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @forelse($notifications as $notification)
    @php
        $label = $typeLabels[$notification->type] ?? ['Unknown', 'gray'];
    @endphp
    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 flex items-start gap-4 {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-{{ $label[1] }}-100 text-{{ $label[1] }}-700">
                    {{ $label[0] }}
                </span>
                @if(!$notification->is_read)
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                @endif
                <span class="text-xs text-gray-400 ml-auto">{{ $notification->created_at->diffForHumans() }}</span>
            </div>

            @php $d = $notification->data; @endphp

            @if($notification->type === 'order')
            <p class="text-sm font-medium">Order <a href="{{ route('admin.orders.show', $d['order_id'] ?? $d['id']) }}" class="text-blue-600 hover:underline">#{{ $d['order_number'] ?? 'N/A' }}</a></p>
            <p class="text-xs text-gray-500">{{ $d['customer_name'] ?? 'Unknown' }} &mdash; ${{ number_format($d['total'] ?? 0, 2) }}</p>
            @elseif($notification->type === 'signup')
            <p class="text-sm font-medium">New customer registered</p>
            <p class="text-xs text-gray-500">{{ $d['name'] ?? 'Unknown' }} &mdash; {{ $d['email'] ?? '' }}</p>
            @elseif($notification->type === 'newsletter')
            <p class="text-sm font-medium">New newsletter subscriber</p>
            <p class="text-xs text-gray-500">{{ $d['email'] ?? '' }}</p>
            @elseif($notification->type === 'contact')
            <p class="text-sm font-medium">Contact inquiry from {{ $d['name'] ?? 'Unknown' }}</p>
            <p class="text-xs text-gray-500">{{ $d['email'] ?? '' }} &mdash; {{ $d['phone'] ?? '' }}</p>
            <p class="text-xs text-gray-400 mt-1 truncate">{{ $d['message'] ?? '' }}</p>
            @endif

            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->format('M j, Y g:i A') }}</p>
        </div>
        <div class="flex items-center gap-1 shrink-0">
            @if(!$notification->is_read)
            <button onclick="markRead({{ $notification->id }})" class="p-1.5 text-gray-400 hover:text-green-600" title="Mark read">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </button>
            @endif
            <button onclick="deleteNotif({{ $notification->id }})" class="p-1.5 text-gray-400 hover:text-red-600" title="Delete">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>
    @empty
    <div class="p-8 text-center text-gray-400">No notifications yet.</div>
    @endforelse
</div>

<div class="mt-4">
    {{ $notifications->links() }}
</div>
@endsection

@push('scripts')
<script>
function markRead(id) {
    fetch('/admin/notifications/' + id + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
        .then(r => r.json()).then(d => { if (d.success) location.reload(); });
}
function deleteNotif(id) {
    if (!confirm('Delete this notification?')) return;
    fetch('/admin/notifications/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
        .then(r => r.json()).then(d => { if (d.success) location.reload(); });
}
</script>
@endpush
