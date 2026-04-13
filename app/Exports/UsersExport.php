<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithTitle,
    WithStyles,
    WithCustomStartCell,
    WithEvents,
    ShouldAutoSize
{
    private $no = 1;

    public function collection()
    {
        return User::all();
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function map($user): array
    {
        return [
            $this->no++,
            $user->name,
            $user->email,
            $user->role,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Email',
            'Role',
        ];
    }

    public function title(): string
    {
        return 'Data Users';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'LAPORAN DATA USER');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);
            },
        ];
    }
}
