<style type="text/css">
    .invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<!--   <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css"> -->
<div class="container">
<div id="printJS-invoice">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Quote #@foreach($quotes as $quote){{$quote->unique_id}} @endforeach</h2>
    		</div>
    		<hr>
    		<div class="row">
             @foreach($quotes as $quote)
    			<div class="col-xs-6">
    				<address>
    				<strong>{{$quote->client_name}}</strong><br>
    					{{$quote->vat}}<br>
    					{{$quote->tax_code}}<br>
<!--     					Apt. 4B<br>
    					Springfield, ST 54321 -->
    				</address>
    			</div>
                 @endforeach
                @foreach($company_details as $company_detail)
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>{{$company_detail->name}}</strong><br>
    					{{$company_detail->address}}<br>
    					{{$company_detail->state}}<br>
    					{{$company_detail->country}}<br>
    				</address>
    			</div>
                @endforeach
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
<!--     					<strong>Payment Method:</strong><br>
    					Visa ending **** 4242<br>
    					jsmith@email.com -->
    				</address>
    			</div>
                 @foreach($quotes as $quote) 
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Quote Date:</strong> {{$quote->date_created}}<br>
                        <strong>Expires:</strong> {{$quote->date_due}}<br>
                        <strong>Total:</strong>
                                    <?php $i=0; ?>
                                @foreach( $deliverables as $deliverable)
                                 @foreach( $deliverable as $d)
                                    <?php $i = $i+ $d->price * $d->quantity; ?>
                                  @endforeach
                                 @endforeach
                                 @foreach($currencyy as $currency) {{$currency->p_currency}} @endforeach<?= number_format($i); ?>
                        <br>
    					<br><br>
    				</address>
    			</div>
            @endforeach
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                @foreach( $deliverables as $deliverable)
                                 @foreach( $deliverable as $d)
    							<tr>
    								<td>{{$d->item}}</td>
    								<td class="text-center">{{$d->price}}</td>
    								<td class="text-center">{{$d->quantity}}</td>
    								<td class="text-right"><?= $d->price * $d->quantity; ?></td>
    							</tr>
                                @endforeach
                                 @endforeach
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">
                                    <?php $i=0; ?>
                                @foreach( $deliverables as $deliverable)
                                 @foreach( $deliverable as $d)
                                    <?php $i = $i+ $d->price * $d->quantity; ?>
                                  @endforeach
                                 @endforeach
                                 @foreach($currencyy as $currency) {{$currency->p_currency}} @endforeach<?= number_format($i); ?>
                                 </td>
    							</tr>
<!--     							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$15</td>
    							</tr> -->
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">
                                                    <?php $i=0; ?>
                                @foreach( $deliverables as $deliverable)
                                 @foreach( $deliverable as $d)
                                    <?php $i = $i+ $d->price * $d->quantity; ?>
                                  @endforeach
                                 @endforeach
                                 @foreach($currencyy as $currency) {{$currency->p_currency}} @endforeach<?= number_format($i); ?>                        
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
   <!--  <button class="btn btn-success pull-right" >Print Invoice</button> -->
<!--      <button class="btn btn-success pull-right" type="button" onclick="printJS({printable:'http://corperm.pro/corpfin/invoice/quotes/pdf/nKDIOSFqSs', type:'pdf', showModal:true})">
    Print Invoice
 </button> -->
</div>
<!-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script> -->
