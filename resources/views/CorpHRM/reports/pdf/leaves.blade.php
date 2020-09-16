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
<p><b>Leave Type: </b>{{$leave_type}}</p>
</div>
<table>
  <tr>
    <th>S/N</th>
    <th>Employee Code</th>
    <th>Employee Name</th>
    <th>Leave Days</th>
    <th>Days Used</th>
    <th>Days Remaining</th>

  </tr>

@foreach($result as $r)
  <tr>
    <td>{{$r['SN']}}</td>
    <td>{{$r['Employee_Code']}}</td>
    <td>{{$r['Employee_Name']}}</td>
    <td>{{$r['Leave_Days']}}</td>
    <td>{{$r['Days_Used']}}</td>
    <td>{{$r['Days_Remaining']}}</td>
  </tr>
@endforeach
</table>

</body>
</html>
