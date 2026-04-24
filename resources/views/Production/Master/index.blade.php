@extends('layouts.master')
@section('title') Production List @endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Production @endslot
    @slot('subtitle') List @endslot
    @endcomponent

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold">🏭 Production List</h5>

                <a href="{{ route('production.create') }}" class="btn btn-primary">
                    + Create Production
                </a>
            </div>

            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($productions as $i => $p)
                    <tr>

                        <td>{{ $i+1 }}</td>

                        <td>{{ $p->item->name }}</td>

                        <td>{{ $p->production_date }}</td>

                        <td>
                            <strong>{{ number_format($p->total_cost,2) }}</strong>
                        </td>

                        <td>
                            @if($p->status == 0)
                            <span class="badge bg-secondary">Draft</span>
                            @elseif($p->status == 1)
                            <span class="badge bg-warning">In Progress</span>
                            @else
                            <span class="badge bg-success">Finished</span>
                            @endif
                        </td>

                        <td>

                            @if($p->status == 0)
                            <form action="/production/{{ $p->id }}/start" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-success">Start</button>
                            </form>
                            @endif

                            @if($p->status == 1)
                            <form action="/production/{{ $p->id }}/finish" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary">Finish</button>
                            </form>
                            @endif

                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

    @endsection
