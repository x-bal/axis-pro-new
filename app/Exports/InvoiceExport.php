<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class InvoiceExport implements FromCollection, ShouldAutoSize, WithHeadings,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $attr;
    public function __construct($attr)
    {
        $this->attr = $attr;        
    }
    public function collection()
    {
        $no = 1;
        $collection = new Collection();
        $invoice = Invoice::whereBetween('date_invoice', [$this->attr['from'], $this->attr['to']])->get();
        foreach($invoice as $data){
            $collection->push([
                'id' => $no++,
                'bank_id' => $data->bank->bank_name ?? 'Kosong',
                'case_list_id' => $data->caselist->file_no,
                'no_invoice' => $data->no_invoice,
                'member_id' => $data->member->name,
                'due_date' => $data->due_date,
                'date_invoice' => $data->date_invoice,
                'grand_total' => $data->grand_total,
                'status_paid' => $data->status_paid,
                'is_active' => $data->is_active,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at
            ]);
        }
        return $collection;
    }
    
    public function styles(Worksheet $sheet)
    {
        $string = 'A1:L1';
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle($string)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
    
    public function headings(): array
    {
        return [
            [
                'id',
                'bank_id',
                'file_no',
                'no_invoice',
                'member_id',
                'due_date',
                'date_invoice',
                'grand_total',
                'status_paid',
                'is_active',
                'created_at',
                'updated_at'
            ]
        ];
    }
}
