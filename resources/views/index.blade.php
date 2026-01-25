@extends('layouts.pages')

@section('content')
{{-- Success message --}}
@if (session('success'))
    <div class="text-green-500 mb-4">
        {{ session('success') }}
    </div>
@endif

    <div class="relative bg-black z-0 min-h-screen">
        {{-- header section --}}
        <div class="bg-hero-pattern bg-cover bg-no-repeat bg-center min-h-screen">
            @include('includes.header')
            @include('includes.introduction')
        </div>
        
        {{-- about section --}}

        @include('includes.about')

        {{-- work section --}}
        @include('includes.work')

        {{-- Contact Sections --}}
        @include('includes.contact')

        {{-- Technologies used--}}
        @include('includes.techologies')

    </div>
@endsection


