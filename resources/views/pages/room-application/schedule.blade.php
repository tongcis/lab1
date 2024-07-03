@extends('layouts.main', ['title' => 'Jadwal Pengajuan Ruangan'])
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Jadwal Pengajuan Ruangan
                    </div>
                    <h2 class="page-title">
                        List Jadwal Pengajuan
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('pengajuan-ruangan.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Kembali
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="{{ request('date') ? request('date') : $date }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table" width="100%">
                            <thead class="text-center">
                                <tr>
                                    <th class="align-middle" width="5%" rowspan="2">No</th>
                                    <th class="align-middle" rowspan="2">Ruangan</th>
                                    <th class="align-middle" colspan="3">Jadwal</th>
                                </tr>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Yang Mengajukan</th>
                                    <th>Keperluan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody text-center">
                                @forelse ($schedule as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key }}</td>
                                        @foreach ($item as $val)
                                            <td>{{ $val->start_time . ' -' . $val->end_time }}</td>
                                            <td>{{ $val->user->name }}</td>
                                            <td>{{ $val->typeRoom->name }}</td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#date').on('change', function() {
                let date = $(this).val();

                url = "{{ url('pengajuan-ruangan/jadwal') }}";

                if (date === '') {
                    window.location.href = url;
                } else {
                    window.location.href = url + `?date=${date}`;
                }
            });
        })
    </script>
@endpush
