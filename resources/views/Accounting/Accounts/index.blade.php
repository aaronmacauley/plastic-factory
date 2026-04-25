@extends('layouts.master')

@section('title')
Accounts
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
    @slot('page_title') Accounts @endslot
    @slot('subtitle') List @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">📒 Chart of Accounts</h4>

                        <button class="btn btn-primary" onclick="openCreate()">
                            <i class="ti-plus"></i> Add Account
                        </button>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-rep-plugin">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                          <th>Normal Balance</th>
                                        <th width="180">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($accounts as $acc)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary px-3 py-2">
                                                {{ $acc->code }}
                                            </span>
                                        </td>

                                        <td class="text-start">
                                            {{ $acc->name }}
                                        </td>

                                        <td>
                                            {{ ucfirst($acc->type) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($acc->normal_balance) }}
                                        </td>

                                        <td>
                                            <button class="btn btn-warning btn-sm me-1" onclick="openEdit('{{ $acc->id }}','{{ $acc->code }}','{{ $acc->name }}','{{ $acc->type }}','{{ $acc->normal_balance }}')">
                                                <i class="ti-pencil"></i>
                                            </button>

                                            <button class="btn btn-danger btn-sm" onclick="deleteAccount('{{ $acc->id }}')">
                                                <i class="ti-trash"></i>
                                            </button>

                                            <form id="del-{{ $acc->id }}" action="{{ route('accounts.destroy',$acc->id) }}" method="POST" hidden>
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

    {{-- MODAL --}}
    <div class="modal fade" id="accountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">

            <form id="accountForm" method="POST">
                @csrf
                <input type="hidden" id="methodField">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Code</label>
                            <input type="text" name="code" id="code" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="asset">Asset</option>
                                <option value="liability">Liability</option>
                                <option value="equity">Equity</option>
                                <option value="revenue">Revenue</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Normal Balance</label>
                            <select name="normal_balance" id="normal_balance" class="form-control" required>
                                <option value="debit">Debit</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    @endsection


    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    <script>
        function openCreate() {
            document.getElementById('accountForm').action = "{{ route('accounts.store') }}";
            document.getElementById('methodField').value = "";

            document.getElementById('modalTitle').innerText = "Create Account";

            document.getElementById('code').value = "";
            document.getElementById('name').value = "";
            document.getElementById('type').value = "asset";

            document.getElementById('normal_balance').value = "debit";
            new bootstrap.Modal(document.getElementById('accountModal')).show();
        }

        function openEdit(id, code, name, type, normal_balance) {
            document.getElementById('accountForm').action = `/accounts/${id}`;
            document.getElementById('methodField').value = "PUT";

            document.getElementById('modalTitle').innerText = "Edit Account";
            document.getElementById('normal_balance').value = normal_balance;


            document.getElementById('code').value = code;
            document.getElementById('name').value = name;
            document.getElementById('type').value = type;

            new bootstrap.Modal(document.getElementById('accountModal')).show();
        }

        function deleteAccount(id) {
            Swal.fire({
                title: 'Delete account?'
                , text: "This data cannot be restored!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#6c757d'
                , confirmButtonText: 'Yes, delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('del-' + id).submit();
                }
            });
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success'
            , title: 'Success'
            , text: @json(session('success'))
            , timer: 2000
            , showConfirmButton: false
        });
        @endif

    </script>

    @endsection
