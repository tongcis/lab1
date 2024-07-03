@extends('layouts.main', ['title' => 'Profil'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Profil
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-center">
                                    @if (($user->hasRole('Laboratory Team') || $user->hasRole('Leader')) && $user->lecturer->photo)
                                        <img class="img-fluid" height="500"
                                            src="{{ asset('storage/' . $user->lecturer->photo) }}" alt="">
                                    @else
                                        <img class="img-fluid" height="500" src="{{ asset('images/user.png') }}"
                                            alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h2>{{ $user->name }}</h2>
                                </div>
                                <div class="card-body">
                                    <table width="100%">
                                        <tr>
                                            <td>NIS</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->nis }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telepon</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Program Studi</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->studyProgram->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td> : </td>
                                            <td>{{ $user->lecturer->position() }}</td>
                                        </tr>
                                    </table>
                                    <div class="d-flex justify-content-end mt-3">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning d-none d-sm-inline-block"
                                                id="edit" value="{{ $user->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                                Ubah
                                            </button><button type="button"
                                                class="btn btn-secondary d-none d-sm-inline-block" id="changePassword"
                                                value="{{ $user->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-lock-cog">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 21h-5a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h10c.564 0 1.074 .234 1.437 .61" />
                                                    <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                    <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                    <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    <path d="M19.001 15.5v1.5" />
                                                    <path d="M19.001 21v1.5" />
                                                    <path d="M22.032 17.25l-1.299 .75" />
                                                    <path d="M17.27 20l-1.3 .75" />
                                                    <path d="M15.97 17.25l1.3 .75" />
                                                    <path d="M20.733 20l1.3 .75" />
                                                </svg>
                                                Ubah Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('pages.profile.modal')
    @includeIf('pages.profile.modal-change-password')
@endsection
@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '#edit', function() {
            let id = $(this).val();
            $('span.error_text').html("");
            $.ajax({
                type: "GET",
                url: "/dosen/" + id + '/profil/edit',
                success: function(response) {
                    $('#title').html("Ubah Profil");
                    $('#modal').modal('show');
                    $('#id').val(response.id);
                    $('#lecturer_id').val(response.lecturer.id);
                    $('#nis').val(response.lecturer.nis);
                    $('#name').val(response.lecturer.name);
                    $('#email').val(response.lecturer.email);
                    $('#gender').val(response.lecturer.gender);
                    $('#address').val(response.lecturer.address);
                    $('#phone').val(response.lecturer.phone);
                    $('#position').val(response.lecturer.position_id);
                    $('#study_program_id').val(response.lecturer.study_program_id);
                }
            });
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

        $('#changePassword').click(function() {
            $('#second-form').trigger("reset");;
            let id = $(this).val();
            $('#user_id').val(id);
            $('span.error_text').html("");
            $('#second-title').html("Ubah Password");
            $('#second-modal').modal('show');
        });

        $('#second-form').on('submit', function(e) {
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
                        $('#second-form').trigger("reset");;
                        $('#second-modal').modal('hide');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            })
        })
    </script>
@endpush
