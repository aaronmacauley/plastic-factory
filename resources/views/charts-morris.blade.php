@extends('layouts.master')
@section('title') Morris Chart @endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Morris Chart @endslot
    @slot('subtitle') Morris Chart @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Line Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">25610</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">56210</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">12485</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div id="morris-line-example" class="morris-charts morris-chart-height" dir="ltr"></div>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Bar Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">6,95,412</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">1,63,542</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div id="morris-bar-example" class="morris-charts morris-chart-height" dir="ltr"></div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Area Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">86541</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">2541</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">102030</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div id="morris-area-example" class="morris-charts morris-chart-height" dir="ltr"></div>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Donut Chart</h4>


                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">3201</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">85120</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">65214</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div id="morris-donut-example" class="morris-charts morris-chart-height" dir="ltr"></div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Column Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">86541</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">2541</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">102030</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div id="morris-bar-stacked" class="morris-charts morris-chart-height" dir="ltr"></div>
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div> <!-- end col -->

    </div> <!-- end row -->

    @endsection
    @section('scripts')

    <!--Morris Chart-->
    <script src="{{URL::asset('assets/libs/morris.js/morris.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/raphael/raphael.min.js')}}"></script>

    <!-- Init js -->
    <script src="{{URL::asset('assets/js/pages/morris.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
