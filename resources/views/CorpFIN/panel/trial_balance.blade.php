<!DOCTYPE html>
<html>
 <title>CorpFin | Trial Balance</title>
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
              <th>Account Number</th>
              <th>Account Name</th>
              <th>Debit</th>
              <th>Credit</th>
            </tr>
          </thead>

          <tbody>
            <?php $grand_total_dr = 0; ?>
            <?php $grand_total_cr = 0; ?>
            @foreach($sub_accounts as $account)
              <?php $total_debit = 0; ?>
              <?php $total_credit = 0; ?>
              @foreach($ledgers as $ledger)
                @if($ledger->account_no == $account->sub_account_no)
                  <?php $total_debit += floatval($ledger->Dr); ?>
                  <?php $total_credit += floatval($ledger->Cr); ?>
                @endif
              @endforeach
              @if($total_debit > 0 || $total_credit > 0)
                <tr>
                <td>{{$account->sub_account_no}}</td>
                <td>{{$account->name}}</td>
                <td>{{number_format($total_debit, 2)}}</td>
                <td>{{number_format($total_credit, 2)}}</td>
              </tr>
              @endif
              <?php $grand_total_dr += $total_debit; ?>
              <?php $grand_total_cr += $total_credit; ?>
            @endforeach
             <tr>
                <td></td>
                <td>TOTAL</td>
                <td>{{number_format($grand_total_dr, 2)}}</td>
                <td>{{number_format($grand_total_cr, 2)}}</td>
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

