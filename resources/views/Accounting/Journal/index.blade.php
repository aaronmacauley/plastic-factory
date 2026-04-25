@extends('layouts.master')

@section('title')
Journal
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
@slot('page_title') Journal @endslot
@slot('subtitle') List @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">📒 Journal Entries</h4>

                    <button class="btn btn-primary" onclick="openCreate()">
                        <i class="ti-plus"></i> Create Journal
                    </button>
                </div>

                {{-- TABLE --}}
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Journal No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($journals as $j)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary px-3 py-2">
                                            {{ $j->journal_number }}
                                        </span>
                                    </td>

                                    <td>{{ $j->transaction_date }}</td>

                                    <td class="text-start">
                                        {{ $j->description }}
                                    </td>

                                    <td>
                                        <span class="badge bg-success px-3 py-2">
                                            {{ ucfirst($j->status) }}
                                        </span>
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
<div class="modal fade" id="journalModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <form id="journalForm" method="POST">
            @csrf
            <input type="hidden" id="methodField">

            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Journal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Date</label>
                            <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <h6>Journal Lines</h6>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <select name="lines[0][account_id]" class="form-control" required>
                                <option value="">Select Account</option>
                                @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">
                                    {{ $acc->code }} - {{ $acc->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="lines[0][position]" class="form-control">
                                <option value="debit">Debit</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="number" name="lines[0][amount]" class="form-control" placeholder="Amount">
                        </div>

                        <div class="col-md-3">
                            <input type="text" name="lines[0][description]" class="form-control" placeholder="Desc">
                        </div>
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
        document.getElementById('journalForm').action = "{{ route('journal.store') }}";
        document.getElementById('methodField').value = "";

        document.getElementById('modalTitle').innerText = "Create Journal";

        document.getElementById('transaction_date').value = "";
        document.getElementById('description').value = "";

        new bootstrap.Modal(document.getElementById('journalModal')).show();
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
    @endif
</script>

@endsection
