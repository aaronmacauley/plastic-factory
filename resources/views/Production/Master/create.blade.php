@extends('layouts.master')
@section('title') Create Production @endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Production @endslot
    @slot('subtitle') Create @endslot
    @endcomponent

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form id="productionForm" action="{{ route('production.store') }}" method="POST">
                @csrf

                <!-- HEADER -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Product</label>
                        <select id="itemSelect" name="item_id" class="form-select">
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>BOM</label>
                        <select id="bomSelect" name="bom_id" class="form-select">
                            @foreach($boms as $bom)
                            <option value="{{ $bom->id }}">{{ $bom->version }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Qty</label>
                        <input type="number" name="qty" class="form-control">
                    </div>
                </div>

                <!-- MATERIAL AUTO -->
                <h5>📦 Materials</h5>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="materialPreview"></tbody>
                </table>

                <!-- OPERATIONS -->
                <h5>⚙️ Operations</h5>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Machine</th>
                            <th>Hours</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <tbody id="operationPreview"></tbody>
                </table>

                <div class="text-end">
                    <button class="btn btn-success">Start Production</button>
                </div>

            </form>

        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    <script>
        // 👉 nanti ini bisa AJAX ke controller
        document.getElementById('bomSelect').addEventListener('change', function() {
            let bomId = this.value;

            fetch(`/api/bom/${bomId}`)
                .then(res => res.json())
                .then(data => {

                    // MATERIAL
                    let materialHtml = '';
                    data.details.forEach(d => {
                        materialHtml += `
                    <tr>
                        <td>${d.item.name}</td>
                        <td>${d.qty}</td>
                    </tr>`;
                    });
                    document.getElementById('materialPreview').innerHTML = materialHtml;

                    // OPERATIONS
                    let opHtml = '';
                    data.operations.forEach(o => {
                        opHtml += `
                    <tr>
                        <td>${o.machine.name}</td>
                        <td>${o.hours}</td>
                        <td>${o.cost_per_hour}</td>
                    </tr>`;
                    });
                    document.getElementById('operationPreview').innerHTML = opHtml;

                });
        });

    </script>
    @endsection
