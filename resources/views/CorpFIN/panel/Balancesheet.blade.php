<!DOCTYPE html>
<html>
 <title>CorpFin | Balance Sheet</title>
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
          <p class="assets">  Assets  </p>
        <p class="sub-asset">Current Assets</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Trade and Other Receivables</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id == 2 || $subaccount->account_id == 6 )
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
                          @if($ledger->account_id == 2 ||  $ledger->account_id == 6  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Trade and Other Receivables Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end trade and other receivables -->
         <!-- prepayments -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Prepayments</th>
                        <th>Total</th>
                       
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 5 )
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
                            @if($ledger->account_id == 5 )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Prepayments Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table> 
                <!-- end prepayments -->
                <!-- investments -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Investments</th>
                        <th>Total</th>
                       
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 4)
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
                            @if($ledger->account_id == 4  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Investments Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table> 
                  <!-- end investments  -->
                  <!-- inventory -->
                    
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Inventory</th>
                        <th>Total</th>
                        
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 3)
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
                            @if($ledger->account_id == 3  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>
                                <th>Inventory Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table>
                  <!-- end inventory  -->
                  <!-- cash and cash equivalents -->
                   <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Cash and Cash Equivalents</th>
                        <th>Total</th>
                        
                    </tr>
                  </thead>
                  <tbody>
                           <?php $grandtotal =0; ?>
                          @foreach($sub_accounts as $subaccount)
                            @if($subaccount->account_id == 1)
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
                            @if($ledger->account_id == 1  )
                                      <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                    @endif
                            @endforeach
                              <tr>

                                <th>Cash and Cash Equivalents Total</th>
                                <td>{{$grandtotal}}</td>
                              </tr>
                       
                  </tbody>
                </table>
                  <!-- end cash and cash equivalents  -->
                  <!--  --> 
                  <table>
                    <thead>
                      <tr>
                        <?php $Currentasset = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->subclass_id == 1)
                            <?php $Currentasset += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Current Assets</th>
                        <th>{{$Currentasset}}</th>
                      </tr>
                    </thead>
                  </table>
        </div>
        <!-- end current assets -->
        <!-- non current assets -->
        <div>
          <p class="assets">  Assets  </p>
        <p class="sub-asset">Non-Current Assets</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Property, Plant and Equipment</th>
                      <th>Total</th>
                     
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==8 )
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
                          @if($ledger->account_id == 8  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Property Plant and Equipment Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end property, plant and equipment -->
          <!-- Investments -->
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Investments</th>
                      
                      <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==4 )
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
                          @if($ledger->account_id == 4  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Investments Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end investments -->   
                <!-- deffered tax asset -->
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Deferred Tax Asset</th>
                      <th>Total</th>
                     </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==10 )
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
                          @if($ledger->account_id == 10  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Deferred Tax Asset Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end deferred tax assets --> 

              <!-- trade and other receivables  -->
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Trade and Other Receivables</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==7 )
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
                          @if($ledger->account_id == 7  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Trade and other Receivables Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end trade and other receivables  -->  
         <!-- other long-term assets  -->
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Other Long Term Assets</th>
                      <th>Total</th>
                     
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==11 )
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
                          @if($ledger->account_id == 11 )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Other Long Term Assets Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end investments -->       
                  <!--total non-current assets   --> 
                  <table>
                    <thead>
                      <tr>
                        <?php $non_Currentasset = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->subclass_id == 2)
                            <?php $non_Currentasset += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Non-Current Assets</th>
                        <th>{{$non_Currentasset}}</th>
                      </tr>
                    </thead>
                  </table>
                  <!-- total non-current assets -->
                     <table>
                    <thead>
                      <tr>
                        <?php $total_asset = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->class_id == 1)
                            <?php $total_asset += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Assets</th>
                        <th>{{$total_asset}}</th>
                      </tr>
                    </thead>
                  </table>
        </div>

        <!-- End Assets -->
        <!-- Liabilities -->
        <div>
          <p class="assets">  Liabilities  </p>
        <p class="sub-asset">Current Liabilities</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Trade and Other Payables</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==12 )
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
                          @if($ledger->account_id == 12  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Trade and Other Payables Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end trade and other payables  -->
         <!-- Loans and borrowings -->
                 <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Loans and Borrowings</th>
                      <th>Total</th>
                     
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==15 )
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
                          @if($ledger->account_id == 15  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Loans and Borrowings Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end loans and borrowings -->    
                  <!--total current liabilities   --> 
                  <table>
                    <thead>
                      <tr>
                        <?php $current_liabilities = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->subclass_id == 3)
                            <?php $current_liabilities += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Current Liabilities</th>
                        <th>{{$current_liabilities}}</th>
                      </tr>
                    </thead>
                  </table>

                  <!-- non current liabilities -->
                  <div>
          <p class="assets">  Liabilities  </p>
        <p class="sub-asset">Non-Current Liabilities</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Loans and Borrowings</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==20 )
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
                          @if($ledger->account_id == 20  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Loans and Borrowings Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
         <!--end loans and borrowings   -->
          <!-- trade and other payables -->
            <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Trade and other Payables</th>
                      <th>Total</th>
                      
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==18 )
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
                          @if($ledger->account_id == 18  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Trade and other Payables Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
              <!-- end trade and other payables -->
              <!-- Deferred tax liabilities -->
                <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Deferred Tax Liabilities</th>
                      <th>Total</th>
                     
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==19 )
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
                          @if($ledger->account_id == 19  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Deferred Tax Liabilities Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 
              <!-- end deferred tax liabilities -->
                  <!--total noncurrent liabilities   --> 
                  <table>
                    <thead>
                      <tr>
                        <?php $non_current_liabilities = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->subclass_id == 4)
                            <?php $non_current_liabilities += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Non-Current Liabilities</th>
                        <th>{{$non_current_liabilities}}</th>
                      </tr>
                    </thead>
                  </table>
               
              </div>
                  <!-- total  liabilities-->
                     <table>
                    <thead>
                      <tr>
                        <?php $total_liabilities = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->class_id == 2)
                            <?php $total_liabilities += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Liabilities</th>
                        <th>{{$total_liabilities}}</th>
                      </tr>
                    </thead>
                  </table>
        </div>
        <!-- equity -->
        <div>
          <p class="assets">  Equity  </p>
        <p class="sub-asset">Owner's Equity</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                      <th>Reserves</th>
                      <th>Total</th>
                     
                  </tr>
                </thead>
                <tbody>
                         <?php $grandtotal =0; ?>
                        @foreach($sub_accounts as $subaccount)
                          @if($subaccount->account_id ==27 )
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
                          @if($ledger->account_id == 27  )
                                    <?php $grandtotal += floatval($ledger->Dr + $ledger->Cr); ?>
                                  @endif
                          @endforeach
                            <tr>
                              <th>Reserves Total</th>
                              <td>{{$grandtotal}}</td>
                            </tr>
                     
                </tbody>
              </table> 

              </div>
                  <!-- total  owners equity-->
                     <table>
                    <thead>
                      <tr>
                        <?php $total_equity = 0 ?>
                        @foreach($ledgers as $ledger)
                          @if($ledger->class_id ==  3)
                            <?php $total_equity += floatval($ledger->Dr + $ledger->Cr) ?>
                          @endif
                        @endforeach
                        <th>Total Owner's equity</th>
                        <th>{{$total_equity}}</th>
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

