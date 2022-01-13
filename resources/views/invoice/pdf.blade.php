<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->no_invoice }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    html {
        font-family: Sans-serif
    }

    body {
        padding: 50px;
    }

    table {
        font-size: 12px;
    }
</style>

<body>
    <img style="float: right;" src="https://i.postimg.cc/q7jyd5J1/Axis-Logo-with-tagline-Medium.jpg" alt="" width="400px">
    <h5 class="text-center" style="clear: right; margin-top: 40px;"><b>
            @if($invoice->type_invoice == 1)
            INTERIM INVOICE
            @endif
            @if($invoice->type_invoice == 2)
            PROFORMA INVOICE
            @endif
            @if($invoice->type_invoice == 3)
            FINAL INVOICE
            @endif
        </b></h5>
    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table cellpadding="0">
                    <tr>
                        <th width="150">Invoice Number</th>
                        <th width="10">:</th>
                        <th>{{ $invoice->no_invoice }}</th>
                    </tr>
                    <tr>
                        <th width="150">Our Reference</th>
                        <th width="10">:</th>
                        <td>{{ $invoice->caselist->file_no }}/{{ $invoice->caselist->adjuster->kode_adjuster }}</td>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left: 67%;">
                <table>
                    <tr>
                        <th>Date</th>
                        <th width="50">:</th>
                        <td>{{ Carbon\Carbon::parse($invoice->date_invoice)->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table cellpadding="5">
                    <tr>
                        <th>To.</th>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left :10%">
                <table width="100%">
                    <tr>
                        <th width="330px">{{ $invoice->member->name }}</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>{{ $invoice->member->address }}</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr style="border : 2px double black; margin-top: -10px;">

        <div class="row">
            <div class="col">
                <table cellpadding="5">
                    <tr>
                        <th>Re</th>
                    </tr>
                </table>
            </div>
            <div class="col" style="margin-left :10%">
                <table cellpadding="0">
                    <tr>
                        <th width="100">Client</th>
                        <th width="10">:</th>
                        <th>{{ $invoice->caselist->insured }}</th>
                    </tr>
                    @if($caselist->category == 1)
                    <tr>
                        <th>Conveyance</th>
                        <th>:</th>
                        <th>{{ $caselist->conveyance }}</th>
                    </tr>
                    @endif
                    @if($caselist->category == 2)
                    <tr>
                        <th>Location Of Loss</th>
                        <th>:</th>
                        <th>{{ $caselist->location_of_loss }}</th>
                    </tr>
                    @endif
                    <tr>
                        <th>Date Of Loss</th>
                        <th>:</th>
                        <th>{{ Carbon\Carbon::parse($invoice->caselist->dol)->format('d F Y') }}</th>
                    </tr>
                    <tr>
                        <th>Insurer's Ref</th>
                        <th>:</th>
                        <th>{{ $invoice->caselist->no_ref_surat_asuransi }}</th>
                    </tr>
                    <tr>
                        <th>Policy No</th>
                        <th>:</th>
                        <th>{{ $invoice->caselist->no_leader_policy }}</th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col" style="margin-left:10%;">
                <table>
                    <tr>
                        <th><u>Professional Services</u></th>
                    </tr>
                    <tr>
                        <td>
                            <table style="margin-left: 20px; margin-bottom: 10px;">
                                <tr>
                                    <td width="150px">Professional Fee</td>
                                    <td width="250px">Your Share</td>
                                    <td width="50px">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>{{ $invoice->type_invoice != 1 ? number_format($fee_adj, 2) : number_format($caselist->professional_service, 2) }}</td>
                                    <td>{{ $invoice->type_invoice != 1 ? number_format($share, 2) : number_format($share, 2) }}%</td>
                                    <td>{{ $caselist->currency }}</td>
                                    <td width="100px" class="text-right">
                                        {{ $invoice->type_invoice != 1 ? number_format($fee_adj * $share / 100, 2) : number_format($caselist->professional_service * $share / 100, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                @php
                                $discount = $invoice->caselist->discount != 0 ? $invoice->caselist->discount : ($fee_adj * $share / 100) * $invoice->caselist->discount_percent / 100
                                @endphp
                                <tr>
                                    @if($invoice->type_invoice != 1)
                                    @if($invoice->caselist->discount != 0 || $invoice->caselist->discount_percent != 0)
                                    <td>
                                        <b>Discount Fee </b>
                                    </td>
                                    <td>
                                        {{ $invoice->caselist->discount != 0 ? '' : $invoice->caselist->discount_percent .'%' }}
                                    </td>
                                    <td>{{ $caselist->currency }}</td>
                                    <td width="100px" class="text-right">
                                        {{ number_format($discount) }}
                                    </td>
                                    @endif
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <th><u>Expenses</u></th>
                    </tr>
                    <tr>
                        <td>
                            <table style="margin-left: 20px; margin-bottom: 10px;">
                                <tr>
                                    <td width="150px">Others</td>
                                    <td width="250px">Your Share</td>
                                    <td width="50px">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($inv->type_invoice == 1)
                                        {{ number_format($inv->caselist->expense->where('is_active', 1)->sum('total'), 2) }}
                                        @else
                                        {{ number_format($inv->caselist->expense->where('is_active', 2)->sum('total'), 2) }}
                                        @endif
                                    </td>
                                    <td>{{ number_format($share, 2) }}%</td>
                                    <td>{{ $caselist->currency }}</td>
                                    <td width="100px" class="text-right">
                                        @if($inv->type_invoice == 1)
                                        {{ number_format($inv->caselist->expense->where('is_active', 1)->sum('total') * $share / 100, 2) }}
                                        @else
                                        {{ number_format($inv->caselist->expense->where('is_active', 2)->sum('total') * $share / 100, 2) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom: 1px solid black;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style=" margin-bottom: 10px;">
                                <tr>
                                    <td width="150px">Sub Total</td>
                                    <td width="270px"></td>
                                    <td width="50px">{{ $caselist->currency }}</td>
                                    <td width="100px" class="text-right">
                                        @if($inv->type_invoice == 1)
                                        {{number_format(($inv->caselist->expense->where('is_active', 1)->sum('total') * $share / 100) + ($caselist->professional_service * $share / 100) - $discount , 2) }}
                                        @else
                                        {{ number_format(($fee_adj * $share / 100) + ($inv->caselist->expense->where('is_active', 2)->sum('total') * $share / 100) - $discount, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table style="margin-left: 20px;  margin-bottom: 10px;">
                                <tr>
                                    <th width="150px">
                                        PPN 10%
                                    </th>
                                    <td width="250px"></td>
                                    <td width="50px">{{ $caselist->currency }}</td>
                                    <td width="100px" class="text-right">
                                        @if($inv->type_invoice == 1)
                                        {{ number_format((($inv->caselist->expense->where('is_active', 1)->sum('total') * $share / 100) + ($caselist->professional_service * $share / 100)) * 10 / 100, 2) }}
                                        @else
                                        {{ number_format((($fee_adj * $share / 100) + ($inv->caselist->expense->where('is_active', 2)->sum('total') * $share / 100)) * 10 / 100, 2) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom: 1px solid black;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <th width="150px">TOTAL AMOUNT DUE</th>
                                    <th width="270px"></th>
                                    <th width="50px">{{ $caselist->currency }}</th>
                                    <th width="100px" class="text-right">
                                        @if($inv->type_invoice == 1)
                                        {{ number_format(($inv->caselist->expense->where('is_active', 1)->sum('total') * $share / 100) + ($caselist->professional_service * $share / 100) + (($inv->caselist->expense->where('is_active', 1)->sum('total') * $share / 100) + ($caselist->professional_service * $share / 100)) * 10 / 100 - $discount , 2)  }}
                                        @else
                                        {{ number_format(((($fee_adj * $share / 100) + ($inv->caselist->expense->where('is_active', 2)->sum('total') * $share / 100)) * 10 / 100) + ($fee_adj * $share / 100) + ($inv->caselist->expense->where('is_active', 2)->sum('total') * $share / 100) - $discount, 2) }}
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" style="border-bottom: 2px double black;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div style="margin-top: 100px;">
            <div class="row">
                <div class="col" style="width: 90%;">
                    <table>
                        <tr>
                            <th><i>Terms </i> <i> : </i> </th>
                            <th>Invoice Payment Upon Receipt. NPWP : 01.310.501.0-018.000</th>
                            <th colspan="4">&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <th>Payments</th>
                            <td style="white-space: pre-line;">
                                Please pay within <strong>30 days after receiving the invoice</strong>
                                Kindly send copy of bank transfer to <strong>finance@axis-adjusters.com</strong>
                            </td>
                            <th colspan="4">&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="7">&nbsp;</th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th>PT AXIS INTERNATIONAL INDONESIA</th>
                            <th colspan="4">&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach($bank as $data)
                        <tr>
                            <th>&nbsp;</th>
                            <th>
                                <strong>{{ $data->bank_name }}</strong><br>
                                {{ $data->address }}
                            </th>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <th>
                                <table>
                                    <tr>
                                        <th width="100px">Swift Code</th>
                                        <th> : </th>
                                        <th>{{ $data->swift_code }}</th>
                                    </tr>
                                    @foreach($type->where('bank_name',$data->bank_name) as $row)
                                    <tr>
                                        <th>Account No. {{ $row->currency }}</th>
                                        <th> : </th>
                                        <th>{{ $row->no_account }}</th>
                                    </tr>
                                    @endforeach
                                </table>
                            </th>
                            <th colspan="3"></th>
                            <th><u>Febrizal</u><br> Director</th>
                            <th>&nbsp;</th>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div style="position: fixed; left: 0; bottom: 0; width: 100%; height:80px;">
            <table style="font-size: 8px;" width="100%">
                <tr>
                    <th width="400px"></th>
                    <th width="150px" style="border-left: 1px solid #1f67a7;">
                        <div style="margin-left: 5px;">
                            <b style="color: #1f67a7;">PT AXIS International Indonesia</b> <br>
                            Pakuwon Tower 12th floor, Unit I <br>
                            Jl. Casablanca Raya, Kav. 88, <br>
                            Jakarta 12870, Indonesia <br>
                        </div>
                    </th>
                    <th width="150px" style="border-left: 1px solid #1f67a7;">
                        <div style="margin-left: 5px;">
                            <i class="fab fa-tumblr" style="color: #1f67a7;"></i> + 62 21 2290 3759, 2290 3831 <br>
                            <i class="fab fa-tumblr" style="color: #1f67a7;"></i> + 62 62 21 2138 3924 <br>
                            <span style="color: #1f67a7;">e</span> claims@axis-adjusters.com <br>
                            <span style="color: #1f67a7;">w</span> www.axis-lossadjusters.com <br>
                        </div>
                    </th>
                </tr>
            </table>

            <!-- <table style="font-size: 8px;" width="100%">
                <tr>
                    <td><i class="fab fa-tumblr" style="color: #1f67a7; margin-right: 10px;"></i> +62 21 2290 3759</td>
                </tr>
                <tr>
                    <td><i class="fab fa-tumblr" style="color: #1f67a7; margin-right: 10px;"></i> +62 21 2290 3831</td>
                </tr>
                <tr>
                    <td><i class="fas fa-at" style="color: #1f67a7; margin-right: 10px;"></i> claims@axis-adjusters.com</td>
                </tr>
                <tr>
                    <td><i class="fab fa-chrome" style="color: #1f67a7; margin-right: 10px;"></i> www.axis-lossadjusters.com</td>
                </tr>
            </table> -->
        </div>
        <!-- <div class="row">
            <div class="col-md-6">
                <table style="font-size: 8px;">
                    <tr>
                        <th style="color: #1f67a7;">PT AXIS Internasional Indonesia</th>
                    </tr>
                    <tr>
                        <td>Pakuwon Tower 12 fl. Unit I</td>
                    </tr>
                    <tr>
                        <td>Jl. Casablanca Raya Kav 88</td>
                    </tr>
                    <tr>
                        <td>Jakarta Selatan 12870, Indonesia</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table style="font-size: 8px;" width="100%">
                    <tr>
                        <td><i class="fab fa-tumblr" style="color: #1f67a7; margin-right: 10px;"></i> +62 21 2290 3759</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-tumblr" style="color: #1f67a7; margin-right: 10px;"></i> +62 21 2290 3831</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-at" style="color: #1f67a7; margin-right: 10px;"></i> claims@axis-adjusters.com</td>
                    </tr>
                    <tr>
                        <td><i class="fab fa-chrome" style="color: #1f67a7; margin-right: 10px;"></i> www.axis-lossadjusters.com</td>
                    </tr>
                </table>
            </div>
        </div> -->
    </div>
</body>

</html>