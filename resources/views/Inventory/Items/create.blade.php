@extends('layouts.master')

@section('title')
Create Item
@endsection

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">

<style>
    .form-label {
        font-weight: 500;
    }

    .card {
        border-radius: 10px;
    }

</style>
@endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Items @endslot
    @slot('subtitle') Create @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">➕ Create Item</h4>

                        <a href="{{ route('items.index') }}" class="btn btn-light">
                            ← Back
                        </a>
                    </div>

                    {{-- FORM --}}
                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" placeholder="ITEM-001" required>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Item Name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Grade</label>
                                <input type="text" name="grade" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="text" name="weight" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Diameter</label>
                                <input type="text" name="diameter" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="0">
                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">

                            <a href="{{ route('items.index') }}" class="btn btn-light">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save Item
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="{{URL::asset('assets/js/app.js')}}"></script>
    @endsection
