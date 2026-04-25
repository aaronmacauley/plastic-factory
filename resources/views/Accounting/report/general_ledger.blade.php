@extends('layouts.master')

@section('title','General Ledger')

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">

<style>
    .erp-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    }

    .account-header {
        background: #111827;
        color: #fff;
        padding: 10px;
        border-radius: 8px;
    }

    .table thead {
        background: #f3f4f6;
    }

    .balance-col {
        font-weight: bold;
        color: #111827;
    }

    .small-text {
        font-size: 12px;
        color: #6b7280;
    }

</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('page_title') General Ledger @endslot
@slot('subtitle') Buku Besar @endslot
@endcomponent



{{-- FILTER --}}
<div class="card erp-card mb-3">
    <div class="card-body">

        <form method="GET" class="row g-2">

            <div class="col-md-4">
                <select name="account_id" class="form-control">
                    <option value="">All Accounts</option>
                    @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">
                        {{ $acc->code }} - {{ $acc->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="date" name="from" class="form-control">
            </div>

            <div class="col-md-3">
                <input type="date" name="to" class="form-control">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>

        </form>

    </div>
</div>

{{-- LEDGER --}}
@foreach($ledger as $data)

<div class="card erp-card mb-4">

    <div class="account-header">
        <strong>{{ $data['account']->code }} - {{ $data['account']->name }}</strong>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Journal</th>
                        <th>Description</th>
                        <th class="text-end">Debit</th>
                        <th class="text-end">Credit</th>
                        <th class="text-end">Balance</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data['lines'] as $line)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($line['date'])->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-dark">
                                {{ $line['journal_no'] }}
                            </span>
                        </td>
                        <td class="text-start">{{ $line['description'] }}</td>

                        <td class="text-end text-success">
                            {{ number_format($line['debit'],0,',','.') }}
                        </td>

                        <td class="text-end text-danger">
                            {{ number_format($line['credit'],0,',','.') }}
                        </td>

                        <td class="text-end balance-col">
                            {{ number_format($line['balance'],0,',','.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>

@endforeach

@endsection
@section('scripts')
<script src="{{ asset('assets/js/app.js') }}"></script>

@endsection
