@extends('layouts.pages')

@section('content')
    <div class="relative bg-black z-0 min-h-screen">
        {{-- header section --}}
        <div class="bg-hero-pattern bg-cover bg-no-repeat bg-center min-h-screen">
            @include('includes.header')
        </div>
        
        {{-- about section --}}

        @include('includes.about')

    </div>
@endsection


