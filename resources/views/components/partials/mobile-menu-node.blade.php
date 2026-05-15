@php
    $children = $allItems->where('parent_id', $item->id);
    $hasChildren = $children->count() > 0;
@endphp

@if($hasChildren)
<div x-data="{ open: false }">
    <div class="flex items-center justify-between px-4 py-2.5 rounded-lg transition-colors hover:bg-gray-50">
        <a href="{{ $item->effective_slug }}" class="flex-1 text-sm font-medium text-gray-700 hover:text-blue-700">
            {{ $item->effective_name }}
        </a>
        <button @click="open = !open" class="p-1 text-gray-400 hover:text-blue-700 transition-colors">
            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>
    <div x-show="open" x-cloak class="ml-4 border-l border-gray-200 pl-4">
        @foreach($children as $child)
            @include('components.partials.mobile-menu-node', ['item' => $child, 'allItems' => $allItems])
        @endforeach
    </div>
</div>
@else
<a href="{{ $item->effective_slug }}"
   class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-blue-700 rounded-lg transition-colors">
    {{ $item->effective_name }}
</a>
@endif
