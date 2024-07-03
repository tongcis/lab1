@extends('layouts.main', ['title' => 'Pengajuan Ruangan'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Pengajuan Ruangan
                    </div>
                    <h2 class="page-title">
                        List Pengajuan Ruangan
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        {{-- <button type="button" class="btn btn-primary d-none d-sm-inline-block" id="add">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah
                        </button> --}}
                        <a href="{{ url('pengajuan-ruangan/jadwal') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Jadwal
                        </a>
                    </div>
                </div>
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
                                    <th>User Yang mengjukan</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Keperluan</th>
                                    @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                        <th width="10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->room->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->locale('id_ID')->isoFormat('LL') }}</td>
                                        <td>{{ $item->start_time . ' -' . $item->end_time }}</td>
                                        <td>{{ $item->typeRoom->name }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge bg-info p-1">Submitted</span>
                                            @elseif ($item->status == 2)
                                                <span class="badge bg-success p-1">Approved</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge bg-danger p-1">Rejected</span>
                                            @else
                                                <span class="badge bg-primary p-1">Done</span>
                                            @endif
                                        </td>
                                        @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                            <td>
                                                <div class="btn-group">
                                                    @if ($item->status == 1)
                                                        <button type="button" id="approve"
                                                            class="btn btn-success btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"
                                                            value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-check" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" id="reject"
                                                            class="btn btn-danger btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reject"
                                                            value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-square-rounded-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 10l4 4m0 -4l-4 4" />
                                                                <path
                                                                    d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                    <button type="button" id="detail"
                                                        class="btn btn-info btn-rounded btn-icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Detail" value="{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                    </button>
                                                    {{-- <button type="button" id="edit"
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
                                            </button> --}}
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
    @includeIf('pages.room-application.modal')
    @includeIf('pages.room-application.modal-detail')
    @includeIf('pages.room-application.modal-reject')
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
                $('#title').html("Tambah Data Pengajuan Ruangan");
                $('#modal').modal('show');
            });


            $('#type_room_id').change(function() {
                let selectedValue = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "/jenis-keperluan/" + selectedValue,
                    success: function(response) {
                        if (response.is_learning === 1) {
                            $('#title-lecturer').html("Dosen Pengampu");
                            $('#lecturer').show();
                            $('#course').show();
                            $('#activity').hide();
                        } else {
                            $('#title-lecturer').html("Dosen Penanggungjawab");
                            $('#lecturer').show();
                            $('#activity').show();
                            $('#course').hide();
                        }

                    }
                });

            });

            $('body').on('click', '#edit', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $.ajax({
                    type: "GET",
                    url: "/pengajuan-ruangan/" + id + '/edit',
                    success: function(response) {
                        $('#title').html("Ubah Data Pengajuan Ruangan");
                        $('#modal').modal('show');
                        $('#id').val(response.id);
                        if (response.type_room.is_learning === 1) {
                            $('#title-lecturer').html("Dosen Pengampu");
                            $('#lecturer').show();
                            $('#course').show();
                            $('#activity').hide();
                        } else {
                            $('#title-lecturer').html("Dosen Penanggungjawab");
                            $('#lecturer').show();
                            $('#activity').show();
                            $('#course').hide();
                        }
                        $('#room_id').val(response.room_id);
                        $('#type_room_id').val(response.room_id);
                        $('#user_id').val(response.user_id);
                        $('#lecturer_id').val(response.lecturer_id);
                        $('#activity_name').val(response.activity_name);
                        $('#course_id').val(response.course_id);
                        $('#date').val(response.date);
                        $('#start_time').val(response.start_time);
                        $('#end_time').val(response.end_time);
                        $('#description').val(response.description);
                    }
                });
            });

            $('body').on('click', '#detail', function() {
                let id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/pengajuan-ruangan/" + id,
                    success: function(response) {
                        $('#title-detail').html("Detail Data Pengajuan Ruangan");
                        $('#user_app').html(response.user.name);
                        $('#room_app').html(response.room.name);
                        $('#type_room_app').html(response.type_room.name);
                        $('#lecturer_app').html(response.lecturer.name);
                        $('#date_app').html(formatDate(response.date));
                        let time = formatTime(response.start_time) + ' - ' + formatTime(response
                            .end_time);
                        $('#time_app').html(time);
                        $('#end_time_app').html(response.end_time);
                        $('#description_app').html(response.description);

                        if (response.type_room.is_learning == 1) {
                            $('#title_lecturer_app').html('Dosen Pengampu');
                            $('#activity_detail').hide();
                            $('#course_detail').show();
                            $('#course_app').html(response.course.name);
                        } else {
                            $('#title_lecturer_app').html('Dosen Penanggungjawab');
                            $('#course_detail').hide();
                            $('#activity_detail').show();
                            $('#activity_app').html(response.activity_name);
                        }

                        if (response.status == 1) {
                            $('#status_app').html('Submitted');
                            $('.approved').hide();
                            $('.rejected').hide();
                        } else if (response.status == 2) {
                            $('#status_app').html('Approved');
                            $('.approved').show();
                            $('.rejected').hide();
                            $('#approved_by_app').html(response.approved_by.name);
                            $('#approved_date_app').html(formatDate(response.approved_at));
                        } else if (response.status == 3) {
                            $('#status_app').html('Rejected');
                            $('.approved').hide();
                            $('.rejected').show();
                            $('#rejected_by_app').html(response.rejected_by.name);
                            $('#rejected_date_app').html(formatDate(response.rejected_at));
                            $('#rejected_note_app').html(response.rejected_note);
                        } else {
                            $('#status_app').html('Done');
                            $('.approved').show();
                            $('.rejected').hide();
                            $('#approved_by_app').html(response.approved_by.name);
                            $('#approved_date_app').html(formatDate(response.approved_at));
                        }

                        $('#modal-detail').modal('show');
                    }
                });
            });

            $('body').on('click', '#approve', function() {
                let id = $(this).val();

                Swal.fire({
                    title: 'Apakah anda yakin akan menyetujui data ini ?',
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
                            url: "/pengajuan-ruangan/" + id + "/approve",
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

            $('body').on('click', '#reject', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $('#title-reject').html("Reject Pengajuan");
                $('#modal-reject').modal('show');
                $('#application_id').val(id);
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
                            url: "/pengajuan-ruangan/" + id,
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
                        console.log(response);
                        if (response.status == 0) {
                            $.each(response.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (response.status == 1) {
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
                        } else {
                            $('#main-form').trigger("reset");
                            $('#modal').modal('hide');
                            Swal.fire('Error', response.message,
                                'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('Error', 'Terjadi kesalahan. Silakan coba lagi.',
                            'error');
                    }
                })
            })

            $('#form-reject').on('submit', function(e) {
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
                            $('#form-reject').trigger("reset");
                            setTimeout(() => {
                                window.location.reload()
                            }, 2000);
                            $('#modal-reject').modal('hide');
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
