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
        border-radius: 12px;
    }

    .table th,
    .table td {
        vertical-align: middle;
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="mb-0 fw-bold">➕ Create Item</h4>
                            <small class="text-muted">Add new inventory item with unit conversion</small>
                        </div>

                        <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
                            ← Back
                        </a>
                    </div>

                    {{-- FORM --}}
                    <form id="itemForm" action="{{ route('items.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control shadow-sm" placeholder="ITEM-001" required>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control shadow-sm" placeholder="Item Name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Grade</label>
                                <input type="text" name="grade" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Weight</label>
                                <input type="text" name="weight" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Diameter</label>
                                <input type="text" name="diameter" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control shadow-sm" placeholder="0">
                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('items.index') }}" class="btn btn-light px-4">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                Save Item
                            </button>
                        </div>

                        <hr class="my-4">

                        {{-- UNIT CONVERSION --}}
                        <h5 class="mb-3 fw-semibold">Unit & Conversion</h5>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle shadow-sm" id="unitTable">

                                <thead class="table-light text-center">
                                    <tr>
                                        <th>Unit</th>
                                        <th>Conversion Rate</th>
                                        <th>Base</th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-success" onclick="addRow()">
                                                + Add Unit
                                            </button>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="units[0][unit_id]" class="form-select shadow-sm" required>
                                                <option value="">Select Unit</option>
                                                @foreach($units as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" step="0.0001" name="units[0][conversion_rate]" class="form-control shadow-sm" value="1" required>
                                        </td>

                                        <td class="text-center">
                                            <input type="radio" name="base_unit" value="0" checked>
                                        </td>

                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    @endsection

    @section('scripts')

 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let rowIndex = 1;

        /* ADD ROW */
        function addRow() {
            let units = @json($units);

            let options = `<option value="">Select Unit</option>`;
            units.forEach(u => {
                options += `<option value="${u.id}">${u.name}</option>`;
            });

            let row = `
    <tr>
        <td>
            <select name="units[${rowIndex}][unit_id]" class="form-select shadow-sm" required>
                ${options}
            </select>
        </td>

        <td>
            <input type="number" step="0.0001"
                   name="units[${rowIndex}][conversion_rate]"
                   class="form-control shadow-sm"
                   value="1"
                   required>
        </td>

        <td class="text-center">
            <input type="radio" name="base_unit" value="${rowIndex}">
        </td>

        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                X
            </button>
        </td>
    </tr>`;

            document.querySelector('#unitTable tbody').insertAdjacentHTML('beforeend', row);
            rowIndex++;
        }

        /* LOADING SWEETALERT ON SUBMIT */
        document.getElementById('itemForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Saving Item...'
                , text: 'Please wait'
                , allowOutsideClick: false
                , didOpen: () => {
                    Swal.showLoading();
                }
            });

            this.submit();
        });

    </script>

    {{-- GLOBAL SUCCESS ALERT (FROM TEMPLATE STYLE) --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: 'Success'
            , text: @json(session('success'))
            , timer: 2000
            , showConfirmButton: false
        });

    </script>
    @endif

    {{-- ERROR ALERT --}}
    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error'
            , title: 'Validation Error'
            , html: `{!! implode('<br>', $errors->all()) !!}`
        });

    </script>
    @endif

    @endsection
