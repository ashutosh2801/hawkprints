@extends('layouts.app')

@section('title', 'Hawk Prints - Shop for All Your Printing Needs')

@section('content')
    @php
        $homeSections = \App\Models\HomePageSection::active()->ordered()->get();
    @endphp

    @forelse($homeSections as $section)
        @include('front.partials.' . $section->key, $section->settings ?? [])
    @empty
        {{-- Fallback to default sections if none configured --}}
        @include('front.partials.hero')
        @include('front.partials.categories')
        @include('front.partials.featured-products')
        @include('front.partials.explore-categories')
        @include('front.partials.all-categories')
        @include('front.partials.new-arrivals')
        @include('front.partials.about')
        @include('front.partials.testimonials')
        @include('front.partials.clients')
    @endforelse
@endsection
