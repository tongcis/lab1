@extends('layouts.main', ['title' => 'Pengaduan'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Pengaduan
                    </div>
                    <h2 class="page-title">
                        List Pengaduan
                    </h2>
                </div>
                @if (auth()->user()->hasRole('Leader'))
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
                    <div class="table-responsive">
                        <table id="table" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Inventaris</th>
                                    <th>Gambar</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->locale('id_ID')->isoFormat('LL') }}</td>
                                        <td>{{ $item->inventory->name }}</td>
                                        <td>
                                            @if ($item->image_url != null)
                                                <img src="{{ asset('storage/' . $item->image_url) }}" alt=""
                                                    width="50px" class="img-fluid rounded">
                                            @else
                                                Belum upload gambar.
                                            @endif
                                        </td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge bg-default p-1">Submitted</span>
                                            @elseif ($item->status == 2)
                                                <span class="badge bg-info p-1">Follow Up</span>
                                            @else
                                                <span class="badge bg-success p-1">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                                    @if ($item->status == 1)
                                                        <button type="button" id="follow-up"
                                                            class="btn btn-success btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Tindak Lanjuti" value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-check" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                    @if ($item->status == 2)
                                                        <button type="button" id="done"
                                                            class="btn btn-success btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Selesaikan" value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-check" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endif
                                                <button type="button" id="detail"
                                                    class="btn btn-info btn-rounded btn-icon" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail" value="{{ $item->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </button>
                                                @if (auth()->user()->hasRole('Leader') && $item->reporter_id == auth()->user()->id)
                                                    @if ($item->status == 1)
                                                        <button type="button" id="edit"
                                                            class="btn btn-warning btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Ubah" value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-edit" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" id="delete"
                                                            class="btn btn-danger btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Hapus" value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('pages.complaint.modal')
    @includeIf('pages.complaint.modal-detail')
    @includeIf('pages.complaint.modal-done')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                columnDefs: [{
                    className: 'text-center',
                    targets: '_all'
                }]
            })

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
                $('#title').html("Tambah Data Pengaduan");
                $('#modal').modal('show');
            });

            $('body').on('click', '#edit', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $.ajax({
                    type: "GET",
                    url: "/pengaduan/" + id + '/edit',
                    success: function(response) {
                        $('#title').html("Ubah Data Pengaduan");
                        $('#modal').modal('show');
                        $('#id').val(response.id);
                        $('#inventory_id').val(response.inventory_id);
                        $('#date').val(response.date);
                        $('#description').val(response.description);
                    }
                });
            });

            $('body').on('click', '#detail', function() {
                let id = $(this).val();
                $('#image_complaint').attr('src', '');
                $.ajax({
                    type: "GET",
                    url: "/pengaduan/" + id,
                    success: function(response) {
                        $('#title-detail').html("Detail Data Pengaduan");
                        $('#reporter_complaint').html(response.reporter.name);
                        $('#date_complaint').html(formatDate(response.date));
                        if (response.follow_up_date) {
                            $('#follow_up_date_complaint').html(formatDate(response
                                .follow_up_date));
                        }
                        $('#room_complaint').html(response.inventory.room.name);
                        $('#inventory_complaint').html(response.inventory.name);
                        if (response.image_url != null) {
                            $('#image_detail').show()
                            $('#image_complaint').attr('src', '/storage/' + response.image_url);
                        } else {
                            $('#image_detail').hide()
                        }
                        if (response.attachment != null) {
                            $('#image_follow_up_detail').show()
                            $('#image_follow_up').attr('src', '/storage/' + response
                            .attachment);
                        } else {
                            $('#image_follow_up_detail').hide()
                        }
                        $('#quantity_complaint').html(response.quantity);
                        $('#description_complaint').html(response.description);
                        if (response.status == 1) {
                            $('#status_complaint').html('Submitted');
                        } else if (response.status == 2) {
                            $('#status_complaint').html('Ditindaklanjuti');
                        } else {
                            $('#status_complaint').html('Selesai');
                        }

                        if (response.user) {
                            $('#user_complaint').html(response.user.name);
                        }

                        if (response.note != null) {
                            $('#note_complaint').html(response.note);
                        }

                        $('#modal-detail').modal('show');
                    }
                });
            });

            $('body').on('click', '#follow-up', function() {
                let id = $(this).val();

                Swal.fire({
                    title: 'Apakah anda yakin akan menindaklanjuti data ini ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#FF0000',
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "/pengaduan/" + id + "/follow-up",
                            success: function(response) {
                                if (response.success) {
                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 2000);

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.success,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true
                                    })
                                    table.draw()
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

            $('body').on('click', '#done', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $('#title-done').html("Selesaikan Pengaduan");
                $('#modal-done').modal('show');
                $('#complaint_id').val(id);
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
                            url: "/pengaduan/" + id,
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

            $('#form-done').on('submit', function(e) {
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
                            $('#form-done').trigger("reset");
                            setTimeout(() => {
                                window.location.reload()
                            }, 2000);
                            $('#modal-done').modal('hide');
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
