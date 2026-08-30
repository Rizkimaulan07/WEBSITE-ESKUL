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

class NilaiPelatihExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, ShouldAutoSize
{
    private int $rowNumber = 0;

    public function __construct(private Collection $anggotas) {}

    public function collection()
    {
        return $this->anggotas;
    }

    public function headings(): array
    {
        return ['No', 'Nama Anggota', 'Kelas', 'Predikat', 'Keterangan', 'Semester', 'Tahun Ajaran'];
    }

    public function map($a): array
    {
        $this->rowNumber++;
        $nilai = $a->nilai;

        return [
            $this->rowNumber,
            $a->name,
            $a->kelas ?? '-',
            $nilai ? $nilai->predikat . ' (' . $nilai->predikat_label . ')' : 'Belum Dinilai',
            $nilai && $nilai->catatan ? $nilai->catatan : '',
            $nilai && $nilai->semester ? $nilai->semester : '-',
            $nilai && $nilai->tahun_ajaran ? $nilai->tahun_ajaran : '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 12,
            'D' => 24,
            'E' => 35,
            'F' => 12,
            'G' => 12,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0EA5E9');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G' . ($this->anggotas->count() + 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }
}