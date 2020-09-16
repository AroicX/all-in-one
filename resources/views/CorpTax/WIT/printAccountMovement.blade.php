
<html>
<head>
    <title>WITHOLDING TAX MOVEMENT SCHEDULE</title>
    <style>
        table {
            border:solid #000 !important;
            border-width:1px 0 0 1px !important;
            align-content: center;
        }
        th, td {
            border:solid #000 !important;
            border-width:0 1px 1px 0 !important;
        }
    </style>
</head>
<body>
<div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Balance Brought forward</th>
            <th>WHT Payable for the period</th>
            <th>Payment</th>
            <th>Closing Balance</th>

        </tr>
        </thead>

        @if(!empty($movement))
            <tbody id="">
                <tr id="transaction-row">
                    <td>{{$movement->balance_bf ? $movement->balance_bf :''}}</td>
                    <td>{{$movement->payable_for_period ? $movement->payable_for_period :''}}</td>
                    <td>{{$movement->payment_for_period ? $movement->payment_for_period :''}}</td>
                    <td>{{$movement->closing_balance ? $movement->closing_balance :''}}</td>

                </tr>
            </tbody>

        @endif
    </table>
</div>
</body>
</html>
