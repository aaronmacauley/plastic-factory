@extends('layouts.master')
@section('title') Machines @endsection

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .table td,
    .table th {
        vertical-align: middle;
    }

    .machine-badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
    }

</style>
@endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Machines @endslot
    @slot('subtitle') List @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">⚙️ Machine Management</h4>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMachineModal">
                            <i class="ti-plus"></i> Add Machine
                        </button>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Cost / Hour</th>
                                    <th>Status</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($machines as $index => $machine)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <span class="badge bg-dark px-3 py-2">
                                            {{ $machine->code }}
                                        </span>
                                    </td>

                                    <td class="text-start">
                                        {{ $machine->name }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($machine->cost_per_hour,0,',','.') }}
                                    </td>

                                    <td>
                                        @if($machine->is_active)
                                        <span class="badge bg-success machine-badge">Active</span>
                                        @else
                                        <span class="badge bg-danger machine-badge">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button onclick="editMachine('{{ $machine->id }}','{{ $machine->code }}','{{ $machine->name }}','{{ $machine->cost_per_hour }}','{{ $machine->is_active }}')" class="btn btn-warning btn-sm">
                                            <i class="ti-pencil"></i>
                                        </button>

                                        <button onclick="deleteMachine('{{ $machine->id }}')" class="btn btn-danger btn-sm">
                                            <i class="ti-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $machine->id }}" action="{{ route('machines.destroy',$machine->id) }}" method="POST" hidden>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center py-4">
                                            <h5 class="text-muted">No Machine Found 😢</h5>
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

    <!-- ================= CREATE MODAL ================= -->
    <div class="modal fade" id="createMachineModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Create Machine</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="createForm" action="{{ route('machines.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Cost / Hour</label>
                            <input type="number" name="cost_per_hour" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= EDIT MODAL ================= -->
    <div class="modal fade" id="editMachineModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5>Edit Machine</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label>Code</label>
                            <input type="text" name="code" id="edit_code" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Cost / Hour</label>
                            <input type="number" name="cost_per_hour" id="edit_cost" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="is_active" id="edit_status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    @endsection

    @section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // CREATE CONFIRM
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Save Machine?'
                , icon: 'question'
                , showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    this.submit();
                }
            })
        });

        // DELETE
        function deleteMachine(id) {
            Swal.fire({
                title: 'Delete?'
                , text: 'Cannot be undone!'
                , icon: 'warning'
                , showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // EDIT
        function editMachine(id, code, name, cost, status) {
            $('#editMachineModal').modal('show');

            document.getElementById('editForm').action = '/machines/' + id;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_cost').value = cost;
            document.getElementById('edit_status').value = status;
        }

        // SUCCESS ALERT
        @if(session('success'))
        Swal.fire({
            icon: 'success'
            , title: 'Success'
            , text: '{{ session('
            success ') }}'
            , timer: 2000
            , showConfirmButton: false
        })
        @endif

    </script> 
    @endsection
