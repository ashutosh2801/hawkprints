@extends('layouts.app')

@section('title', 'Hawk Prints - Shop for All Your Printing Needs')

@section('content')
    @include('front.partials.hero')
    @include('front.partials.categories')
    @include('front.partials.featured-products')
    @include('front.partials.explore-categories')
    @include('front.partials.all-categories')
    @include('front.partials.about')
    @include('front.partials.testimonials')
    @include('front.partials.clients')
@endsection