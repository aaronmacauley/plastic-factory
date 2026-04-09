@extends('layouts.master')
@section('title') Vector Map @endsection
@section('css')
<!-- plugin css -->
<link href="assets/libs/jquery-vectormap/jquery-vectormap.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Vector Map @endslot
    @slot('subtitle') Maps @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">World Map</h4>
                    <p class="card-title-desc">Example of vector map.</p>

                    <div id="world-map-markers" style="height: 420px"></div>

                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">USA Map</h4>
                    <p class="card-title-desc">Example of vector map.</p>

                    <div id="usa-vectormap" style="height: 420px"></div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">UK Map</h4>
                    <p class="card-title-desc">Example of vector map.</p>

                    <div id="uk-vectormap" style="height: 420px"></div>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Chicago Map</h4>
                    <p class="card-title-desc">Example of vector map.</p>

                    <div id="chicago-vectormap" style="height: 420px"></div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @endsection
    @section('scripts')

    <!-- Plugins js-->
    <script src="{{URL::asset('assets/libs/jquery-vectormap/jquery-vectormap.min.js')}}"></script>

    <!-- Init js-->
    <script src="{{URL::asset('assets/js/pages/vector-maps.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
