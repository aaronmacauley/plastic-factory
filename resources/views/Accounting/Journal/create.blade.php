    @extends('layouts.master')

    @section('title','Create Journal')

    @section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .journal-card {
            border: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        .table thead {
            background: #f8f9fa;
        }

    </style>
    @endsection


    @component('components.breadcrumb')
    @slot('page_title') Journal @endslot
    @slot('subtitle') Create @endslot
    @endcomponent

    @section('body')
    <body data-sidebar="dark"></body>
    @endsection
    @section('content')
    <div class="card journal-card">
        <div class="card-body">

            <form id="journalForm" action="{{ route('journal.store') }}" method="POST">
                @csrf

                {{-- HEADER --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" name="transaction_date" class="form-control" required>
                    </div>

                    <div class="col-md-8">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                </div>

                <hr>

                {{-- HEADER BUTTON --}}
                <div class="d-flex justify-content-between mb-2">
                    <h5>Journal Lines</h5>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                        + Add Line
                    </button>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="journalBody">

                            <tr>
                                <td>
                                    <select name="lines[0][account_id]" class="form-control">
                                        <option value="">Select Account</option>
                                        @foreach($accounts as $acc)
                                        <option value="{{ $acc->id }}">
                                            {{ $acc->code }} - {{ $acc->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="text" name="lines[0][description]" class="form-control">
                                </td>

                                {{-- DEBIT --}}
                                <td>
                                    <input type="text" class="form-control debit display-money" oninput="formatMoney(this)">
                                    <input type="hidden" name="lines[0][debit]" class="debit-raw">
                                </td>

                                {{-- CREDIT --}}
                                <td>
                                    <input type="text" class="form-control credit display-money" oninput="formatMoney(this)">
                                    <input type="hidden" name="lines[0][credit]" class="credit-raw">
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">✕</button>
                                </td>
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="2" class="text-end">TOTAL</td>
                                <td id="totalDebit">Rp 0</td>
                                <td id="totalCredit">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <div class="text-end mt-3">
                    <button type="button" class="btn btn-success" onclick="submitJournal()">
                        Save Journal
                    </button>
                </div>

            </form>

        </div>
    </div>
    @endsection


    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        let rowIndex = 1;

        /* =========================
        FORMAT RUPIAH INPUT
        ========================= */
        function formatMoney(el) {
            let value = el.value.replace(/[^0-9]/g, '');
            if (!value) value = 0;

            el.value = new Intl.NumberFormat('id-ID').format(value);

            let hidden = el.nextElementSibling;
            hidden.value = value;

            calculateTotal();
        }

        /* =========================
        ADD ROW
        ========================= */
        function addRow() {
            let accounts = @json($accounts);

            let options = `<option value="">Select Account</option>`;
            accounts.forEach(acc => {
                options += `<option value="${acc.id}">${acc.code} - ${acc.name}</option>`;
            });

            let row = `
            <tr>
                <td>
                    <select name="lines[${rowIndex}][account_id]" class="form-control">
                        ${options}
                    </select>
                </td>

                <td>
                    <input type="text" name="lines[${rowIndex}][description]" class="form-control">
                </td>

                <td>
                    <input type="text" class="form-control debit display-money" oninput="formatMoney(this)">
                    <input type="hidden" name="lines[${rowIndex}][debit]" class="debit-raw">
                </td>

                <td>
                    <input type="text" class="form-control credit display-money" oninput="formatMoney(this)">
                    <input type="hidden" name="lines[${rowIndex}][credit]" class="credit-raw">
                </td>

                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">✕</button>
                </td>
            </tr>
        `;

            document.getElementById('journalBody').insertAdjacentHTML('beforeend', row);
            rowIndex++;
        }

        /* =========================
        REMOVE ROW
        ========================= */
        function removeRow(btn) {
            btn.closest('tr').remove();
            calculateTotal();
        }

        /* =========================
        CALCULATE TOTAL
        ========================= */
        function calculateTotal() {
            let debit = 0;
            let credit = 0;

            document.querySelectorAll('.debit-raw').forEach(i => debit += +i.value);
            document.querySelectorAll('.credit-raw').forEach(i => credit += +i.value);

            document.getElementById('totalDebit').innerText =
                'Rp ' + new Intl.NumberFormat('id-ID').format(debit);

            document.getElementById('totalCredit').innerText =
                'Rp ' + new Intl.NumberFormat('id-ID').format(credit);
        }

        /* =========================
        SUBMIT VALIDATION
        ========================= */
        function submitJournal() {
            let debit = 0;
            let credit = 0;

            document.querySelectorAll('.debit-raw').forEach(i => debit += +i.value);
            document.querySelectorAll('.credit-raw').forEach(i => credit += +i.value);

            if (debit !== credit) {
                Swal.fire('Error', 'Debit & Credit must balance', 'error');
                return;
            }

            document.getElementById('journalForm').submit();
        }

    </script>
    @endsection
