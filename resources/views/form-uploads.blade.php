@extends('layouts.master')
@section('title') Form File Upload @endsection
@section('css')
<link href="{{URL::asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet">
@endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Form File Upload @endslot
    @slot('subtitle') Forms @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Dropzone</h4>
                    <p class="card-title-desc">DropzoneJS is an open source library
                        that provides drag’n’drop file uploads with image previews.
                    </p>

                    <div class="mb-5">
                        <form action="#" class="dropzone">
                            <div class="fallback">
                                <input name="file" type="file" multiple="multiple">
                            </div>

                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="mdi mdi-cloud-upload display-4 text-muted"></i>
                                </div>

                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </form><!-- end form -->
                    </div>

                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    @endsection
    @section('scripts')

    <script src="{{URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
