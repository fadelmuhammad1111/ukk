<?php

namespace App\Exports;

use App\Models\Item;
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

class ItemsExport implements
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
        return Item::with('category')
            ->withCount([
                'borrowedItems as total_borrowed' => function ($q) {
                    $q->whereNull('returned_at');
                }
            ])
            ->get();
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->item_name,
            $item->category->name ?? '-',
            $item->total_stock,
            $item->total_borrowed,
            $item->total_repaired,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Item',
            'Kategori',
            'Stock',
            'Dipinjam',
            'Rusak',
        ];
    }

    public function title(): string
    {
        return 'Data Items';
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

                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN DATA ITEM');

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
