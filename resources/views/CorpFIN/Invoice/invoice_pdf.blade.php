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
  text-align: right;
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
  <div class="container">
<div id="printJS-invoice">
    <div class="row">
        <div class="col-xs-12">
                <h2 id="logo">CorpERM</h2>
    		<div class="invoice-title">
    			<h2>Invoice #{{$invoice->invoice_no}}</h2>
    		</div>
    		<hr>
    		<header class="clearfix">
            <div id="project" class="clearfix">
                
                <div >
                    <address>
                     <?php $client = App\CorpFinTranPartner::find($invoice->client_id); ?>
                    <strong>{{$client->name}}</strong><br>
                        {{$client->address}}<br>
                        <?php $country = App\Country::find($client->country_id);
                      $state = App\State::find($client->state_id);
                 ?>
              
                        {{$state->name}}, {{$country->name}}<br>

                    </address>
                </div>
            </div>
              <div id="company">
                  
                <?php $company = App\Company::find($invoice->company_id);
                 ?>
                <div class="col-xs-6 text-right">
                    <address>
                    <strong>{{$company->name}}</strong><br>
                        {{$company->address}}<br>
                        {{$company->state}}<br>
                        {{$company->country}}<br>
                    </address>
                </div>
              </div> 
    		</header>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
      					<strong>Payment Method:</strong><br>
    					{{$invoice->payment_method}}<br>
    					{{$client->email}}
    				</address>
    			</div>
                
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Invoice Date:</strong> {{date('F d, Y ', strtotime($invoice->invoice_date))}}<br>
                        <strong>Due Date:</strong> {{date('F d, Y', strtotime($invoice->due_date))}}<br>
                        <strong>Amount Due:</strong> {{number_format($invoice->total - $invoice->paid, 2)}}
                        <br>
    					<br><br>
    				</address>
    			</div>
          
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Invoice Summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
                                    <!-- <td class="text-center"><strong>Discount</strong></td> -->
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							 @foreach( Cart::instance($invoice->id)->content() as $item)
                                 
    							<tr>
    								<td>{{$item->name}}</td>
    								<td class="text-center">{{number_format($item->price, 2)}}</td>
    								<td class="text-center">{{$item->qty}}</td>
    								<td class="text-center">{{number_format($item->total, 2)}}</td>
    							</tr>
                                @endforeach
                                
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center">Subtotal</td>
    								<td class="thick-line text-right">
                                    {{Cart::instance($invoice->id)->subtotal}}
                                 </td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Discount</strong></td>
    								<td class="no-line text-right">{{number_format($invoice->subtotal - $invoice->total, 2)}}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">
                                    {{number_format($invoice->total)}}                        
                                    </td>
    							</tr>
                                                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Paid</strong></td>
                                    <td class="no-line text-right">
                                       {{number_format($invoice->paid, 2)}}                       
                                    </td>
                                </tr>
                                                                <tr>
                                    <td class="no-line"></td>
                                    <td class="no-line"></td>
                                    <td class="no-line text-center"><strong>Balance</strong></td>
                                    <td class="no-line text-right">
                                                    {{number_format($invoice->total - $invoice->paid, 2)}}                        
                                    </td>
                                </tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    </div>
