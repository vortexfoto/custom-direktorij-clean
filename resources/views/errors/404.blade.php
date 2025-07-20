@extends('layouts.frontend')
@push('title', get_phrase('404 not found'))
@push('meta')@endpush
@section('frontend_layout')
    <!-- Start About Us -->
    <section class="pb-120 pt-30 description-style mt-5 mb-5">
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="{{asset('assets/frontend/images/404.png')}}" alt="">
                </div>
                <div class="col-md-6 ms-auto">
                    <h1 class="g-title fs-28px mb-2 mt-5 capitalize">{{get_phrase('404 not found')}}</h1>
                    <p class="g-text fw-bold mb-2">{{get_phrase('The page you requested could not be found')}}</p>
                    <p class="mb-4 fw-bold">{{get_phrase('Please try the following')}}:</p>
                    <ul class="list-styled">
                        <li class="mb-2">{{get_phrase('Check the spelling of the url')}}</li>
                        <li>{{get_phrase('If you are still puzzled, click on the home link below')}}</li>
                    </ul>
                  
                    <a class="add-listing-btn w-120px mt-5" href="{{route('home')}}">{{get_phrase('Back to home')}}</a>
                   
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us -->
@endsection

