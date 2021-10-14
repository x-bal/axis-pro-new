<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <h3 class="text-center">FINAL INVOICE</h3>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <th>Invoice Number</th>
                        <th>:</th>
                        <th>{{ $invoice->no_invoice }}</th>
                    </tr>
                    <tr>
                        <th>Our Reference</th>
                        <th>:</th>
                        <th>{{ $invoice->caselist->file_no }}</th>
                    </tr>
                </table>
            </div>
            <div style="margin-left: 50%;">
                <table>
                    <tr>
                        <th>Date</th>
                        <th>:</th>
                        <th>{{ $invoice->date_invoice }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div>
                <table cellpadding="10">
                    <tr>
                        <th>To</th>
                    </tr>
                </table>
            </div>
            <div style="margin-left :20%">
                <table cellpadding="10">
                    <tr>
                        <th>{{ $invoice->caselist->insured }}</th>
                    </tr>
                    <tr>
                        <td>{{ $invoice->caselist->risk_location }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <hr style="border : 1px solid black">
        <div class="row">
            <div>
                <table cellpadding="10">
                    <tr>
                        <th>Re</th>
                    </tr>
                </table>
            </div>
            <div style="margin-left :20%">
                <table cellpadding="1">
                    <tr>
                        <th>Client</th>
                        <th>:</th>
                        <th>{{ $invoice->caselist->insured }}</th>
                    </tr>
                    <tr>
                        <th>Conveyance</th>
                        <th>:</th>
                        <td>{{ $invoice->caselist->insurance->address }}</td>
                    </tr>
                    <tr>
                        <th>Date Of Loss</th>
                        <th>:</th>
                        <td>{{ $invoice->caselist->insurance->address }}</td>
                    </tr>
                    <tr>
                        <th>Insurer's Ref</th>
                        <th>:</th>
                        <td>{{ $invoice->caselist->insurance->address }}</td>
                    </tr>
                    <tr>
                        <th>Policy No</th>
                        <th>:</th>
                        <td>{{ $invoice->caselist->no_leader_policy }}</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th><u>Professional Services</u></th>
                        <tr>
                            <td>Adjuster Fee</td>
                            <td></td>
                        </tr>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>