@extends('layouts.main', ['title' => 'Inventaris'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Inventaris
                    </div>
                    <h2 class="page-title">
                        List Inventaris Barang
                    </h2>
                </div>
                @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <button type="button" class="btn btn-primary d-none d-sm-inline-block" id="add">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 col-md-4">
                        <label for="filterRoom">Filter Ruangan:</label>
                        <select id="filterRoom" class="form-select">
                            <option value="">Semua Ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->name }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Lab</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                        <th width="10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->room->name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->image_url != null)
                                                <img src="{{ asset('storage/' . $item->image_url) }}" alt=""
                                                    width="50px" class="img-fluid rounded">
                                            @else
                                                Belum upload gambar.
                                            @endif
                                        </td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->description }}</td>
                                        @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" id="edit"
                                                        class="btn btn-warning btn-rounded btn-icon"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah"
                                                        value="{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-edit" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" id="delete"
                                                        class="btn btn-danger btn-rounded btn-icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Hapus" value="{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-trash" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('pages.inventory.modal')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                columnDefs: [{
                    className: 'text-center',
                    targets: '_all'
                }]
            });

            $('#filterRoom').change(function() {
                var room_id = $(this).val();

                // Hapus filter sebelumnya
                table.column(1).search('').draw();

                // Terapkan filter baru jika dipilih ruangan selain "Semua Ruangan"
                if (room_id) {
                    table.column(1).search(room_id).draw();
                }
            });

            @if (session('success'))
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{!! session('success') !!}',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true
                })
            @endif

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#add').click(function() {
                $('#main-form').trigger("reset");
                $('#id').val('');
                $('span.error_text').html("");
                $('#title').html("Tambah Data Inventaris");
                $('#modal').modal('show');
            });

            $('body').on('click', '#edit', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $.ajax({
                    type: "GET",
                    url: "/inventaris/" + id + '/edit',
                    success: function(response) {
                        $('#title').html("Ubah Data Inventaris");
                        $('#modal').modal('show');
                        $('#id').val(response.id);
                        $('#room_id').val(response.room_id);
                        $('#name').val(response.name);
                        $('#amount').val(response.amount);
                        $('#description').val(response.description);
                    }
                });
            });

            $('body').on('click', '#delete', function() {
                let id = $(this).val();

                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus data ini ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#FF0000',
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            url: "/inventaris/" + id,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.success,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true
                                    })
                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 2000);
                                }
                                if (response.error) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: response.error,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true
                                    })
                                }
                            }
                        });
                    }
                })
            });

            $('#main-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error_text').text('')
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            $.each(response.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#main-form').trigger("reset");
                            setTimeout(() => {
                                window.location.reload()
                            }, 2000);
                            $('#modal').modal('hide');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Terjadi kesalahan. Silakan coba lagi.',
                            'error');
                    }
                })
            })
        })
    </script>
@endpush
