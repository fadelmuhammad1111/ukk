<?php

namespace App\Exports;

use App\Models\BorrowedItem;
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

class BorrowingsExport implements
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
        return BorrowedItem::with('item', 'staff')->get();
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function map($b): array
    {
        return [
            $this->no++,
            $b->item->item_name ?? '-',
            $b->name_borrower,
            $b->staff->name ?? '-',
            $b->total_item,
            $b->date,
            $b->returned_at ? 'Returned' : 'Borrowed',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Item',
            'Peminjam',
            'Staff',
            'Jumlah',
            'Tanggal',
            'Status',
        ];
    }

    public function title(): string
    {
        return 'Data Peminjaman';
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

                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'LAPORAN DATA PEMINJAMAN');

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
