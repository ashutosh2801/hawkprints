@extends('layouts.app')

@section('title', 'Five Rivers Print - Shop for All Your Printing Needs')
@section('meta_description', 'One stop for all your printing needs. Business cards, banners, sublimation, flyers, and more quality printing services at competitive prices.')

@section('content')
    @include('front.partials.hero')

    @include('front.partials.categories')

    @include('front.partials.featured-products')

    @include('front.partials.explore-categories')

    @include('front.partials.new-arrivals')

    @include('front.partials.all-categories')

    @include('front.partials.about')

    @include('front.partials.testimonials')

    @include('front.partials.clients')
@endsection