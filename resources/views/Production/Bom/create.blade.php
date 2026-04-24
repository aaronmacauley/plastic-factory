@extends('layouts.master')
@section('title') Create BOM @endsection

@section('body')
<body data-sidebar="dark">
@endsection

@section('content')

@component('components.breadcrumb')
@slot('page_title') BOM @endslot
@slot('subtitle') Create @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form id="bomForm" action="{{ route('bom.store') }}" method="POST">
                    @csrf

                    <!-- HEADER -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Product</label>
                            <select name="item_id" class="form-select" required>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Version</label>
                            <input type="text" name="version" class="form-control" placeholder="v1">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- ================= MATERIAL ================= -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>📦 Materials</h5>
                        <button type="button" class="btn btn-sm btn-success" onclick="addMaterialRow()">
                            + Add Material
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th width="120">Qty</th>
                                    <th width="150">Unit</th>
                                    <th width="80"></th>
                                </tr>
                            </thead>
                            <tbody id="materialTable"></tbody>
                        </table>
                    </div>

                    <!-- ================= OPERATIONS ================= -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                        <h5>⚙️ Operations</h5>
                        <button type="button" class="btn btn-sm btn-info" onclick="addOperationRow()">
                            + Add Operation
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Machine</th>
                                    <th width="100">Seq</th>
                                    <th width="120">Hours</th>
                                    <th width="150">Cost/Hour</th>
                                    <th width="80"></th>
                                </tr>
                            </thead>
                            <tbody id="operationTable"></tbody>
                        </table>
                    </div>

                    <!-- BUTTON -->
                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-4">Save BOM</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{URL::asset('assets/js/app.js')}}"></script>

<script>
    let items = @json($items); // HARUS with('units')
    let machines = @json($machines);
    let materialIndex = 0;

function addMaterialRow() {

    let index = materialIndex++;

    let html = `
    <tr>
        <td>
            <select name="details[${index}][item_id]" class="form-select" onchange="setUnits(this)">
                <option value="">-- Select Item --</option>
                ${items.map(i => `<option value="${i.id}">${i.name}</option>`).join('')}
            </select>
        </td>

        <td>
            <input type="number" step="0.0001" name="details[${index}][qty]" class="form-control text-center" required>
        </td>

        <td>
            <select name="details[${index}][unit_id]" class="form-select unit-select" required>
                <option value="">-- Select Unit --</option>
            </select>
        </td>

        <td>
            <button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger btn-sm">
                X
            </button>
        </td>
    </tr>`;

    document.getElementById('materialTable').insertAdjacentHTML('beforeend', html);
}


    // 🔥 AUTO LOAD UNIT
    function setUnits(select) {
        let itemId = select.value;
        let item = items.find(i => i.id == itemId);

        let row = select.closest('tr');
        let unitSelect = row.querySelector('.unit-select');

        unitSelect.innerHTML = `<option value="">-- Select Unit --</option>`;

        if (!item || !item.units) return;

        item.units.forEach(u => {
            unitSelect.innerHTML += `
                <option value="${u.id}">
                    ${u.name} (${u.code})
                </option>
            `;
        });

        // 🔥 AUTO SELECT BASE UNIT
        let base = item.units.find(u => u.pivot && u.pivot.is_base_unit == 1);
        if (base) {
            unitSelect.value = base.id;
        }
    }
    let operationIndex = 0;

function addOperationRow() {

    let index = operationIndex++;

    let html = `
    <tr>
        <td>
            <select name="operations[${index}][machine_id]" class="form-select" onchange="setMachineCost(this)">
                <option value="">-- Select Machine --</option>
                ${machines.map(m =>
                    `<option value="${m.id}" data-cost="${m.cost_per_hour}">
                        ${m.name}
                    </option>`
                ).join('')}
            </select>
        </td>

        <td>
            <input type="number" name="operations[${index}][sequence]" class="form-control text-center" required>
        </td>

        <td>
            <input type="number" step="0.01" name="operations[${index}][hours]" class="form-control text-center" required>
        </td>

        <td>
            <input type="number" name="operations[${index}][cost_per_hour]" class="form-control text-center cost-input" readonly>
        </td>

        <td>
            <button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger btn-sm">
                X
            </button>
        </td>
    </tr>`;

    document.getElementById('operationTable').insertAdjacentHTML('beforeend', html);
}


    // 🔥 AUTO COST MACHINE
    function setMachineCost(select) {
        let selected = select.options[select.selectedIndex];
        let cost = selected.getAttribute('data-cost');

        let row = select.closest('tr');
        let costInput = row.querySelector('.cost-input');

        costInput.value = cost ?? 0;
    }

    // ================= CONFIRM =================
    document.getElementById('bomForm').addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Save BOM?',
            text: 'Pastikan semua data sudah benar',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save',
            cancelButtonText: 'Cancel'
        }).then(res => {
            if (res.isConfirmed) {

                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                this.submit();
            }
        });
    });
</script>

@endsection
