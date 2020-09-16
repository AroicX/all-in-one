<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<div class="details">
<p><b>Company Name: </b>{{$company}}.</p>
<p><b>Branch: </b>{{$branch}}.</p>
<p><b>Month Covered: </b>{{date('F', mktime(0, 0, 0, $month, 10))}}</p>
<p><b>Year Covered: </b>{{$year}}</p>
</div>
<table>
  <tr>
    <th>S/N</th>
    <th>Transcation Code</th>
    <th>Employee Name</th>
    <th>Transaction Date</th>
    <th>Expense Name</th>
    <th>Amount</th>
    <th>Purpose</th>
    <th>Disubursment Date</th>
  </tr>

@foreach($result as $r)
  <tr>
    <td>{{$r['SN']}}</td>
    <td>{{$r['Transcation_Code']}}</td>
    <td>{{$r['Employee_Name']}}</td>
    <td>{{$r['Transaction_Date']}}</td>
    <td>{{$r['Expense_Name']}}</td>
    <td>{{$r['Amount']}}</td>
    <td>{{$r['Purpose']}}</td>
    <td>{{$r['Disubursment_Date']}}</td>
  </tr>
@endforeach
</table>

</body>
</html>
