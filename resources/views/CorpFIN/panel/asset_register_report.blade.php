<!DOCTYPE html>
<html>
 <title>CorpFin | Fixed Assets Reports</title>
 <style type="text/css">
      .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 120px;
  height: 120px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 20px 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap; 
  margin-right: 50px;       
}

table {
  width: 90%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  margin-top: 25px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
<htmlpageheader name="page-header">
  CorpERM
</htmlpageheader>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">



  <!-- Content Wrapper. Contains page content -->
  <div >
    
    <!-- Main content -->
    <section >
      <div >
        <div>
		<div >
<br>
<page size="A4">

 <header>
 
 <h3 class="header">
 {{$company_details->name}}
   </h3>
    
   <p class="sub-header">Trial Balance</p>
   <p class="date"> From: {{date('F d, Y', strtotime($start))}}  To: {{date('F d, Y', strtotime($end))}}</p>
 </header>
    <body>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Account</th>
              <th>Asset Class</th>
              <th>Asset Description</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Dep Rate(%)</th>
              <th>Useful Life (months)</th>
              <th>No. of months expired</th>
              <th>No of unexpired</th>
              <th> Dep Per Month </th>
              <th> Dep for the period </th>
              <th> Accum Depreciation </th>
              <th> Carrying Amount </th>
            </tr>
          </thead>

          <tbody>
            <?php $grand_total_dr = 0; ?>
            <?php $grand_total_cr = 0; ?>
            @foreach($asset_register as $register)
            <tr>
              <td>{{$register->account_no}}</td>
              <td>{{$register->asset_sub_account->name}}</td>
              <td>{{$register->description}}</td>
              <td>{{ date('d-m-Y', strtotime($register->date)) }}</td>
              <td>{{number_format($register->amount, 2)}}</td>
              <td>{{$register->asset_sub_account->dep_rate}}</td>
              <td>{{ $register->useful_life_month }}</td>
              <td>{{ $register->no_of_months_expired }}</td>
              <td>{{ $register->no_of_months_unexpired }}</td>
              <td>{{ $register->dep_per_month }}</td>
              <td>{{ $register->deps_for_period }}</td>
              <td>{{ $register->accum_dep }}</td>
              <td>-</td>
            </tr>
            @endforeach
            <tr>
              <td>Total Depreciation</td>
              <td colspan="6">{{$total}}</td>
            </tr>

            
          </tbody>
        </table>
    </body>
</page>
<br>
  </div>
  </div>
  </div>
    </section>
    <!-- /.content -->
  </div>
 
</div>
<htmlpagefooter name="page-footer">
  {PAGENO}
</htmlpagefooter>
</body>
</html>
