<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigment Info {{ $caseList->file_no }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0;
            font-family: 'Open Sans';
            font-size: 12;
        }

        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: normal;
            src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
        }

        .sheet.padding-1mm {
            padding: 5mm
        }
    </style>
</head>

<body class="A4 landscape">
    <div class="container-fluid sheet padding-1mm">
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
                        <p>{{ App\Models\Client::find($member->member_insurance)->name ?? 'Kosong' }} ({{ $member->share }}) - @if($member->is_leader) <strong class="text-dark">Leader</strong> @else <strong class="text-secondary">Member</strong> @endif</p>
                        @endforeach
                    </td>
                    <td>LOCATION RISK / PROJECT</td>
                    <td>:</td>
                    <td>{{ $caseList->risk_location }}</td>
                </tr>
                <tr>
                    <td>BROKER</td>
                    <td>:</td>
                    <td><span class="text-dark"><b>{{ $caseList->broker->nama_broker }}</b></span> </td>
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
                    <td>{{ $caseList->leader_claim_no }} - {{ $caseList->no_ref_surat_asuransi }}</td>
                </tr>
                <tr>
                    <td>NOW UPDATE</td>
                    <td>:</td>
                    <td>{{ $caseList->now_update }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>