<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiAnggotaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize
{
    private int $rowNumber = 0;

    public function __construct(private Collection $nilai) {}

    public function collection()
    {
        return $this->nilai;
    }

    public function headings(): array
    {
        return ['No', 'Nama Anggota', 'Kelas', 'Ekskul', 'Predikat', 'Keterangan', 'Pelatih', 'Semester', 'Tahun Ajaran', 'Dinilai Pada'];
    }

    public function map($n): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $n->anggota->name ?? '-',
            $n->anggota->kelas ?? '-',
            $n->ekskul->nama_ekskul ?? '-',
            $n->predikat ? $n->predikat . ' (' . $n->predikat_label . ')' : '-',
            $n->catatan ?? '',
            $n->pelatih->name ?? '-',
            $n->semester ?? '-',
            $n->tahun_ajaran ?? '-',
            $n->created_at->format('d-m-Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 12,
            'D' => 20,
            'E' => 24,
            'F' => 35,
            'G' => 25,
            'H' => 12,
            'I' => 12,
            'J' => 18,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0EA5E9');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J' . ($this->nilai->count() + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}