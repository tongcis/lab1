@extends('layouts.main', ['title' => 'Dashboard'])
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <h1>Dashboard</h1>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table" width="100%">
                            <thead class="text-center">
                                <tr>
                                    <th>Ruangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody text-center">
                                @forelse ($rooms as $key => $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge p-2 bg-success text-white">Tersedia</span>
                                            @else
                                                <button type="button" class="btn btn-warning" id="detail"
                                                    value="{{ $item->id }}">
                                                    Tidak Tersedia
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="2">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @includeIf('pages.dashboard.modal-detail')
@endsection
@push('js')
    <script>
        $('body').on('click', '#detail', function() {
            let id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/detail-room/" + id,
                success: function(response) {
                    $('#title-detail').html("Detail Data Penggunaan Ruangan");
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
    </script>
@endpush
