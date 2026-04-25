@extends('layouts.master')
@section('title') Create Production @endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Production @endslot
    @slot('subtitle') Create @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form id="productionForm" action="{{ route('production.store') }}" method="POST">
                        @csrf

                        <!-- HEADER -->
                        <div class="row mb-4">

                            <!-- ITEM -->
                            <div class="col-md-4">
                                <label class="form-label">Product</label>
                                <select id="itemSelect" name="item_id" class="form-select">
                                    <option value="">-- Select Product --</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- BOM -->
                            <div class="col-md-4">
                                <label class="form-label">BOM</label>
                                <select id="bomSelect" name="bom_id" class="form-select">
                                    <option value="">-- Select BOM --</option>
                                </select>
                            </div>

                            <!-- QTY -->
                            <div class="col-md-4">
                                <label class="form-label">Qty</label>
                                <input type="number" id="qty" name="qty" class="form-control" value="1" min="1">
                            </div>

                        </div>

                        <!-- MATERIAL -->
                        <h5 class="mt-3">📦 Materials</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Unit Cost</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="materialPreview"></tbody>
                            </table>
                        </div>

                        <!-- OPERATIONS -->
                        <h5 class="mt-4">⚙️ Operations</h5>
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
                                <tbody id="operationPreview"></tbody>
                            </table>
                        </div>

                        <!-- TOTAL -->
                        <div class="text-end mt-4">
                            <h4>Total Cost:
                                <span class="badge bg-primary" id="totalCost">0.00</span>
                            </h4>
                        </div>

                        <div class="text-end mt-3">
                            <button class="btn btn-success px-4">
                                🚀 Start Production
                            </button>
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
        let itemSelect = document.getElementById('itemSelect');
        let bomSelect = document.getElementById('bomSelect');
        let qtyInput = document.getElementById('qty');

        // ================= INIT =================
        resetPreview();

        // ================= ITEM CHANGE =================
        itemSelect.addEventListener('change', function() {

            let itemId = this.value;

            resetPreview();
            bomSelect.innerHTML = `<option value="">Loading BOM...</option>`;

            if (!itemId) {
                bomSelect.innerHTML = `<option value="">-- Select Product First --</option>`;
                return;
            }

            // 🔥 LOADING
            Swal.fire({
                title: 'Loading BOM...'
                , allowOutsideClick: false
                , didOpen: () => Swal.showLoading()
            });

            fetch(`/production/get-bom-by-item/${itemId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Server error');
                    return res.json();
                })
                .then(data => {

                    Swal.close();

                    if (!data || data.length === 0) {
                        bomSelect.innerHTML = `<option value="">No BOM Available</option>`;
                        return;
                    }

                    bomSelect.innerHTML = `<option value="">-- Select BOM --</option>`;

                    data.forEach(bom => {
                        bomSelect.innerHTML += `
                    <option value="${bom.id}">
                        ${bom.version}
                    </option>`;
                    });

                })
                .catch(err => {
                    Swal.fire('Error', 'Failed load BOM', 'error');
                    console.error(err);
                });
        });

        // ================= BOM / QTY CHANGE =================
        bomSelect.addEventListener('change', loadBom);
        qtyInput.addEventListener('input', debounce(loadBom, 400));

        // ================= LOAD BOM DETAIL =================
        function loadBom() {

            let bomId = bomSelect.value;
            let qty = parseFloat(qtyInput.value) || 0;

            resetPreview();

            if (!bomId) {
                showHint('Please select BOM first');
                return;
            }

            if (qty <= 0) {
                showHint('Please input quantity > 0');
                return;
            }

            // 🔥 LOADING
            Swal.fire({
                title: 'Calculating...'
                , allowOutsideClick: false
                , timer: 800
                , didOpen: () => Swal.showLoading()
            });

            fetch(`/production/bom/${bomId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Server error');
                    return res.json();
                })
                .then(data => {

                    if (!data || !data.details) {
                        showHint('BOM data not found');
                        return;
                    }

                    let totalMaterial = 0;
                    let totalMachine = 0;

                    // ================= MATERIAL =================
                    let matHtml = '';

                    data.details.forEach(d => {

                        let unitCost = parseFloat(d.item.standard_cost) || 0;
                        let total = d.qty * qty * unitCost;

                        totalMaterial += total;

                        matHtml += `
                <tr>
                    <td>${d.item.name}</td>
                    <td>${(d.qty * qty).toFixed(2)}</td>
                    <td>${formatNumber(unitCost)}</td>
                    <td>${formatNumber(total)}</td>
                </tr>`;
                    });

                    document.getElementById('materialPreview').innerHTML = matHtml;

                    // ================= OPERATIONS =================
                    let opHtml = '';

                    data.operations.forEach(o => {

                        let costPerHour = parseFloat(o.cost_per_hour) || 0;

                        let total = o.hours * costPerHour * qty;

                        totalMachine += total;

                        opHtml += `
                <tr>
                    <td>${o.machine.name}</td>
                    <td>${o.hours}</td>
                    <td>${formatNumber(costPerHour)}</td>
                    <td>${formatNumber(total)}</td>
                </tr>`;
                    });

                    document.getElementById('operationPreview').innerHTML = opHtml;

                    // ================= TOTAL =================
                    document.getElementById('totalCost').innerText =
                        formatNumber(totalMaterial + totalMachine);

                })
                .catch(err => {
                    Swal.fire('Error', 'Failed load BOM detail', 'error');
                    console.error(err);
                });
        }

        // ================= HELPERS =================
        function resetPreview() {
            document.getElementById('materialPreview').innerHTML =
                `<tr><td colspan="4" class="text-muted">Select item & BOM</td></tr>`;

            document.getElementById('operationPreview').innerHTML =
                `<tr><td colspan="4" class="text-muted">Waiting for data...</td></tr>`;

            document.getElementById('totalCost').innerText = '0.00';
        }

        function showHint(text) {
            document.getElementById('materialPreview').innerHTML =
                `<tr><td colspan="4" class="text-warning">${text}</td></tr>`;
        }

        function formatNumber(num) {
            return parseFloat(num).toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });
        }

        // 🔥 biar ga spam API
        function debounce(func, delay) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(), delay);
            };
        }

    </script>


    @endsection
