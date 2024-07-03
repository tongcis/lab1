<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Pengajuan {{ \Carbon\Carbon::parse($data['start_date'])->format('d F Y') }} -
        {{ \Carbon\Carbon::parse($data['end_date'])->format('d F Y') }}</title>
</head>

<body>

    <center>
        <div style="text-align: center; text-transform: uppercase; font-weight: bold; font-size: 18px">
            Laporan Data Pengajuan Ruangan
        </div>
        <div style="text-align: center; text-transform: uppercase; font-weight: bold; font-size: 18px">
            {{ \Carbon\Carbon::parse($data['start_date'])->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($data['end_date'])->format('d F Y') }}
        </div>
    </center>

    <hr style="margin:10px 0">
    <table width="100%" style="border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr style="text-align: center;">
                <th style="border: 1px solid black;">Tanggal</th>
                <th style="border: 1px solid black;">Jam</th>
                <th style="border: 1px solid black;">Ruangan</th>
                <th style="border: 1px solid black;">Prodi</th>
                <th style="border: 1px solid black;">Jenis Keperluan</th>
                <th style="border: 1px solid black;">Mata Kuliah/Nama Kegiatan</th>
                <th style="border: 1px solid black;">Nama Pengaju</th>
                <th style="border: 1px solid black;">Dosen Pengampu/Penanggung Jawab</th>
                <th style="border: 1px solid black;">Keterangan</th>
                <th style="border: 1px solid black;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['items'] as $item)
                <tr style="text-align: center;">
                    <td style="border: 1px solid black;">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                    <td style="border: 1px solid black;">{{ $item->start_time }} - {{ $item->end_time }}</td>
                    <td style="border: 1px solid black;">{{ $item->room->name }}</td>
                    <td style="border: 1px solid black;">
                        {{ $item->typeRoom->is_learning == 1 ? $item->course->studyProgram->name : $item->activity_name }}
                    </td>
                    @if ($item->typeRoom->is_learning == 1)
                        <td style="border: 1px solid black;">{{ $item->typeRoom->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->course->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->user->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->lecturer->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->description ?? '-' }}</td>
                    @else
                        <td style="border: 1px solid black;">{{ $item->typeRoom->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->activity_name }}</td>
                        <td style="border: 1px solid black;">{{ $item->user->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->lecturer->name }}</td>
                        <td style="border: 1px solid black;">{{ $item->description ?? '-' }}</td>
                    @endif
                    <td style="border: 1px solid black;">
                        @if ($item->status == 1)
                            Submitted
                        @endif
                        @if ($item->status == 2)
                            Approved
                        @endif
                        @if ($item->status == 3)
                            Rejected
                        @endif
                        @if ($item->status == 4)
                            Done
                        @endif
                    </td>
                </tr>
            @empty
                <tr style="text-align: center">
                    <td colspan="10"><b>Data tidak ditemukan.</b></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
