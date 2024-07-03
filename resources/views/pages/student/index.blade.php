@extends('layouts.main', ['title' => 'Mahasiswa'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Mahasiswa
                    </div>
                    <h2 class="page-title">
                        List Data Mahasiswa
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
                    <div class="table-responsive">
                        <table id="table" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Prodi</th>
                                    @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                        <th width="10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nim }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->studyProgram->name }}</td>
                                        @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Laboratory Team'))
                                            <td>
                                                <div class="btn-group">
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
                                                    @if (auth()->user()->hasRole('Super Admin'))
                                                        <button type="button" id="reset"
                                                            class="btn btn-secondary btn-rounded btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Reset"
                                                            value="{{ $item->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-restore">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M3.06 13a9 9 0 1 0 .49 -4.087" />
                                                                <path d="M3 4.001v5h5" />
                                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                        @endif
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
    @includeIf('pages.student.modal')
    @includeIf('pages.student.modal-detail')
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
                $('#title').html("Tambah Data Mahasiswa");
                $('#modal').modal('show');
            });

            $('body').on('click', '#edit', function() {
                let id = $(this).val();
                $('span.error_text').html("");
                $.ajax({
                    type: "GET",
                    url: "/mahasiswa/" + id + '/edit',
                    success: function(response) {
                        $('#title').html("Ubah Data Mahasiswa");
                        $('#modal').modal('show');
                        $('#id').val(response.id);
                        $('#user_id').val(response.user.id);
                        $('#nim').val(response.nim);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#gender').val(response.gender);
                        $('#address').val(response.address);
                        $('#phone').val(response.phone);
                        $('#study_program_id').val(response.study_program_id);
                    }
                });
            });

            $('body').on('click', '#detail', function() {
                let id = $(this).val();
                $('#photo_student #photo').attr('src', '');
                $.ajax({
                    type: "GET",
                    url: "/mahasiswa/" + id,
                    success: function(response) {
                        $('#title-detail').html("Detail Data Mahasiswa");
                        $('#nim_student').html(response.nim);
                        $('#name_student').html(response.name);
                        $('#email_student').html(response.email);
                        $('#gender_student').html(response.gender);
                        $('#address_student').html(response.address);
                        $('#phone_student').html(response.phone);
                        $('#study_program_student').html(response.study_program.name);
                        if (response.photo != null) {
                            $('#photo_student').show();
                            $('#photo_student #photo').attr('src', '/storage/' + response
                                .photo);
                        } else {
                            $('#photo_student').hide();
                        }
                        $('#modal-detail').modal('show');
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
                            url: "/mahasiswa/" + id,
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

            $('body').on('click', '#reset', function() {
                let id = $(this).val();

                Swal.fire({
                    title: 'Apakah anda yakin akan mereset password data ini ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    confirmButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                    cancelButtonColor: '#FF0000',
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            type: "GET",
                            url: "/reset-password/" + id,
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
