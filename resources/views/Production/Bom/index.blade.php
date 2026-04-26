@extends('layouts.master')
@section('title') BOM @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    <div class="container mt-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">📦 Bill of Materials</h4>

            <a href="{{ route('bom.create') }}" class="btn btn-primary">
                <i class="ti-plus"></i> Create BOM
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th class="text-start">Product</th>
                                <th>Version</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($boms as $i => $bom)
                            <tr>
                                <td>{{ $i+1 }}</td>

                                <td class="text-start">
                                    <strong>{{ $bom->item->name }}</strong><br>
                                    <small class="text-muted">{{ $bom->item->code }}</small>
                                </td>

                                <td>
                                    <span class="badge bg-primary px-3 py-2">
                                        {{ $bom->version }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $bom->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $bom->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td>
                                    <button onclick="openBomModal('{{ $bom->id }}')" class="btn btn-info btn-sm">
                                        <i class="ti-eye"></i>
                                    </button>

                                    <button onclick="deleteBom('{{ $bom->id }}')" class="btn btn-danger btn-sm">
                                        <i class="ti-trash"></i>
                                    </button>

                                    <form id="delete-{{ $bom->id }}" action="{{ route('bom.destroy',$bom->id) }}" method="POST" hidden>
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>



    <!-- MODAL -->
    <div class="modal fade" id="bomModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow">

                <form id="bomEditForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-light">
                        <h5 class="fw-bold">BOM Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="bom_id">

                        <!-- MATERIAL -->
                        <div class="d-flex justify-content-between mb-2">
                            <h6>📦 Materials</h6>
                            <button type="button" onclick="addMaterial()" class="btn btn-success btn-sm">
                                + Add
                            </button>
                        </div>

                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th width="120">Qty</th>
                                    <th width="150">Unit</th>
                                    <th width="60"></th>
                                </tr>
                            </thead>
                            <tbody id="materialTable"></tbody>
                        </table>

                        <!-- OPERATION -->
                        <div class="d-flex justify-content-between mt-4 mb-2">
                            <h6>⚙️ Operations</h6>
                            <button type="button" onclick="addOperation()" class="btn btn-info btn-sm">
                                + Add
                            </button>
                        </div>

                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Machine</th>
                                    <th width="80">Seq</th>
                                    <th width="120">Hours</th>
                                    <th width="150">Cost</th>
                                    <th width="60"></th>
                                </tr>
                            </thead>
                            <tbody id="operationTable"></tbody>
                        </table>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary px-4">Save Changes</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    @endsection


    @section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        let items = @json($items);
        let machines = @json($machines);
        let sortableInstance = null;

        // ================= OPEN MODAL =================
        window.openBomModal = function(id) {

            Swal.fire({
                title: 'Loading BOM...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/production/bom/${id}`)
            .then(res => res.json())
            .then(data => {

                Swal.close();

                document.getElementById('bom_id').value = id;

                document.getElementById('materialTable').innerHTML = '';
                document.getElementById('operationTable').innerHTML = '';

                data.details.forEach(d => addMaterial(d));
                data.operations.forEach(o => addOperation(o));

                new bootstrap.Modal(document.getElementById('bomModal')).show();

                initSortable();
            })
            .catch(() => {
                Swal.fire('Error', 'Failed load data', 'error');
            });
        };

        // ================= SORTABLE =================
        function initSortable() {

            if (sortableInstance) sortableInstance.destroy();

            sortableInstance = Sortable.create(document.getElementById('operationTable'), {
                animation: 150,
                ghostClass: 'bg-light',
                onEnd: updateSequence
            });
        }

        function updateSequence() {
            document.querySelectorAll('#operationTable tr').forEach((row, i) => {
                let seq = row.querySelector('[name="operations[][sequence]"]');
                if (seq) seq.value = i + 1;
            });
        }

        // ================= MATERIAL =================
        function addMaterial(d = null) {

            let html = `
        <tr>
            <td>
                <select name="details[][item_id]" onchange="loadUnit(this)" class="form-select">
                    ${items.map(i => `
                        <option value="${i.id}" ${d?.item_id == i.id ? 'selected' : ''}>
                            ${i.name}
                        </option>
                    `).join('')}
                </select>
            </td>

            <td>
                <input name="details[][qty]" value="${d?.qty ?? ''}" class="form-control text-center">
            </td>

            <td>
                <select name="details[][unit_id]" class="form-select unit"></select>
            </td>

            <td>
                <button type="button" onclick="this.closest('tr').remove()" class="btn btn-danger btn-sm">✕</button>
            </td>
        </tr>`;

            document.getElementById('materialTable').insertAdjacentHTML('beforeend', html);

            let row = document.querySelector('#materialTable tr:last-child');
            let select = row.querySelector('select');

            loadUnit(select, d?.unit_id);
        }

        function loadUnit(select, selected = null) {

            let item = items.find(i => i.id == select.value);
            let unitSelect = select.closest('tr').querySelector('.unit');

            unitSelect.innerHTML = '';

            if (!item) return;

            item.units.forEach(u => {
                unitSelect.innerHTML += `<option value="${u.id}">${u.code}</option>`;
            });

            if (selected) unitSelect.value = selected;
        }

        // ================= OPERATION =================
        function addOperation(o = null) {

            let rowCount = document.querySelectorAll('#operationTable tr').length;

            let html = `
        <tr>
            <td>
                <select name="operations[][machine_id]" class="form-select" onchange="setMachineCost(this)">
                    ${machines.map(m => `
                        <option value="${m.id}" data-cost="${m.cost_per_hour}"
                            ${o?.machine_id == m.id ? 'selected' : ''}>
                            ${m.name}
                        </option>
                    `).join('')}
                </select>
            </td>

            <td>
                <input name="operations[][sequence]"
                    value="${o?.sequence ?? (rowCount + 1)}"
                    class="form-control text-center">
            </td>

            <td>
                <input name="operations[][hours]"
                    value="${o?.hours ?? ''}"
                    oninput="calcTotal(this)"
                    class="form-control text-center hours">
            </td>

            <td>
                <input name="operations[][cost_per_hour]"
                    value="${o?.cost_per_hour ?? ''}"
                    class="form-control text-center cost" readonly>
            </td>

            <td>
                <input class="form-control text-center total" readonly>
            </td>

            <td>
                <button type="button" onclick="this.closest('tr').remove()"
                    class="btn btn-danger btn-sm">✕</button>
            </td>
        </tr>`;

            document.getElementById('operationTable').insertAdjacentHTML('beforeend', html);

            let row = document.querySelector('#operationTable tr:last-child');
            let select = row.querySelector('select');

            setMachineCost(select);
        }

        // ================= AUTO COST =================
        function setMachineCost(select) {

            let cost = select.options[select.selectedIndex].getAttribute('data-cost') ?? 0;

            let row = select.closest('tr');

            row.querySelector('.cost').value = cost;

            calcTotal(select);
        }

        // ================= TOTAL =================
        function calcTotal(el) {

            let row = el.closest('tr');

            let hours = parseFloat(row.querySelector('.hours').value) || 0;
            let cost = parseFloat(row.querySelector('.cost').value) || 0;

            let totalInput = row.querySelector('.total');
            if (totalInput) {
                totalInput.value = (hours * cost).toFixed(2);
            }
        }

        // ================= SUBMIT =================
        document.getElementById('bomEditForm').addEventListener('submit', function(e){
            e.preventDefault();

            let id = document.getElementById('bom_id').value;
            let formData = new FormData(this);

            fetch(`/production/bom/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                },
                body: formData
            })
            .then(() => {
                Swal.fire('Success','Updated','success').then(()=> location.reload());
            });
        });

        // ================= DELETE =================
        window.deleteBom = function(id){
            Swal.fire({
                title:'Delete?',
                icon:'warning',
                showCancelButton:true
            }).then(res=>{
                if(res.isConfirmed){
                    document.getElementById('delete-'+id).submit();
                }
            });
        };
        </script>


    @endsection
