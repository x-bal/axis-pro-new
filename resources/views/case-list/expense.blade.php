<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="yoriadiatma">
    <link rel="icon" href="">
    <title>Expense Case {{ $caseList->file_no }}</title>

    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
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
        .sheet.padding-5mm {
            padding-top: 1mm;
            padding-bottom: 1mm;
            padding-left: 15mm;
            padding-right: 15mm;
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
            /* body {
                background: #e0e0e0
            } */

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

<body class="A4 sheet padding-5mm">
    <div class="container-fluid">
        <h3 style="text-align: center;"><u>WORK ORDER DETAIL</u></h3>

        <div style="line-height: 11px;">
            <table width="100%">
                <tr>
                    <td width="70px">Work Order</td>
                    <td width="10px"> : </td>
                    <td width="230px">{{ $caseList->file_no }}</td>

                    <td width="100px">DOL/Instruction</td>
                    <td width="10px"> :</td>
                    <td>{{ Carbon\Carbon::parse($caseList->dol)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($caseList->instruction_date)->format('d/m/Y') }}</td>
                </tr>

                <tr>
                    <td>Policy No</td>
                    <td> :</td>
                    <td>{{ $caseList->no_leader_policy }}</td>

                    <td>Currency</td>
                    <td> :</td>
                    <td>{{ $caseList->currency == 'IDR' ? 'IDR' : 'USD' }}</td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td> : </td>
                    <td>Active</td>

                    <td>Location</td>
                    <td> : </td>
                    <td style="text-transform: uppercase;">{{ $caseList->risk_location }}</td>
                </tr>

                <tr>
                    <td>Insured</td>
                    <td> :</td>
                    <td style="text-transform: uppercase;">{{ $caseList->insured }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <strong><u>Claim No/Broker :</u></strong><br>
            <span style="text-transform: uppercase;">BROKER : {{ $caseList->broker->nama_broker }}</span>
        </div>

        <div style="margin-top: 20px;">
            <strong><u>Adjuster :</u></strong><br>
            <table style="margin-left: -4px;" width="100%">
                <tr style="text-transform: uppercase;">
                    <td width="100px"><b>{{ $caseList->adjuster->kode_adjuster }}</b></td>
                    <td>{{ $caseList->adjuster->nama_lengkap }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <strong><u>Insurers :</u></strong><br>
            <table style="margin-left: -4px;" width="100%">
                @foreach($caseList->member as $member)
                <tr style="text-transform: uppercase;">
                    <td width="200px"><b>{{ App\Models\Client::find($member->member_insurance)->brand }}</b></td>
                    <td width="400px">{{ App\Models\Client::find($member->member_insurance)->name }}</td>
                    <td>{{ $member->share}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div style="margin-top: 20px;">
            <strong><u>Expenses :</u></strong><br>
            <table style="margin-left: -4px; margin-top: 5px;" width="100%">
                @foreach($adjuster as $adj)
                <tr>
                    <td>
                        <b><u>{{ $adj->adjuster }} ({{$caseList->currency == 'IDR' ? 'IDR' : 'USD'}})</u></b>
                        <table width="100%">
                            @php
                            $expense = App\Models\Expense::where('case_list_id', $caseList->id)->where('adjuster', $adj->adjuster)->get()
                            @endphp
                            @foreach($expense as $exp)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td width="70px">{{ Carbon\Carbon::parse($exp->tanggal)->format('d/m/Y') }}</td>
                                <td width="100px"><b>{{ $exp->category_expense }}</b></td>
                                <td width="200px">{{ $exp->name }}</td>
                                <td width="50px">{{ number_format($exp->qty,2,',','.') }}</td>
                                <td style="text-align: right;">{{ number_format($exp->amount,2,',','.') }}</td>
                                <td style="text-align: right;">{{ number_format($exp->total,2,',','.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6"></td>
                                <td style="text-align: right;">________________</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td style="text-align: right;"><b>{{ number_format($expense->sum('total'),2,',','.') }}</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>
                        <table width="100%" style="margin-top: -10px;">
                            <tr>
                                <td colspan="6"></td>
                                <td style="text-align: right;">________________</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td style="text-align: right;"><b>{{ number_format($caseList->expense->sum('total'),2,',','.') }}</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>