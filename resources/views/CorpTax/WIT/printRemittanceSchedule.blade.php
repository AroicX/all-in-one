
<html>
<head>
   <title>WITHOLDING TAX REMITTANCE SCHEDULE</title>
    <style>
        table {
            border:solid #000 !important;
            border-width:1px 0 0 1px !important;
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
            <th>Name of Vendor</th>
            <th>Address of Vendor</th>
            <th>TIN of Vendor</th>
            <th>Nature of Activity</th>
            <th>Period of Transaction</th>
            <th>Transaction Type</th>
            <th>Invoice Amount</th>
            <th>WHT Rate</th>
            <th>Amount of WHT Deducted</th>
        </tr>
        </thead>

        @if(!empty($transactions))
            <tbody id="transactions">
            @foreach($transactions as $item)
                <tr id="transaction-row">
                    <td>{{$item->vendor_name ? $item->vendor_name :''}}</td>
                    <td>{{$item->vendor_address ? $item->vendor_address :''}}</td>
                    <td>{{$item->vendor_TIN ? $item->vendor_TIN :''}}</td>
                    <td>{{$item->nature_of_transaction ? $item->nature_of_transaction :''}}</td>
                    <td>{{$item->transaction_period ? $item->transaction_period :''}}</td>
                    <td>{{$item->transaction_type ? $item->transaction_type :''}}</td>
                    <td>{{$item->invoice_amount ? $item->invoice_amount :''}}</td>
                    <td>{{$item->WHT_rate ? $item->WHT_rate :''}}</td>
                    <td>{{$item->WHT_amount ? $item->WHT_amount :''}}</td>
                </tr>
            @endforeach
            </tbody>

        @endif
    </table>
</div>
</body>
</html>
