@extends('layouts.master')
@section('title') Gallery @endsection
@section('css')
<link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet">
@endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Gallery @endslot
    @slot('subtitle') Icons @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-1.jpg')}}" class="gallery-popup" title="Open Imagination">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-1.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Open Imagination</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-1.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-2.jpg')}}" class="gallery-popup" title="Locked Steel Gate">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-2.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Locked Steel Gate</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-2.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-3.jpg')}}" class="gallery-popup" title="Mac Sunglasses">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-3.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Mac Sunglasses</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-3.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-4.jpg')}}" class="gallery-popup" title="Morning Dew">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-4.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Morning Dew</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-5.jpg')}}" class="gallery-popup" title="Console Activity">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-5.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Console Activity</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-6.jpg')}}" class="gallery-popup" title="Shake It!">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-6.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Shake It!</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-6.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-7.jpg')}}" class="gallery-popup" title="Backpack Content">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-7.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Backpack Content</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-1.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-8.jpg')}}" class="gallery-popup" title="Sunset Bulb Glow">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-8.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Sunset Bulb Glow</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-2.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-9.jpg')}}" class="gallery-popup" title="Open Imagination">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-9.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Open Imagination</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-3.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-10.jpg')}}" class="gallery-popup" title="Console Activity">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-10.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Console Activity</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-4.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-11.jpg')}}" class="gallery-popup" title="Open Imagination">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-11.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Open Imagination</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-5.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->

        <div class="col-xl-3 col-md-6">
            <a href="{{URL::asset('assets/images/gallery/work-12.jpg')}}" class="gallery-popup" title="Shake It!">
                <div class="project-item">
                    <div class="overlay-container">
                        <img src="{{URL::asset('assets/images/gallery/work-12.jpg')}}" alt="img" class="gallery-thumb-img">
                        <div class="project-item-overlay">
                            <h4>Shake It!</h4>
                            <p>
                                <img src="{{URL::asset('assets/images/users/user-6.jpg')}}" alt="user" class="avatar-sm rounded-circle" />
                                <span class="ms-2">Curtis Marion</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


    @endsection
    @section('scripts')

    <!-- Magnific Popup-->
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>

    <!-- Tour init js-->
    <script src="{{URL::asset('assets/js/pages/gallery.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
