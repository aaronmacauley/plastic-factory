@extends('layouts.master')
@section('title') Chartjs Chart @endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Chartjs Chart @endslot
    @slot('subtitle') Chartjs Chart @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Line Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">86541</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">2541</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">102030</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="lineChart" height="300"></canvas>

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
                                <h5 class="mb-0 font-size-20">2541</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">84845</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">12001</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="bar" height="300"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Pie Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">2536</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">69421</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">89854</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="pie" height="260"></canvas>

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
                                <h5 class="mb-0 font-size-20">9595</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">36524</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">62541</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="doughnut" height="260"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Polar Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">4852</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">3652</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">85412</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="polarArea" height="300"> </canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Radar Chart</h4>

                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">694</h5>
                                <p class="text-muted">Activated</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">55210</h5>
                                <p class="text-muted">Pending</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-center">
                                <h5 class="mb-0 font-size-20">489498</h5>
                                <p class="text-muted">Deactivated</p>
                            </div>
                        </div>
                    </div>

                    <canvas id="radar" height="300"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @endsection
    @section('scripts')

    <!-- Chart JS -->
    <script src="{{URL::asset('assets/libs/chart-js/chart-js.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/chartjs.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
