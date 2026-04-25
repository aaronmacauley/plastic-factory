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
                            <th>Date Planned</th>
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
                                <div class="fw-bold">{{ $p->item->name }}</div>
                                <small class="text-muted">ID: {{ $p->production_number }}</small>
                            </td>

                            <td class="text-start">
                                <div>
                                    <span class="badge bg-light text-dark">
                                        📅 Planned: {{ $p->created_at?->format('d M Y') }}
                                    </span>
                                </div>

                                <div>
                                    @if($p->started_at)
                                    <span class="badge bg-warning text-dark mt-1">
                                        ▶ Start: {{ \Carbon\Carbon::parse($p->started_at)->format('d M Y H:i') }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary mt-1">▶ Start: -</span>
                                    @endif
                                </div>

                                <div>
                                    @if($p->finished_at)
                                    <span class="badge bg-success mt-1">
                                        ✔ Finish: {{ \Carbon\Carbon::parse($p->finished_at)->format('d M Y H:i') }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary mt-1">✔ Finish: -</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="fw-bold text-primary">
                                    Rp {{ number_format($p->total_cost ?? 0, 2, ',', '.') }}
                                </div>
                                <small class="text-muted">
                                    Est: Rp {{ number_format($p->estimated_total_cost ?? 0, 2, ',', '.') }}
                                </small>
                            </td>

                            <td>
                                @php
                                $status = match($p->status) {
                                0 => ['Draft', 'primary'],
                                1 => ['In Progress', 'warning text-dark'],
                                2 => ['Finished', 'success'],
                                default => ['Unknown', 'dark']
                                };
                                @endphp

                                <span class="badge bg-{{ $status[1] }} px-3">
                                    {{ $status[0] }}
                                </span>
                            </td>

                            <td class="d-flex gap-2 justify-content-center">

                                <button onclick="openPlanningModal('{{ $p->id }}')" class="btn btn-info btn-sm">
                                    👁
                                </button>

                                @if($p->status == 0)
                                <form action="/production/{{ $p->id }}/start" method="POST" onsubmit="return confirmStart(event)">
                                    @csrf
                                    <button class="btn btn-success btn-sm">▶ Start</button>
                                </form>
                                @endif

                                @if($p->status == 1)
                                <button class="btn btn-primary btn-sm" onclick="openFinishModal('{{ $p->id }}')">
                                    ✔ Finish
                                </button>

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
                                    <th>Total Variance</th>
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


    {{-- finish modal --}}
    <div class="modal fade" id="finishModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Finish Production - Actual Input</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

<form id="finishForm" method="POST" action="{{ route('production.finish') }}">
                    @csrf
   <input type="hidden" name="id" id="finish-id">
                    <div class="modal-body">

                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
    <th>Item</th>
    <th>Planned Qty</th>
    <th>Planned Unit Cost</th>
    <th>Actual Qty</th>
    <th>Actual Unit Cost</th>
    <th>Total</th>
    <th>Variance Qty</th>
    <th>Variance Cost</th>
</tr>

                            </thead>

                            <tbody id="finishMaterialBody"></tbody>
                        </table>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Finish & Post</button>
                    </div>

                </form>

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

            if (!data.materials || data.materials.length === 0) {
                matHtml = `<tr><td colspan="6">No Data</td></tr>`;
            } else {

                data.materials.forEach(m => {

                    let plannedQty = parseFloat(m.planned_qty || 0);
                    let actualQty = parseFloat(m.actual_qty || 0);

                    let plannedTotal = parseFloat(m.planned_total_cost || 0);
                    let actualTotal = parseFloat(m.actual_total_cost || 0);
let varianceQty = parseFloat(m.variance_qty || 0);
let varianceCost = parseFloat(m.variance_cost || 0);

                    totalMat += actualTotal;
matHtml += `
<tr>
    <td>${m.item?.name ?? '-'}</td>

    <td>${plannedQty.toFixed(2)}</td>
    <td>${actualQty.toFixed(2)}</td>

    <td>Rp ${formatNumber(plannedTotal)}</td>
    <td>Rp ${formatNumber(actualTotal)}</td>

    <td>
        <span class="${varianceCost < 0 ? 'text-danger fw-bold' : 'text-success fw-bold'}">
            Rp ${formatNumber(varianceCost)}
        </span>
    </td>
</tr>`;

                });
            }

            document.getElementById('planMaterial').innerHTML = matHtml;

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


// ================= FINISH MODAL =================
window.openFinishModal = function(id) {
document.getElementById('finish-id').value = id;

    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    fetch(`/production/${id}/planning`)
        .then(res => res.json())
        .then(data => {

            Swal.close();

            let html = '';

            data.materials.forEach((m, index) => {

                html += `
<tr>
    <td>
        ${m.item?.name ?? '-'}
<input type="hidden" name="materials[${index}][production_material_id]" value="${m.id}">

    </td>

    <td>
        ${m.planned_qty}
        <input type="hidden" name="materials[${index}][planned_qty]" value="${m.planned_qty}">
        <input type="hidden" name="materials[${index}][planned_total_cost]" value="${m.planned_total_cost}">
        <input type="hidden" name="materials[${index}][planned_unit_cost]" value="${m.planned_unit_cost}">
    </td>

    <!-- ✅ PREVIEW UNIT COST (BEFORE) -->
    <!-- PREVIEW PLANNED UNIT COST -->
<td>
    <div class="badge bg-light text-dark">
        Planned: Rp ${formatNumber(m.planned_unit_cost || 0)}
    </div>
</td>

<!-- ACTUAL QTY -->
<td>
    <input type="number"
        step="0.0001"
        class="form-control actual-qty"
        data-index="${index}"
        name="materials[${index}][actual_qty]"
        value="0">
</td>

<!-- ACTUAL UNIT COST -->
<td>
    <input type="number"
        step="0.01"
        class="form-control actual-unit-cost"
        data-index="${index}"
        name="materials[${index}][actual_unit_cost]"
        value="${m.planned_unit_cost || 0}">
</td>

<!-- TOTAL AUTO -->
<td>
    <input type="text"
        readonly
        class="form-control bg-light"
        id="total-${index}"
        name="materials[${index}][actual_total_cost]">
</td>

<!-- VARIANCE QTY -->
<td>
    <input type="text"
        readonly
        class="form-control bg-light"
        id="vq-${index}"
        name="materials[${index}][variance_qty]">
</td>

<!-- VARIANCE COST -->
<td>
    <input type="text"
        readonly
        class="form-control bg-light"
        id="vc-${index}"
        name="materials[${index}][variance_cost]">
</td>

</tr>`;

            });

            document.getElementById('finishMaterialBody').innerHTML = html;

document.getElementById('finishForm').action = "{{ route('production.finish') }}";
document.getElementById('finish-id').value = id;


            new bootstrap.Modal(document.getElementById('finishModal')).show();
        });
};


// ================= AUTO CALC =================
document.addEventListener('input', function (e) {

    if (
        e.target.classList.contains('actual-qty') ||
        e.target.classList.contains('actual-unit-cost')
    ) {
        recalcRow(e.target.dataset.index);
    }

});
function recalcRow(index) {

    let qty = parseFloat(document.querySelector(`[name="materials[${index}][actual_qty]"]`)?.value || 0);
    let cost = parseFloat(document.querySelector(`[name="materials[${index}][actual_unit_cost]"]`)?.value || 0);

    let plannedQty = parseFloat(document.querySelector(`[name="materials[${index}][planned_qty]"]`)?.value || 0);
    let plannedCost = parseFloat(document.querySelector(`[name="materials[${index}][planned_total_cost]"]`)?.value || 0);

    // ===== ACTUAL TOTAL =====
    let actualTotal = qty * cost;

    // ===== VARIANCE =====
let varianceQty = plannedQty - qty;
let varianceCost = plannedCost - actualTotal;


    // ===== UPDATE UI =====
    document.getElementById(`total-${index}`).value = actualTotal.toFixed(2);
    document.getElementById(`vq-${index}`).value = varianceQty.toFixed(4);
    document.getElementById(`vc-${index}`).value = varianceCost.toFixed(2);
}


// ================= HELPERS =================
function formatNumber(num) {
    return parseFloat(num || 0).toLocaleString('id-ID', {
        minimumFractionDigits: 2
    });
}


// ================= CONFIRM =================
function confirmStart(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Start Production?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes'
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


    @endsection
