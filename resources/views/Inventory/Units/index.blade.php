@extends('layouts.master')
@section('title')
Units
@endsection

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .table td,
    .table th {
        vertical-align: middle;
    }

</style>
@endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Units @endslot
    @slot('subtitle') List @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- HEADER -->
                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">📦 Unit Management</h4>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUnitModal">
                            <i class="ti-plus"></i> Add Unit
                        </button>
                    </div>


                    <!-- TABLE -->
                    <div class="table-rep-plugin">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th width="180">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($units as $index => $unit)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <span class="badge bg-primary px-3 py-2">
                                                {{ $unit->code }}
                                            </span>
                                        </td>

                                        <td class="text-start">
                                            {{ $unit->name }}
                                        </td>

                                        <td>
                                            <button class="btn btn-warning btn-sm me-1" onclick="openEditModal('{{ $unit->id }}', '{{ $unit->code }}', '{{ $unit->name }}')">
                                                <i class="ti-pencil"></i>
                                            </button>

                                            <button onclick="deleteUnit('{{ $unit->id }}')" class="btn btn-danger btn-sm">
                                                <i class="ti-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $unit->id }}" action="{{ route('units.destroy', $unit->id) }}" method="POST" hidden>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center py-4">
                                                <h5 class="text-muted">No Data Found 😢</h5>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editUnitModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editUnitForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" id="edit_code" name="code" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- CREATE MODAL -->
    <div class="modal fade" id="createUnitModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Create Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="unitForm" action="{{ route('units.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <!-- CODE -->
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g PCS, KG" required>
                        </div>

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g Pieces, Kilogram" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    @endsection

    @section('scripts')
    <script>
        function openEditModal(id, code, name) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_name').value = name;

            // set form action dynamic
            document.getElementById('editUnitForm').action = `/inventory/units/${id}`;

            let modal = new bootstrap.Modal(document.getElementById('editUnitModal'));
            modal.show();
        }

        document.getElementById('editUnitForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Update Unit?'
                , text: "Data akan diperbarui"
                , icon: 'question'
                , showCancelButton: true
                , confirmButtonText: 'Yes, Update'
                , cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Updating...'
                        , allowOutsideClick: false
                        , didOpen: () => Swal.showLoading()
                    });

                    this.submit();
                }
            });
        });

        document.getElementById('unitForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Save Unit?'
                , text: "Pastikan data sudah benar"
                , icon: 'question'
                , showCancelButton: true
                , confirmButtonText: 'Yes, Save'
                , cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Saving...'
                        , text: 'Please wait'
                        , allowOutsideClick: false
                        , didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    this.submit();
                }
            });
        });

    </script>

    <script src="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 

    <script>
        function deleteUnit(id) {
            Swal.fire({
                title: 'Yakin hapus?'
                , text: "Data tidak bisa dikembalikan!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#6c757d'
                , confirmButtonText: 'Ya, hapus!'
                , cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Success alert (global template style)
        @if(session('success'))
        Swal.fire({
            icon: 'success'
            , title: 'Berhasil'
            , text: '{{ session('
            success ') }}'
            , timer: 2000
            , showConfirmButton: false
        })
        @endif

    </script>
    @endsection
