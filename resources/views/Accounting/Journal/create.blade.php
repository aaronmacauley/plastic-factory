@extends('layouts.master')

@section('title')
Create Journal
@endsection

@section('content')

@component('components.breadcrumb')
@slot('page_title') Journal @endslot
@slot('subtitle') Create @endslot
@endcomponent

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form action="{{ route('journal.store') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label>Date</label>
                <input type="date" name="transaction_date" class="form-control" required>
            </div>

            <div class="mb-2">
                <label>Description</label>
                <input type="text" name="description" class="form-control">
            </div>

            <button class="btn btn-success mt-3">
                Save Journal
            </button>

        </form>

    </div>
</div>

@endsection
