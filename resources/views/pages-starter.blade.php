@extends('layouts.master')
@section('title') Starter Page @endsection
@section('body') <body data-sidebar="dark"> @endsection
    @section('content')
    @component('components.breadcrumb')
    @slot('page_title') Starter Page @endslot
    @slot('subtitle') Extra Pages @endslot
    @endcomponent


    @endsection
    @section('scripts')

    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
