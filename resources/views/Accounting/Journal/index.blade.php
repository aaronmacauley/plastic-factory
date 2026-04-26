@extends('layouts.master')

@section('title')
Journal
@endsection

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
.table td, .table th {
    vertical-align: middle;
}

.erp-card {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
}

.table thead {
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 2;
}

.loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.badge-journal {
    background: #1f2937;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.badge-journal:hover {
    transform: scale(1.05);
}

.detail-row {
    display: none;
    background: #f9fafb;
}

.detail-box {
    padding: 10px;
    border-left: 3px solid #6366f1;
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

<div class="card erp-card">
<div class="card-body position-relative">

    {{-- LOADING --}}
    <div class="loading-overlay" id="loading">
        Loading journal...
    </div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">📒 Journal Entries</h4>
            <small class="text-muted">Click journal number to view details</small>
        </div>

        <button class="btn btn-primary" onclick="openCreate()">
            <i class="ti-plus"></i> Create
        </button>
    </div>

    {{-- FILTER --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="date" id="from_date" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" id="to_date" class="form-control">
        </div>
        <div class="col-md-4">
            <input type="text" id="search" class="form-control" placeholder="Search journal / description">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">Reset</button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-rep-plugin">
        <div class="table-responsive" style="max-height:500px; overflow:auto;">
            <table class="table table-hover table-bordered align-middle text-center">

                <thead>
                    <tr>
                        <th>Journal No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($journals as $j)

                {{-- MAIN ROW --}}
                <tr onclick="toggleDetail('{{ $j->id }}')" style="cursor:pointer;">
                    <td>
                        <span class="badge badge-journal px-3 py-2">
                            {{ $j->journal_number }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($j->transaction_date)->format('d M Y') }}
                    </td>

                    <td class="text-start">
                        {{ $j->description }}
                    </td>

                    <td>
                        <span class="badge bg-success px-3 py-2">
                            {{ ucfirst($j->status) }}
                        </span>
                    </td>
                </tr>

                {{-- DETAIL ROW --}}
                <tr id="detail-{{ $j->id }}" class="detail-row">
                    <td colspan="4">
                        <div class="detail-box text-start">

                            <strong>Journal Lines</strong>
                            <hr>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Account</th>
                                        <th>Position</th>
                                        <th class="text-end">Amount</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($j->lines as $line)
                                    <tr>
                                        <td>{{ $line->account->code ?? '-' }} - {{ $line->account->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $line->position == 'debit' ? 'primary' : 'danger' }}">
                                                {{ ucfirst($line->position) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($line->amount,0,',','.') }}
                                        </td>
                                        <td>{{ $line->description }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="py-5 text-muted">
                        No Journal Found
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

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>

/* LOADING */
document.addEventListener("DOMContentLoaded", function () {
    let loader = document.getElementById('loading');
    loader.style.display = "flex";
    setTimeout(() => loader.style.display = "none", 500);
});

/* TOGGLE DETAIL */
function toggleDetail(id) {
    let el = document.getElementById('detail-' + id);
    if (el.style.display === 'table-row') {
        el.style.display = 'none';
    } else {
        el.style.display = 'table-row';
    }
}

/* FILTER SIMPLE */
document.getElementById('search').addEventListener('keyup', filterTable);
document.getElementById('from_date').addEventListener('change', filterTable);
document.getElementById('to_date').addEventListener('change', filterTable);

function filterTable() {
    let search = document.getElementById('search').value.toLowerCase();

    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
}

/* RESET */
function resetFilter() {
    document.getElementById('search').value = '';
    document.getElementById('from_date').value = '';
    document.getElementById('to_date').value = '';
    filterTable();
}

/* CREATE */
function openCreate() {
    window.location.href = "{{ route('journal.create') }}";
}

</script>
@endsection
