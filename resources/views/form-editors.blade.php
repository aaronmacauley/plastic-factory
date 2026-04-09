@extends('layouts.master')
@section('title') Form Editors @endsection
@section('css')
<link href="{{URL::asset('assets/libs/chartist/chartist.min.css')}}" rel="stylesheet">
@endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Form Editors @endslot
    @slot('subtitle') Form @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Tinymce wysihtml5</h4>
                    <p class="card-title-desc">Bootstrap-wysihtml5 is a javascript
                        plugin that makes it easy to create simple, beautiful wysiwyg editors
                        with the help of wysihtml5 and Twitter Bootstrap.</p>

                    <form method="post">
                        <textarea id="elm1" name="area"></textarea>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @endsection
    @section('scripts')

    <!--tinymce js-->
    <script src="{{URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

    <!-- init js -->
    <script src="{{URL::asset('assets/js/pages/form-editor.init.js')}}"></script>

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
