@extends('admin.layout')

@section('page-title', 'Software Development Page Content')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.software-development.content.update') }}" id="contentForm">
        @csrf
        @method('PUT')

    <!-- Hero -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Hero Section</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[hero][enabled]" value="0">
                <input type="checkbox" name="settings[hero][enabled]" value="1" {{ old('settings.hero.enabled', $settings['hero']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text</label>
                <input type="text" name="settings[hero][badge]" value="{{ old('settings.hero.badge', $settings['hero']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heading Line 1</label>
                    <input type="text" name="settings[hero][heading_1]" value="{{ old('settings.hero.heading_1', $settings['hero']['heading_1'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Heading Highlight</label>
                    <input type="text" name="settings[hero][heading_2]" value="{{ old('settings.hero.heading_2', $settings['hero']['heading_2'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[hero][subtitle]" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.hero.subtitle', $settings['hero']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('stats', {{ json_encode(old('settings.stats', $settings['stats'] ?? [])) }}, {value: 0, suffix: '+', label: ''})">
        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-green-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Stats Counter</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[stats_section][enabled]" value="0">
                <input type="checkbox" name="settings[stats_section][enabled]" value="1" {{ old('settings.stats_section.enabled', $settings['stats_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="flex items-start gap-3 p-3 border rounded-lg mb-3 bg-gray-50">
                    <div class="grid grid-cols-3 gap-3 flex-1">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Value</label>
                            <input :name="'settings[stats][' + i + '][value]'" x-model="item.value" type="number" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Suffix</label>
                            <input :name="'settings[stats][' + i + '][suffix]'" x-model="item.suffix" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Label</label>
                            <input :name="'settings[stats][' + i + '][label]'" x-model="item.label" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                    </div>
                    <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded mt-5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </template>
            <button @click="add()" type="button" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">+ Add Stat</button>
        </div>
    </div>

    <!-- Services Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-purple-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Services Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[services_section][enabled]" value="0">
                <input type="checkbox" name="settings[services_section][enabled]" value="1" {{ old('settings.services_section.enabled', $settings['services_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[services_section][badge]" value="{{ old('settings.services_section.badge', $settings['services_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[services_section][heading]" value="{{ old('settings.services_section.heading', $settings['services_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[services_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.services_section.subtitle', $settings['services_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Services -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('services', {{ json_encode(old('settings.services', $settings['services'] ?? [])) }}, {enabled: true, title: '', description: '', features: []})">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-purple-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Services <span class="text-sm font-normal text-gray-500">(6 cards)</span></h3>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                    <input type="hidden" name="settings[services_section][enabled]" value="0">
                    <input type="checkbox" name="settings[services_section][enabled]" value="1" {{ old('settings.services_section.enabled', $settings['services_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                    <span class="font-medium text-gray-600">Enabled</span>
                </label>
                <button @click="add()" type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 font-medium">+ Add Service</button>
            </div>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="p-4 border rounded-lg mb-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-gray-700" x-text="'Service ' + (i + 1)"></span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="hidden" :name="'settings[services][' + i + '][enabled]'" value="0">
                                <input type="checkbox" :name="'settings[services][' + i + '][enabled]'" value="1" x-model="item.enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                                <span :class="item.enabled ? 'text-green-600' : 'text-gray-400'" x-text="item.enabled ? 'Active' : 'Disabled'" class="font-medium"></span>
                            </label>
                        </div>
                        <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Title</label>
                            <input :name="'settings[services][' + i + '][title]'" x-model="item.title" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Description</label>
                            <textarea :name="'settings[services][' + i + '][description]'" x-model="item.description" rows="2" class="w-full px-3 py-1.5 border rounded text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Features <span class="text-gray-400">(comma-separated)</span></label>
                            <input :name="'settings[services][' + i + '][features]'" :value="(item.features || []).join(', ')" @input="item.features = $event.target.value.split(',').map(s => s.trim())" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Showcase Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Work Showcase Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[showcase_section][enabled]" value="0">
                <input type="checkbox" name="settings[showcase_section][enabled]" value="1" {{ old('settings.showcase_section.enabled', $settings['showcase_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[showcase_section][badge]" value="{{ old('settings.showcase_section.badge', $settings['showcase_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[showcase_section][heading]" value="{{ old('settings.showcase_section.heading', $settings['showcase_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[showcase_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.showcase_section.subtitle', $settings['showcase_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Showcase -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('showcase', {{ json_encode(old('settings.showcase', $settings['showcase'] ?? [])) }}, {title: '', description: ''})">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Work Showcase Items</h3>
            <button @click="add()" type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 font-medium">+ Add Item</button>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="p-4 border rounded-lg mb-4 bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-sm font-semibold text-gray-700" x-text="'Item ' + (i + 1)"></span>
                        <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Title</label>
                            <input :name="'settings[showcase][' + i + '][title]'" x-model="item.title" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Description</label>
                            <textarea :name="'settings[showcase][' + i + '][description]'" x-model="item.description" rows="2" class="w-full px-3 py-1.5 border rounded text-sm"></textarea>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Process Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-sky-50 border-b border-cyan-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Process Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[process_section][enabled]" value="0">
                <input type="checkbox" name="settings[process_section][enabled]" value="1" {{ old('settings.process_section.enabled', $settings['process_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[process_section][badge]" value="{{ old('settings.process_section.badge', $settings['process_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[process_section][heading]" value="{{ old('settings.process_section.heading', $settings['process_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[process_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.process_section.subtitle', $settings['process_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Process Steps -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('process', {{ json_encode(old('settings.process', $settings['process'] ?? [])) }}, {enabled: true, title: '', description: ''})">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-sky-50 border-b border-cyan-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Process Steps</h3>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                    <input type="hidden" name="settings[process_section][enabled]" value="0">
                    <input type="checkbox" name="settings[process_section][enabled]" value="1" {{ old('settings.process_section.enabled', $settings['process_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                    <span class="font-medium text-gray-600">Enabled</span>
                </label>
                <button @click="add()" type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 font-medium">+ Add Step</button>
            </div>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="p-4 border rounded-lg mb-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-gray-700" x-text="'Step ' + (i + 1)"></span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="hidden" :name="'settings[process][' + i + '][enabled]'" value="0">
                                <input type="checkbox" :name="'settings[process][' + i + '][enabled]'" value="1" x-model="item.enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                                <span :class="item.enabled ? 'text-green-600' : 'text-gray-400'" x-text="item.enabled ? 'Active' : 'Disabled'" class="font-medium"></span>
                            </label>
                        </div>
                        <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Title</label>
                            <input :name="'settings[process][' + i + '][title]'" x-model="item.title" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Description</label>
                            <textarea :name="'settings[process][' + i + '][description]'" x-model="item.description" rows="2" class="w-full px-3 py-1.5 border rounded text-sm"></textarea>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Why Choose Us Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Why Choose Us Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[why_section][enabled]" value="0">
                <input type="checkbox" name="settings[why_section][enabled]" value="1" {{ old('settings.why_section.enabled', $settings['why_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[why_section][badge]" value="{{ old('settings.why_section.badge', $settings['why_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[why_section][heading]" value="{{ old('settings.why_section.heading', $settings['why_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[why_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.why_section.subtitle', $settings['why_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Items -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('why', {{ json_encode(old('settings.why', $settings['why'] ?? [])) }}, {enabled: true, title: '', description: ''})">
        <div class="px-6 py-4 bg-gradient-to-r from-rose-50 to-pink-50 border-b border-rose-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Why Choose Us Items</h3>
            <button @click="add()" type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 font-medium">+ Add Item</button>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="p-4 border rounded-lg mb-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-gray-700" x-text="'Item ' + (i + 1)"></span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="hidden" :name="'settings[why][' + i + '][enabled]'" value="0">
                                <input type="checkbox" :name="'settings[why][' + i + '][enabled]'" value="1" x-model="item.enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                                <span :class="item.enabled ? 'text-green-600' : 'text-gray-400'" x-text="item.enabled ? 'Active' : 'Disabled'" class="font-medium"></span>
                            </label>
                        </div>
                        <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Title</label>
                            <input :name="'settings[why][' + i + '][title]'" x-model="item.title" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Description</label>
                            <textarea :name="'settings[why][' + i + '][description]'" x-model="item.description" rows="2" class="w-full px-3 py-1.5 border rounded text-sm"></textarea>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Tech Stack Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-indigo-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Tech Stack Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[tech_section][enabled]" value="0">
                <input type="checkbox" name="settings[tech_section][enabled]" value="1" {{ old('settings.tech_section.enabled', $settings['tech_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[tech_section][badge]" value="{{ old('settings.tech_section.badge', $settings['tech_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[tech_section][heading]" value="{{ old('settings.tech_section.heading', $settings['tech_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[tech_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.tech_section.subtitle', $settings['tech_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Tech Stack Categories -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-indigo-100">
            <h3 class="text-lg font-bold text-gray-800">Tech Stack Categories</h3>
        </div>
        <div class="p-6 space-y-4">
            @php
                $techKeys = ['Frontend', 'Backend & APIs', 'Mobile', 'DevOps & Cloud', 'Databases'];
            @endphp
            @foreach($techKeys as $tkey)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $tkey }}</label>
                <input type="text" name="settings[tech][{{ $tkey }}]" value="{{ old('settings.tech.' . $tkey, isset($settings['tech'][$tkey]) ? (is_array($settings['tech'][$tkey]) ? implode(', ', $settings['tech'][$tkey]) : $settings['tech'][$tkey]) : '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Comma-separated values">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Testimonials Section Heading -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-teal-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Testimonials Section Heading</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[testimonials_section][enabled]" value="0">
                <input type="checkbox" name="settings[testimonials_section][enabled]" value="1" {{ old('settings.testimonials_section.enabled', $settings['testimonials_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[testimonials_section][badge]" value="{{ old('settings.testimonials_section.badge', $settings['testimonials_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[testimonials_section][heading]" value="{{ old('settings.testimonials_section.heading', $settings['testimonials_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[testimonials_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.testimonials_section.subtitle', $settings['testimonials_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden" x-data="repeater('testimonials', {{ json_encode(old('settings.testimonials', $settings['testimonials'] ?? [])) }}, {enabled: true, name: '', role: '', text: '', rating: 5, initials: ''})">
        <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-teal-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Testimonials</h3>
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                    <input type="hidden" name="settings[testimonials_section][enabled]" value="0">
                    <input type="checkbox" name="settings[testimonials_section][enabled]" value="1" {{ old('settings.testimonials_section.enabled', $settings['testimonials_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                    <span class="font-medium text-gray-600">Enabled</span>
                </label>
                <button @click="add()" type="button" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 font-medium">+ Add Testimonial</button>
            </div>
        </div>
        <div class="p-6">
            <template x-for="(item, i) in items" :key="i">
                <div class="p-4 border rounded-lg mb-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-gray-700" x-text="'Testimonial ' + (i + 1)"></span>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                <input type="hidden" :name="'settings[testimonials][' + i + '][enabled]'" value="0">
                                <input type="checkbox" :name="'settings[testimonials][' + i + '][enabled]'" value="1" x-model="item.enabled" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5">
                                <span :class="item.enabled ? 'text-green-600' : 'text-gray-400'" x-text="item.enabled ? 'Active' : 'Disabled'" class="font-medium"></span>
                            </label>
                        </div>
                        <button @click="remove(i)" type="button" class="p-1.5 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Name</label>
                            <input :name="'settings[testimonials][' + i + '][name]'" x-model="item.name" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Role</label>
                            <input :name="'settings[testimonials][' + i + '][role]'" x-model="item.role" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-500 mb-1">Text</label>
                            <textarea :name="'settings[testimonials][' + i + '][text]'" x-model="item.text" rows="2" class="w-full px-3 py-1.5 border rounded text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Rating (1-5)</label>
                            <input :name="'settings[testimonials][' + i + '][rating]'" x-model="item.rating" type="number" min="1" max="5" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Initials</label>
                            <input :name="'settings[testimonials][' + i + '][initials]'" x-model="item.initials" maxlength="2" class="w-full px-3 py-1.5 border rounded text-sm">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Call to Action</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[cta][enabled]" value="0">
                <input type="checkbox" name="settings[cta][enabled]" value="1" {{ old('settings.cta.enabled', $settings['cta']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[cta][heading]" value="{{ old('settings.cta.heading', $settings['cta']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[cta][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.cta.subtitle', $settings['cta']['subtitle'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                <input type="text" name="settings[cta][button_text]" value="{{ old('settings.cta.button_text', $settings['cta']['button_text'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-100 to-slate-100 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Contact Form Section</h3>
            <label class="flex items-center gap-2 cursor-pointer text-sm">
                <input type="hidden" name="settings[contact_section][enabled]" value="0">
                <input type="checkbox" name="settings[contact_section][enabled]" value="1" {{ old('settings.contact_section.enabled', $settings['contact_section']['enabled'] ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="font-medium text-gray-600">Enabled</span>
            </label>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge</label>
                <input type="text" name="settings[contact_section][badge]" value="{{ old('settings.contact_section.badge', $settings['contact_section']['badge'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="settings[contact_section][heading]" value="{{ old('settings.contact_section.heading', $settings['contact_section']['heading'] ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <textarea name="settings[contact_section][subtitle]" rows="2" class="w-full px-4 py-2 border rounded-lg">{{ old('settings.contact_section.subtitle', $settings['contact_section']['subtitle'] ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="sticky bottom-6 z-10 flex items-center gap-4 bg-white rounded-xl shadow-lg border border-gray-200 p-4">
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-sm shadow-blue-200">Save All Changes</button>
        <a href="{{ route('admin.software-development') }}" class="text-gray-600 hover:text-gray-800 text-sm font-medium">Cancel</a>
    </div>
    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('repeater', (key, initial, blank) => ({
        items: initial.map(item => {
            if ('enabled' in item) {
                item.enabled = item.enabled === true || item.enabled === 1 || item.enabled === '1';
            }
            return item;
        }),
        add() {
            this.items.push(JSON.parse(JSON.stringify(blank)));
        },
        remove(i) {
            this.items.splice(i, 1);
        }
    }));
});
</script>
@endsection