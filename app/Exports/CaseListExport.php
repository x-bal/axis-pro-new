<?php

namespace App\Exports;

use App\Models\CaseList;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class CaseListExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
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
        if (auth()->user()->hasRole('admin')) {
            if ($this->attr['adjuster'] == "All") {
                $case =  CaseList::select(
                    'id',
                    'file_no',
                    'insurance_id',
                    'adjuster_id',
                    'broker_id',
                    'incident_id',
                    'policy_id',
                    'category',
                    'insured',
                    'risk_location',
                    'currency',
                    'leader',
                    'begin',
                    'end',
                    'dol',
                    'no_leader_policy',
                    'leader_claim_no',
                    'instruction_date',
                    'survey_date',
                    'now_update',
                    'ia_date',
                    'ia_amount',
                    'pr_date',
                    'pr_amount',
                    'ir_st_date',
                    'ir_st_amount',
                    'ir_nd_date',
                    'ir_nd_amount',
                    'pa_date',
                    'pa_amount',
                    'fr_date',
                    'fr_amount',
                    'claim_amount',
                    'fee_idr',
                    'fee_usd',
                    'wip_idr',
                    'wip_usd',
                    'remark',
                    'file_status_id'
                )->whereBetween('instruction_date', [$this->attr['from'], $this->attr['to']])->get();

                foreach ($case as $data) {
                    $collection->push([
                        "id" => $no++,
                        "file_no" => $data->file_no,
                        "insurance_id" => $data->insurance->name,
                        "adjuster_id" => $data->adjuster->nama_lengkap,
                        "broker_id" => $data->broker->nama_broker,
                        "incident_id" => $data->incident->type_incident,
                        "policy_id" => $data->policy->type_policy,
                        "category" => $data->category,
                        "insured" => $data->insured,
                        "risk_location" => $data->risk_location,
                        "currency" => $data->currency,
                        "leader" => $data->leader,
                        "begin" => $data->begin,
                        "end" => $data->end,
                        "dol" => $data->dol,
                        "no_leader_policy" => $data->no_leader_policy,
                        "leader_claim_no" => $data->leader_claim_no,
                        "instruction_date" => $data->instruction_date,
                        "survey_date" => $data->survey_date,
                        "now_update" => $data->now_update,
                        "ia_date" => $data->ia_date,
                        "ia_amount" => $data->ia_amount,
                        "pr_date" => $data->pr_date,
                        "pr_amount" => $data->pr_amount,
                        "ir_st_date" => $data->ir_st_date,
                        "ir_st_amount" => $data->ir_st_amount,
                        "ir_nd_date" => $data->ir_nd_date,
                        "ir_nd_amount" => $data->ir_nd_amount,
                        "pa_date" => $data->pa_date,
                        "pa_amount" => $data->pa_amount,
                        "fr_date" => $data->fr_date,
                        "fr_amount" => $data->fr_amount,
                        "claim_amount" => $data->claim_amount,
                        "fee_idr" => $data->fee_idr,
                        "fee_usd" => $data->fee_usd,
                        "wip_idr" => $data->wip_idr,
                        "wip_usd" => $data->wip_usd,
                        "remark" => $data->remark,
                        "file_status_id" => $data->status->nama_status
                    ]);
                }

                return $collection;
            }
            $case = CaseList::select(
                'id',
                'file_no',
                'insurance_id',
                'adjuster_id',
                'broker_id',
                'incident_id',
                'policy_id',
                'category',
                'insured',
                'risk_location',
                'currency',
                'leader',
                'begin',
                'end',
                'dol',
                'no_leader_policy',
                'leader_claim_no',
                'instruction_date',
                'survey_date',
                'now_update',
                'ia_date',
                'ia_amount',
                'pr_date',
                'pr_amount',
                'ir_st_date',
                'ir_st_amount',
                'ir_nd_date',
                'ir_nd_amount',
                'pa_date',
                'pa_amount',
                'fr_date',
                'fr_amount',
                'claim_amount',
                'fee_idr',
                'fee_usd',
                'wip_idr',
                'wip_usd',
                'remark',
                'file_status_id'
            )->whereBetween('instruction_date', [$this->attr['from'], $this->attr['to']])->where('adjuster_id', $this->attr['adjuster'])->get();

            foreach ($case as $data) {
                $collection->push([
                    "id" => $no++,
                    "file_no" => $data->file_no,
                    "insurance_id" => $data->insurance->name,
                    "adjuster_id" => $data->adjuster->nama_lengkap,
                    "broker_id" => $data->broker->nama_broker,
                    "incident_id" => $data->incident->type_incident,
                    "policy_id" => $data->policy->type_policy,
                    "category" => $data->category,
                    "insured" => $data->insured,
                    "risk_location" => $data->risk_location,
                    "currency" => $data->currency,
                    "leader" => $data->leader,
                    "begin" => $data->begin,
                    "end" => $data->end,
                    "dol" => $data->dol,
                    "no_leader_policy" => $data->no_leader_policy,
                    "leader_claim_no" => $data->leader_claim_no,
                    "instruction_date" => $data->instruction_date,
                    "survey_date" => $data->survey_date,
                    "now_update" => $data->now_update,
                    "ia_date" => $data->ia_date,
                    "ia_amount" => $data->ia_amount,
                    "pr_date" => $data->pr_date,
                    "pr_amount" => $data->pr_amount,
                    "ir_st_date" => $data->ir_st_date,
                    "ir_st_amount" => $data->ir_st_amount,
                    "ir_nd_date" => $data->ir_nd_date,
                    "ir_nd_amount" => $data->ir_nd_amount,
                    "pa_date" => $data->pa_date,
                    "pa_amount" => $data->pa_amount,
                    "fr_date" => $data->fr_date,
                    "fr_amount" => $data->fr_amount,
                    "claim_amount" => $data->claim_amount,
                    "fee_idr" => $data->fee_idr,
                    "fee_usd" => $data->fee_usd,
                    "wip_idr" => $data->wip_idr,
                    "wip_usd" => $data->wip_usd,
                    "remark" => $data->remark,
                    "file_status_id" => $data->status->nama_status
                ]);
            }

            return $collection;
        } else {
            if ($this->attr['status'] == "All") {
                $case =  CaseList::select(
                    'id',
                    'file_no',
                    'insurance_id',
                    'adjuster_id',
                    'broker_id',
                    'incident_id',
                    'policy_id',
                    'category',
                    'insured',
                    'risk_location',
                    'currency',
                    'leader',
                    'begin',
                    'end',
                    'dol',
                    'no_leader_policy',
                    'leader_claim_no',
                    'instruction_date',
                    'survey_date',
                    'now_update',
                    'ia_date',
                    'ia_amount',
                    'pr_date',
                    'pr_amount',
                    'ir_st_date',
                    'ir_st_amount',
                    'ir_nd_date',
                    'ir_nd_amount',
                    'pa_date',
                    'pa_amount',
                    'fr_date',
                    'fr_amount',
                    'claim_amount',
                    'fee_idr',
                    'fee_usd',
                    'wip_idr',
                    'wip_usd',
                    'remark',
                    'file_status_id'
                )->where('adjuster_id', auth()->user()->id)->whereBetween('instruction_date', [$this->attr['from'], $this->attr['to']])->get();

                foreach ($case as $data) {
                    $collection->push([
                        "id" => $no++,
                        "file_no" => $data->file_no,
                        "insurance_id" => $data->insurance->name,
                        "adjuster_id" => $data->adjuster->nama_lengkap,
                        "broker_id" => $data->broker->nama_broker,
                        "incident_id" => $data->incident->type_incident,
                        "policy_id" => $data->policy->type_policy,
                        "category" => $data->category,
                        "insured" => $data->insured,
                        "risk_location" => $data->risk_location,
                        "currency" => $data->currency,
                        "leader" => $data->leader,
                        "begin" => $data->begin,
                        "end" => $data->end,
                        "dol" => $data->dol,
                        "no_leader_policy" => $data->no_leader_policy,
                        "leader_claim_no" => $data->leader_claim_no,
                        "instruction_date" => $data->instruction_date,
                        "survey_date" => $data->survey_date,
                        "now_update" => $data->now_update,
                        "ia_date" => $data->ia_date,
                        "ia_amount" => $data->ia_amount,
                        "pr_date" => $data->pr_date,
                        "pr_amount" => $data->pr_amount,
                        "ir_st_date" => $data->ir_st_date,
                        "ir_st_amount" => $data->ir_st_amount,
                        "ir_nd_date" => $data->ir_nd_date,
                        "ir_nd_amount" => $data->ir_nd_amount,
                        "pa_date" => $data->pa_date,
                        "pa_amount" => $data->pa_amount,
                        "fr_date" => $data->fr_date,
                        "fr_amount" => $data->fr_amount,
                        "claim_amount" => $data->claim_amount,
                        "fee_idr" => $data->fee_idr,
                        "fee_usd" => $data->fee_usd,
                        "wip_idr" => $data->wip_idr,
                        "wip_usd" => $data->wip_usd,
                        "remark" => $data->remark,
                        "file_status_id" => $data->status->nama_status
                    ]);
                }

                return $collection;
            }
            $case = CaseList::select(
                'id',
                'file_no',
                'insurance_id',
                'adjuster_id',
                'broker_id',
                'incident_id',
                'policy_id',
                'category',
                'insured',
                'risk_location',
                'currency',
                'leader',
                'begin',
                'end',
                'dol',
                'no_leader_policy',
                'leader_claim_no',
                'instruction_date',
                'survey_date',
                'now_update',
                'ia_date',
                'ia_amount',
                'pr_date',
                'pr_amount',
                'ir_st_date',
                'ir_st_amount',
                'ir_nd_date',
                'ir_nd_amount',
                'pa_date',
                'pa_amount',
                'fr_date',
                'fr_amount',
                'claim_amount',
                'fee_idr',
                'fee_usd',
                'wip_idr',
                'wip_usd',
                'remark',
                'file_status_id'
            )->where('adjuster_id', auth()->user()->id)->whereBetween('instruction_date', [$this->attr['from'], $this->attr['to']])->where('file_status_id', $this->attr['status'])->get();

            foreach ($case as $data) {
                $collection->push([
                    "id" => $no++,
                    "file_no" => $data->file_no,
                    "insurance_id" => $data->insurance->name,
                    "adjuster_id" => $data->adjuster->nama_lengkap,
                    "broker_id" => $data->broker->nama_broker,
                    "incident_id" => $data->incident->type_incident,
                    "policy_id" => $data->policy->type_policy,
                    "category" => $data->category,
                    "insured" => $data->insured,
                    "risk_location" => $data->risk_location,
                    "currency" => $data->currency,
                    "leader" => $data->leader,
                    "begin" => $data->begin,
                    "end" => $data->end,
                    "dol" => $data->dol,
                    "no_leader_policy" => $data->no_leader_policy,
                    "leader_claim_no" => $data->leader_claim_no,
                    "instruction_date" => $data->instruction_date,
                    "survey_date" => $data->survey_date,
                    "now_update" => $data->now_update,
                    "ia_date" => $data->ia_date,
                    "ia_amount" => $data->ia_amount,
                    "pr_date" => $data->pr_date,
                    "pr_amount" => $data->pr_amount,
                    "ir_st_date" => $data->ir_st_date,
                    "ir_st_amount" => $data->ir_st_amount,
                    "ir_nd_date" => $data->ir_nd_date,
                    "ir_nd_amount" => $data->ir_nd_amount,
                    "pa_date" => $data->pa_date,
                    "pa_amount" => $data->pa_amount,
                    "fr_date" => $data->fr_date,
                    "fr_amount" => $data->fr_amount,
                    "claim_amount" => $data->claim_amount,
                    "fee_idr" => $data->fee_idr,
                    "fee_usd" => $data->fee_usd,
                    "wip_idr" => $data->wip_idr,
                    "wip_usd" => $data->wip_usd,
                    "remark" => $data->remark,
                    "file_status_id" => $data->status->nama_status
                ]);
            }

            return $collection;
        }
    }
    public function styles(Worksheet $sheet)
    {
        $string = 'A1:AM1';
        $sheet->getStyle('A1:AM1')->getFont()->setBold(true);
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
                'file_no',
                'insurance',
                'adjuster',
                'broker',
                'incident',
                'policy',
                'category',
                'insured',
                'risk_location',
                'currency',
                'leader',
                'begin',
                'end',
                'dol',
                'no_leader_policy',
                'leader_claim_no',
                'instruction_date',
                'survey_date',
                'now_update',
                'ia_date',
                'ia_amount',
                'pr_date',
                'pr_amount',
                'ir_st_date',
                'ir_st_amount',
                'ir_nd_date',
                'ir_nd_amount',
                'pa_date',
                'pa_amount',
                'fr_date',
                'fr_amount',
                'claim_amount',
                'fee_idr',
                'fee_usd',
                'wip_idr',
                'wip_usd',
                'remark',
                'file_status',
            ]
        ];
    }
}
