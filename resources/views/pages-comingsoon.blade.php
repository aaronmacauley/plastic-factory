@extends('layouts.master-without-nav')
@section('title') Commingsoon @endsection
@section('body') <body> @endsection
    @section('content')

    <div class="home-btn d-none d-sm-block">
        <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <!-- Begin page -->
    <div class="authentication-bg d-flex align-items-center pb-0 vh-100">
        <div class="content-center w-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="home-wrapper text-center">
                            <a href="index" class="logo-dark">
                                <span class="logo-lg">
                                    <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="22">
                                </span>
                            </a>

                            <a href="index" class="logo-light">
                                <span class="logo-lg">
                                    <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="22">
                                </span>
                            </a>
                            <h3 class="mt-4">Let's get started with Veltrix</h3>
                            <p class="mb-5">It will be as simple as Occidental in fact it will be Occidental.</p>

                            <div class="row justify-content-center mt-5">
                                <div class="col-md-8">
                                    <div data-countdown="2024/12/31" class="counter-number"></div>
                                </div> <!-- end col-->
                            </div>
                            <!-- end row -->
                            <div class="text-center coming-soon-search-form pt-4">
                                <form action="#">
                                    <input type="text" placeholder="Enter email address">
                                    <button type="submit" class="btn btn-primary">Subscribe</button>
                                </form>
                                <!-- end form -->
                            </div>
                        </div>
                        <!-- end home wrapper -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
    </div>

    @endsection
    @section('scripts')

    <!-- Plugins js-->
    <script src="{{URL::asset('assets/libs/jquery-countdown/jquery-countdown.min.js')}}"></script>

    <!-- Countdown js -->
    <script src="{{URL::asset('assets/js/pages/coming-soon.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
