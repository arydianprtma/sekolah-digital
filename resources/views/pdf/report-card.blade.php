<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor Peserta Didik</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1, .header h2, .header h3 { margin: 0; padding: 2px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px; vertical-align: top; }
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 8px; text-align: center; }
        .table-data th { background-color: #f2f2f2; }
        .text-left { text-align: left !important; }
        .signature { width: 100%; margin-top: 50px; }
        .signature td { width: 50%; text-align: center; }
        .signature .name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN HASIL BELAJAR PESERTA DIDIK</h2>
        <h3>SEKOLAH DIGITAL INDONESIA</h3>
    </div>

    <table class="info-table">
        <tr>
            <td width="20%"><strong>Nama Siswa</strong></td>
            <td width="2%">:</td>
            <td width="38%">{{ $reportCard->student->nama_lengkap }}</td>
            <td width="20%"><strong>Kelas</strong></td>
            <td width="2%">:</td>
            <td width="18%">{{ $reportCard->student->classroom->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NISN</strong></td>
            <td>:</td>
            <td>{{ $reportCard->student->nisn }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td>{{ $reportCard->academicYear->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>:</td>
            <td>{{ $reportCard->student->classroom->teacher->nama ?? '-' }}</td>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td>{{ $reportCard->academicYear->semester }}</td>
        </tr>
    </table>

    <h4 style="margin-bottom: 5px;">A. Nilai Akademik</h4>
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th class="text-left" width="45%">Mata Pelajaran</th>
                <th width="15%">KKM</th>
                <th width="15%">Nilai Akhir</th>
                <th width="20%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($finalGrades as $index => $grade)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $grade['nama_mapel'] }}</td>
                <td>{{ $grade['kkm'] }}</td>
                <td><strong>{{ $grade['nilai_akhir'] }}</strong></td>
                <td>{{ $grade['predikat'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada nilai mata pelajaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h4 style="margin-bottom: 5px;">B. Nilai Sikap & Spiritual</h4>
    <table class="table-data" style="width: 50%;">
        <thead>
            <tr>
                <th>Aspek</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left">Sikap Sosial</td>
                <td>{{ $reportCard->nilai_sikap }}</td>
            </tr>
            <tr>
                <td class="text-left">Sikap Spiritual</td>
                <td>{{ $reportCard->nilai_spiritual }}</td>
            </tr>
        </tbody>
    </table>

    <h4 style="margin-bottom: 5px;">C. Ketidakhadiran</h4>
    <table class="table-data" style="width: 50%;">
        <tbody>
            <tr><td class="text-left" width="50%">Hadir</td><td>{{ $rekapAbsensi['Hadir'] }} hari</td></tr>
            <tr><td class="text-left">Sakit</td><td>{{ $rekapAbsensi['Sakit'] }} hari</td></tr>
            <tr><td class="text-left">Izin</td><td>{{ $rekapAbsensi['Izin'] }} hari</td></tr>
            <tr><td class="text-left">Tanpa Keterangan</td><td>{{ $rekapAbsensi['Alpa'] }} hari</td></tr>
        </tbody>
    </table>

    <h4 style="margin-bottom: 5px;">D. Catatan Wali Kelas</h4>
    <div style="border: 1px solid #000; padding: 10px; min-height: 50px;">
        {{ $reportCard->catatan_wali_kelas ?? 'Tidak ada catatan.' }}
    </div>

    @if($reportCard->status_kenaikan)
    <h4 style="margin-bottom: 5px; margin-top: 15px;">E. Keputusan</h4>
    <div style="border: 1px solid #000; padding: 10px;">
        Berdasarkan hasil pencapaian kompetensi pada semester ini, peserta didik ditetapkan: <strong>{{ $reportCard->status_kenaikan }}</strong>
    </div>
    @endif

    <table class="signature">
        <tr>
            <td>
                Mengetahui,<br>
                Orang Tua / Wali<br>
                <div class="name">.........................................</div>
            </td>
            <td>
                Jakarta, {{ date('d F Y') }}<br>
                Wali Kelas<br>
                <div class="name">{{ $reportCard->student->classroom->teacher->nama ?? '.........................................' }}</div>
            </td>
        </tr>
    </table>
</body>
</html>
