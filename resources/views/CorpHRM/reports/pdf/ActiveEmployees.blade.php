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
<p><b>As At: </b>{{date('F', mktime(0, 0, 0, $month, 10))}}, {{$year}}</p>
</div>
<table>
  <tr>
    <th>S/N</th>
    <th>Employee Code</th>
    <th>Employee Name</th>
    <th>Department</th>
    <th>Grade</th>
    <th>Branch</th>
    <th>Reporting Manager</th>
    <th>Date of Joining</th>

  </tr>

@foreach($result as $r)
  <tr>
    <td>{{$r['SN']}}</td>
    <td>{{$r['Employee_Code']}}</td>
    <td>{{$r['Employee_Name']}}</td>
    <td>{{$r['Department']}}</td>
    <td>{{$r['Grade']}}</td>
    <td>{{$r['Branch']}}</td>
    <td>{{$r['Reporting_Manager']}}</td>
    <td>{{$r['Date_of_Joining']}}</td>
  </tr>
@endforeach
</table>

</body>
</html>
