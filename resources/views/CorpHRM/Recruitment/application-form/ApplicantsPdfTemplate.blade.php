<!DOCTYPE html>
<html>
<head>
<style>
@page {
  header: page-header;
  footer: page-footer;
}
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
<htmlpageheader name="page-header">
<br>
  <p style="text-align:center;">SHORTLISTED CANDIDATES </p>
</htmlpageheader>
<br><br>
<table>
  <tr>
    <th>Fullname</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Qualifications</th>
    <th>Grade</th>
  </tr>
  @foreach($data as $applicant)
  <tr>
    <td>{{$applicant->alias}} {{$applicant->name}}</td>
    <td>{{$applicant->email}}</td>
    <td>{{$applicant->phone}}</td>
    <td>{{$applicant->qualification}}</td>
    <td>@if(empty($applicant->grade)) 0 @endif @if(!empty($applicant->grade)) {{$applicant->grade}} @endif</td>
  </tr>
  @endforeach
</table>

</body>
</html>
