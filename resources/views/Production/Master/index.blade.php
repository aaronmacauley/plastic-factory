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

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-0">🏭 Production List</h5>
                <small class="text-muted">Manage & monitor production flow</small>
            </div>

            <a href="{{ route('production.create') }}" class="btn btn-primary shadow-sm">
                + Create Production
            </a>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th class="text-start">Product</th>
                        <th>Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($productions as $i => $p)
                    <tr>
                        <td>{{ $i+1 }}</td>

                        <td class="text-start">
                            <strong>{{ $p->item->name }}</strong>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                {{ \Carbon\Carbon::parse($p->production_date)->format('d M Y') }}
                            </span>
                        </td>

                        <td>
                            <span class="fw-bold text-primary">
                                Rp {{ number_format($p->total_cost ?? 0,2) }}
                            </span>
                        </td>

                        <td>
                            @if($p->status == 0)
                                <span class="badge bg-primary px-3">Draft</span>
                            @elseif($p->status == 1)
                                <span class="badge bg-warning text-dark px-3">In Progress</span>
                            @else
                                <span class="badge bg-success px-3">Finished</span>
                            @endif
                        </td>

                        <td class="d-flex gap-2 justify-content-center">

                            <button onclick="openPlanningModal('{{ $p->id }}')" class="btn btn-info btn-sm shadow-sm">
                                👁
                            </button>

                            @if($p->status == 0)
                            <form action="/production/{{ $p->id }}/start" method="POST" onsubmit="return confirmStart(event)">
                                @csrf
                                <button class="btn btn-success btn-sm shadow-sm">▶ Start</button>
                            </form>
                            @endif

                            @if($p->status == 1)
                            <form action="/production/{{ $p->id }}/finish" method="POST" onsubmit="return confirmFinish(event)">
                                @csrf
                                <button class="btn btn-primary btn-sm shadow-sm">✔ Finish</button>
                            </form>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="planningModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-3 shadow">

            <div class="modal-header bg-light">
                <h5 class="fw-bold mb-0">📊 Production Planning</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- MATERIAL -->
                <h6 class="fw-bold">📦 Materials</h6>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Planned Qty</th>
                                <th>Actual Qty</th>
                                <th>Planned Cost</th>
                                <th>Actual Cost</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="planMaterial"></tbody>
                    </table>
                </div>

                <!-- OPERATION -->
                <h6 class="fw-bold mt-4">⚙️ Operations</h6>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Machine</th>
                                <th>Hours</th>
                                <th>Cost/Hour</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="planOperation"></tbody>
                    </table>
                </div>

                <!-- TOTAL -->
                <div class="text-end mt-4">
                    <h4>
                        Total:
                        <span class="badge bg-primary px-3 py-2" id="planTotal">0</span>
                    </h4>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.openPlanningModal = function(id) {

    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(`/production/${id}/planning`)
    .then(res => res.json())
    .then(data => {

        Swal.close();

        let matHtml = '';
        let opHtml = '';
        let totalMat = 0;
        let totalOp = 0;

        // ===== MATERIAL =====
        if (!data.materials || data.materials.length === 0) {
            matHtml = `<tr><td colspan="6">No Data</td></tr>`;
        } else {

            data.materials.forEach(m => {

                let plannedQty = parseFloat(m.planned_qty || 0);
                let actualQty = parseFloat(m.actual_qty ?? 0);

                let plannedTotal = parseFloat(m.planned_total_cost || 0);
                let actualTotal = parseFloat(m.actual_total_cost ?? 0);

                totalMat += actualTotal;

                matHtml += `
                <tr>
                    <td>${m.item?.name ?? '-'}</td>
                    <td>${plannedQty.toFixed(2)}</td>
                    <td>${actualQty.toFixed(2)}</td>
                    <td>Rp ${formatNumber(plannedTotal)}</td>
                    <td>Rp ${formatNumber(actualTotal)}</td>
                    <td>Rp ${formatNumber(actualTotal)}</td>
                </tr>`;
            });
        }

        document.getElementById('planMaterial').innerHTML = matHtml;

        // ===== OPERATION =====
        if (data.details && data.details.length > 0) {
            data.details.forEach(d => {

                let costPerHour = d.machine?.cost_per_hour || 0;
                let total = d.hours * costPerHour;

                totalOp += total;

                opHtml += `
                <tr>
                    <td>${d.machine?.name ?? '-'}</td>
                    <td>${d.hours}</td>
                    <td>Rp ${formatNumber(costPerHour)}</td>
                    <td>Rp ${formatNumber(total)}</td>
                </tr>`;
            });
        }

        document.getElementById('planOperation').innerHTML = opHtml;

        document.getElementById('planTotal').innerText =
            'Rp ' + formatNumber(totalMat + totalOp);

        new bootstrap.Modal(document.getElementById('planningModal')).show();
    })
    .catch(() => {
        Swal.fire('Error', 'Failed load planning', 'error');
    });
};

function formatNumber(num) {
    return parseFloat(num || 0).toLocaleString('id-ID', {
        minimumFractionDigits: 2
    });
}

function confirmStart(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Start Production?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Start'
    }).then(res => {
        if (res.isConfirmed) e.target.submit();
    });
    return false;
}

function confirmFinish(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Finish Production?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Finish'
    }).then(res => {
        if (res.isConfirmed) e.target.submit();
    });
    return false;
}
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success 🎉',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection
