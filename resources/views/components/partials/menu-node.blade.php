@php
    $children = $allItems->where('parent_id', $item->id);
    $hasChildren = $children->count() > 0;
@endphp

@if($level === 0)
    @if($hasChildren)
    <div class="relative group">
        <a href="{{ $item->effective_slug }}"
           class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors flex items-center gap-1.5 whitespace-nowrap">
            {{ $item->effective_name }}
            <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
        <div class="absolute left-0 top-full pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="z-index: 9999;">
            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-56">
                @foreach($children as $child)
                    @include('components.partials.menu-node', ['item' => $child, 'allItems' => $allItems, 'level' => 1])
                @endforeach
            </div>
        </div>
    </div>
    @else
    <a href="{{ $item->effective_slug }}"
       class="px-4 py-3.5 text-sm font-medium text-gray-700 hover:text-blue-700 transition-colors whitespace-nowrap">
        {{ $item->effective_name }}
    </a>
    @endif
@else
    @if($hasChildren)
    <div class="relative group px-4 py-2.5 text-gray-700 hover:bg-blue-50 transition-colors flex items-center justify-between">
        <a href="{{ $item->effective_slug }}" class="flex-1 hover:text-blue-700">
            {{ $item->effective_name }}
        </a>
        <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <div class="absolute left-full top-0 pl-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="z-index: 9999;">
            <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-56">
                @foreach($children as $child)
                    @include('components.partials.menu-node', ['item' => $child, 'allItems' => $allItems, 'level' => 2])
                @endforeach
            </div>
        </div>
    </div>
    @else
    <a href="{{ $item->effective_slug }}"
       class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
        {{ $item->effective_name }}
    </a>
    @endif
@endif
