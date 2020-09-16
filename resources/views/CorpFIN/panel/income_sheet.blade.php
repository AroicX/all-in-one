<!DOCTYPE html>
<html>
 <title>CorpFin | Income Statement Sheet</title>
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
  text-align: center;
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
    </style><htmlpageheader name="page-header">
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
    
   <p class="sub-header">{{ $title }}</p>
   <p class="date"> From: {{date('F d, Y', strtotime($start))}}  To: {{date('F d, Y', strtotime($end))}}</p>
 </header>

    <body>
        <div>
          <p class="assets">  Income   </p>
        <p class="sub-asset">Revenue</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Revenue</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                        @if($subaccount->account_id == 27)
                          <?php $total =0; ?>
                          @foreach($ledgers as $ledger)
                            @if($ledger->account_no == $subaccount->sub_account_no)
                              <?php $total += floatval($ledger->Dr + $ledger->Cr); ?>
                            @endif
                          @endforeach
                          @if($total > 0)
                          <tr>
                            <td>{{ $subaccount->name }}</td>
                              
                              <td>{{$total}}</td>
                          </tr>
                          @endif
                        @endif
                          
                        @endforeach
                        @foreach($ledgers as $ledger)
                          @if($ledger->account_id == 27  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Revenue Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end trade and other receivables -->
         <!-- prepayments -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Other Income</th>
                        <th>Total</th>
                       
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 28 )
                            <?php $total =0; ?>
                                 
                                  @foreach($ledgers as $ledger)
                                    @if($ledger->account_no == $subaccount->sub_account_no)
                                      <?php $total += floatval($ledger->Dr + $ledger->Cr); ?>

                                    @endif
                                    
                                  @endforeach
                                  @if($total > 0)
                                  <tr>
                                    <td>{{$subaccount->name}}</td>
                                      
                                      <td>{{$total}}</td>
                                  </tr>
                                  @endif
                              
                            @endif
                            
                          @endforeach
                          @foreach($ledgers as $ledger)
                            @if($ledger->account_id == 28 )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Other Income Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table> 
                <!-- end prepayments -->
                <!-- investments -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Finance Income</th>
                        <th>Total</th>
                       
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 29)
                            <?php $total =0; ?>
                                 
                                  @foreach($ledgers as $ledger)
                                    @if($ledger->account_no == $subaccount->sub_account_no)
                                      <?php $total += floatval($ledger->Dr + $ledger->Cr); ?>

                                    @endif
                                    
                                  @endforeach
                                  @if($total > 0)
                                    <tr>
                                      <td>{{$subaccount->name}}</td>
                                        
                                        <td>{{$total}}</td>
                                    </tr>
                                  @endif
                            @endif
                            
                          @endforeach
                          @foreach($ledgers as $ledger)
                            @if($ledger->account_id == 29  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Finance Income Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table> 
                  <!-- end investments  -->
                  
                  <!--  --> 
                  <table>
                    <thead>
                      <tr>
                        <?php $Currentasset = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->subclass_id == 4)
                            <?php $Currentasset += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Income</th>
                        <th>{{$Currentasset}}</th>
                      </tr>
                    </thead>
                  </table>
        </div>
        <!-- end current assets -->
        <!-- non current assets -->
        <div>
          <p class="assets">  Expenses  </p>
        
              <!-- inventory -->
                    
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Cost of sales</th>
                        <th>Total</th>
                        
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 30)
                            <?php $total =0; ?>
                                 
                                  @foreach($ledgers as $ledger)
                                    @if($ledger->account_no == $subaccount->sub_account_no)
                                      <?php $total += floatval($ledger->Dr + $ledger->Cr); ?>

                                    @endif
                                    
                                  @endforeach
                                  @if($total >0 )
                                    <tr>
                                      <td>{{$subaccount->name}}</td>
                                        
                                        <td>{{$total}}</td>
                                    </tr>
                                  @endif
                              
                            @endif
                            
                          @endforeach
                          @foreach($ledgers as $ledger)
                            @if($ledger->account_id == 30  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Cost of sales Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table>
                  <!-- end inventory  -->
                  <!-- cash and cash equivalents -->
                   <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Administrative Expenses</th>
                        <th>Total</th>
                        
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 31)
                            <?php $total =0; ?>
                                 
                                  @foreach($ledgers as $ledger)
                                    @if($ledger->account_no == $subaccount->sub_account_no)
                                      <?php $total += floatval($ledger->Dr + $ledger->Cr); ?>

                                    @endif
                                    
                                  @endforeach
                              @if($total > 0)
                              <tr>
                                <td>{{$subaccount->name}}</td>
                                  
                                  <td>{{$total}}</td>
                              </tr>
                              @endif
                            @endif
                            
                          @endforeach
                          @foreach($ledgers as $ledger)
                            @if($ledger->account_id == 31  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>

                                <th>Administrative Expenses Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table>
                  <!-- end cash and cash equivalents  -->
                  <!-- total non-current assets -->
                     <table>
                    <thead>
                      <tr>
                        <?php $total_asset = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->class_id == 5)
                            <?php $total_asset += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Expenses</th>
                        <th>{{$total_asset}}</th>
                      </tr>
                    </thead>
                  </table>
        </div>
        <!-- end equity -->
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

