<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigment Info {{ $caseList->file_no }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12;
        }

        .table-kop tr td {
            padding: 5px;
        }

        .italic {
            font-style: italic;
        }

        .sheet {
            overflow: hidden;
            position: relative;
            display: block;
            margin: 0 auto;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm
        }

        body.struk .sheet {
            width: 100mm;
        }

        body.A4.landscape .sheet {
            width: 297mm;
            height: 209mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        /** Padding area **/
        .sheet.padding-1mm {
            padding: 1mm
        }

        .sheet.padding-10mm {
            padding: 10mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
                display: block;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape {
                width: 420mm
            }

            body.A3,
            body.A4.landscape {
                width: 297mm
            }

            body.A4,
            body.A5.landscape {
                width: 210mm
            }

            body.A5 {
                width: 148mm
            }
        }
    </style>
</head>

<body class="A4 landscape">
    <section class="sheet padding-10mm">
        <h4>Assigment Info {{ $caseList->file_no }}</h4>
        <table width="100%" class="table table-bordered table-striped" style="font-size: 12px; margin-top: 20px;">
            <tbody>
                <tr>
                    <td width="12%">CURRENT STATUS</td>
                    <td width="2%">:</td>
                    <td width="31%">{{ $caseList->status->nama_status }} </td>
                    <td width="15%">INSURED</td>
                    <td width="2%">:</td>
                    <td width="38%">{{ $caseList->insurance->name }}</td>
                </tr>
                <tr>
                    <td width="12%">FILE NO</td>
                    <td width="2%">:</td>
                    <td width="31%">{{ $caseList->file_no }}</td>
                    <td width="15%">INSURED</td>
                    <td width="2%">:</td>
                    <td width="38%">{{ $caseList->insurance->name }}</td>
                </tr>
                <tr>
                    <td>INITIAL ADJUSTER</td>
                    <td>:</td>
                    <td>{{ $caseList->adjuster->kode_adjuster }} ({{ $caseList->adjuster->nama_lengkap }})</td>
                    <td>DOL</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($caseList->dol)->format('d-M-Y') }}</td>
                </tr>
                <tr>
                    <td>INSURANCE</td>
                    <td>:</td>
                    <td>
                        @foreach($caseList->member as $member)
                        <p>{{ App\Models\Client::find($member->member_insurance)->name ?? 'Kosong' }} ({{ $member->share }}) - @if($member->is_leader) <strong class="text-primary">Leader</strong> @else <strong class="text-secondary">Member</strong> @endif</p>
                        @endforeach
                    </td>
                    <td>LOCATION RISK / PROJECT</td>
                    <td>:</td>
                    <td>{{ $caseList->risk_location }}</td>
                </tr>
                <tr>
                    <td>BROKER</td>
                    <td>:</td>
                    <td><span class="bg-secondary p-2 text-light">{{ $caseList->broker->nama_broker }}</span> </td>
                    <td>CAUSE OF LOSS</td>
                    <td>:</td>
                    <td>{{ $caseList->incident->type_incident }}</td>
                </tr>
                <tr>
                    <td>TYPE OF BUSINESS</td>
                    <td>:</td>
                    <td>{{ $caseList->policy->type_policy }}</td>
                    <td>LEADER POLICY</td>
                    <td>:</td>
                    <td>{{ $caseList->no_leader_policy }} | PERIOD BEGIN : {{ Carbon\Carbon::parse($caseList->begin)->format('d-M-Y') }} PERIOD END : {{ Carbon\Carbon::parse($caseList->end)->format('d-M-Y') }} <br> </td>
                </tr>
                <tr>
                    <td>SURVEY DATE</td>
                    <td>:</td>
                    <td>{{ $caseList->survey_date }}</td>
                    <td>LEADER CLAIM NO</td>
                    <td>:</td>
                    <td>{{ $caseList->leader_claim_no }}</td>
                </tr>
                <tr>
                    <td>NOW UPDATE</td>
                    <td>:</td>
                    <td>{{ $caseList->now_update }}</td>
                    <td>AGING (DAY)</td>
                    <td>:</td>
                    <td>
                        {{ Carbon\Carbon::parse($caseList->instruction_date)->diff($caseList->file_status_id == 5 ? $caseList->now_update : Carbon\Carbon::now())->d  }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>