@extends('layouts.user.main', ['title' => 'Data Inventaris'])

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Data Inventaris
                    </div>
                    <h2 class="page-title">
                        List Inventaris
                    </h2>
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
                                                <td>{{ $item->description ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        });
    </script>
@endpush
