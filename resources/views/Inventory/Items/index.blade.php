@extends('layouts.master')

@section('title')
Items
@endsection

@section('css')
<link href="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .table td,
    .table th {
        vertical-align: middle;
    }


    ul {
        text-align: left;
    }

    ul li {
        line-height: 1.6;
    }

</style>

@endsection

@section('body')
<body data-sidebar="dark">
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('page_title') Items @endslot
    @slot('subtitle') List @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">📦 Item Management</h4>
                        <a href="{{ route('items.create') }}" class="btn btn-primary">
                            <i class="ti-plus"></i> Add Item
                        </a>

                    </div>

                    {{-- TABLE --}}
                    <div class="table-rep-plugin">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Grade</th>
                                        <th>Weight</th>
                                        <th>Price</th>
                                        <th>Units</th>

                                        <th width="140">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <span class="badge bg-primary px-3 py-2">
                                                {{ $item->code }}
                                            </span>
                                        </td>

                                        <td class="text-start">
                                            {{ $item->name }}
                                        </td>

                                        <td>{{ $item->size }}</td>
                                        <td>{{ $item->grade }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-start">
                                            @if($item->units->count())
                                            <ul class="mb-0 ps-3">
                                                @foreach($item->units as $unit)
                                                <li class="small">
                                                    {{ $unit->name }}
                                                    @if($unit->pivot->is_base_unit)
                                                    {{ $unit->pivot->conversion_rate }} <span class="badge bg-success ms-1">Base</span>
                                                    @else
                                                    = {{ $unit->pivot->conversion_rate }} {{ $item->units->where('pivot.is_base_unit', true)->first()->name ?? '' }}
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @else
                                            <span class="text-muted">No Unit</span>
                                            @endif
                                        </td>

                                        <td>
                                            <button class="btn btn-info btn-sm me-1" onclick="openAddUnit('{{ $item->id }}')">
                                                <i class="ti-plus"></i> Unit
                                            </button>

                                            <button class="btn btn-warning btn-sm me-1" onclick="openEditModal(
                                                '{{ $item->id }}',
                                                '{{ $item->code }}',
                                                '{{ $item->name }}',
                                                '{{ $item->size }}',
                                                '{{ $item->grade }}',
                                                '{{ $item->weight }}',
                                                '{{ $item->price }}'
                                            )">
                                                <i class="ti-pencil"></i>
                                            </button>

                                            <button onclick="deleteItem('{{ $item->id }}')" class="btn btn-danger btn-sm">
                                                <i class="ti-trash"></i>
                                            </button>

                                            <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" method="POST" hidden>
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8">
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


    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editItemModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editItemForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Code</label>
                            <input type="text" name="code" id="edit_code" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Size</label>
                            <input type="text" name="size" id="edit_size" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Grade</label>
                            <input type="text" name="grade" id="edit_grade" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Weight</label>
                            <input type="text" name="weight" id="edit_weight" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Price</label>
                            <input type="number" name="price" id="edit_price" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script>
        function openAddUnit(itemId) {

            let units = @json($units);

            let options = `<option value="">Select Unit</option>`;
            units.forEach(u => {
                options += `<option value="${u.id}">${u.name}</option>`;
            });

            Swal.fire({
                title: 'Add Unit Conversion'
                , html: `
        <div class="text-start">

            <label class="form-label">Unit</label>
            <select id="swal_unit" class="form-select mb-3">
                ${options}
            </select>

            <label class="form-label">Conversion Rate</label>
            <input id="swal_rate" type="number" step="0.0001"
                   class="form-control mb-3" value="1">

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="swal_base">
                <label class="form-check-label">Set as Base Unit</label>
            </div>

        </div>
    `
                , showCancelButton: true
                , confirmButtonText: 'Save'
                , preConfirm: () => {
                    return {
                        unit_id: document.getElementById('swal_unit').value
                        , rate: document.getElementById('swal_rate').value
                        , base: document.getElementById('swal_base').checked
                    };
                }
            }).then((result) => {

                if (result.isConfirmed) {

                    let data = result.value;

                    if (!data.unit_id) {
                        Swal.fire('Error', 'Unit wajib dipilih', 'error');
                        return;
                    }

                    saveItemUnit(itemId, data);
                }
            });
        }

        function saveItemUnit(itemId, data) {

            Swal.fire({
                title: 'Saving...'
                , allowOutsideClick: false
                , didOpen: () => Swal.showLoading()
            });

            fetch(`/inventory/items/${itemId}/unit`, {
                    method: "POST"
                    , headers: {
                        "Content-Type": "application/json"
                        , "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                    , body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {

                    Swal.close();

                    if (res.success) {
                        Swal.fire('Success', res.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }

                })
                .catch(err => {
                    Swal.close();
                    Swal.fire('Error', 'Server Error', 'error');
                });
        }

        function openEditModal(id, code, name, size, grade, weight, price) {
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_size').value = size;
            document.getElementById('edit_grade').value = grade;
            document.getElementById('edit_weight').value = weight;
            document.getElementById('edit_price').value = price;

            document.getElementById('editItemForm').action = `/inventory/items/${id}`;

            let modal = new bootstrap.Modal(document.getElementById('editItemModal'));
            modal.show();
        }

        function deleteItem(id) {
            Swal.fire({
                title: 'Yakin hapus?'
                , text: "Data tidak bisa dikembalikan!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#6c757d'
                , confirmButtonText: 'Ya, hapus!'
                , cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success'
            , title: 'Berhasil'
            , text: '{{ session('
            success ') }}'
            , timer: 2000
            , showConfirmButton: false
        });
        @endif

    </script>

    <script src="{{URL::asset('assets/libs/admin-resources/rwd-table/rwd-table.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/table-responsive.init.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    @endsection
