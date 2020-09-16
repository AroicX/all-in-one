@extends('CorpTax.layout.master')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>CIT Computation</h5>

                    <!-- <a href="{{route('downloadTrialBalanceTemplate')}}" class="btn btn-info" id="">Download Trial
                        Balance Template</a>
                    <a class="btn btn-primary text-white" data-toggle="modal" data-target="#uploadTrialBalance">Upload Trial
                        Balance</a> -->
                </div>
                <div class="card-body">

                    @if(session('error'))
                    <div class="alert alert-error col-sm-4">

                        {{session('error')}}
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success col-sm-4">

                        {{session('success')}}
                    </div>
                    @endif



                    <form role="form">
                    <div class="row">
                    	<div class="col-md-3">
                    		<div class="custom-control custom-checkbox text-left mb-4 mt-2">
					            <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1" required="">
					            <label class="custom-control-label" for="customCheck1">Use CorpFin Data</label>
					        </div>
                    	</div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customCheck1">From:</label>
                                <input type="date" name="fromDate" class="form-control" id="fromDate" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="customCheck1">To:</label>
                                <input type="date" name="toDate" class="form-control" id="toDate" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="useCorpFinData()">Compute CIT</button>
                        </div>
                    </div>
                    <div class="row">
                    	<p class="assets">  CIT   </p>
        				<p class="sub-asset">Revenue</p>
                    	<table class="table table-striped">
			                <!-- <thead>
			                  <tr>
			                      <th>Revenue</th>
			                      <th>Total</th>
			                      
			                  </tr>
			                </thead> -->
			                <tbody>
			                	<tr>
			                            <th>Revenue</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="revenue-label">Revenue</td>
			                              
			                            <td >
			                            	<input type="text" id="revenue-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        
			                        <tr>
			                            <th>Direct Cost</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="dc-label">Direct cost</td>
			                              
			                            <td>
			                            	<input type="text" id="dc-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        <tr>
			                            <th>Gross</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="gp-label">Gross Profit</td>
			                              
			                            <td>
			                            	<input type="text" id="gp-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        <tr>
			                            <th>Operating Cost</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="opex-label">Opex</td>
			                              
			                            <td>
			                            	<input type="text" id="opex-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        <tr>
			                            <th>Depreciation</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="depr-label">Total Dep</td>
			                              
			                            <td>
			                            	<input type="text" id="depr-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        <tr>
			                            <th>Finance Cost</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="fc-label">Total</td>
			                              
			                            <td>
			                            	<input type="text" id="fc-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
			                        <tr>
			                            <th>Profit Before Tax (PBT)</th>
			                            
			                        </tr>
			                        <tr>
			                            <td id="dc-label">Total PBT</td>
			                              
			                            <td>
			                            	<input type="text" id="pbt-value" class="form-control" placeholder="0.00">
			                            </td>
			                        </tr>
                                    <tr>
                                        <th>Disallowed Costs</th>
                                        
                                    </tr>
                                    <tr>
                                        <!-- <td id="dc-label">Total PBT</td> --> 
                                        <td colspan="2">
                                            <div class="form-group col-sm-12">
                                                <label for="">Disallowed Items</label>
                                                <select class="form-control" name="measure" id="disallowed-field" onchange="loadDisallowedModal()">
                                                    <option value="" selected="" disabled="">Select disallowed expenses</option>
                                                    @foreach($excluded_expenses as $opex)
                                                    <option value="{{ $opex->sub_account_no }}">{{ $opex->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group col-sm-6">
                                                <label for="">Disallowed Items</label>
                                                <textarea id="disallowed-items" class="form-control"></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group col-sm-6">
                                                <label for="">Disallowed Expenses</label>
                                                <input type="text" id="disallowed-total" class="form-control" placeholder="0.00">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gain or Loss on Disposal of Assets</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Gain or Loss on Disposal of Assets</td>
                                          
                                        <td>
                                            <input type="text" id="gain-loss-disposal" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Accessable Profit</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Accessable Profit</td>
                                          
                                        <td>
                                            <input type="text" id="accessable-profit" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Capital Allowance Brought Forward</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Capital Allowance Brought Forward</td>
                                          
                                        <td>
                                            <input type="text" id="capital-allowance-bf" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Capital Allowance for the Period</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Capital Allowance for period</td>
                                          
                                        <td>
                                            <input type="text" id="capital-allowance" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Capital Allowance Utitlized</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Capital Allowance Utitlized</td>
                                          
                                        <td>
                                            <input type="text" id="capital-allowance-utilized" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Capital Allowance Carried Forward</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Capital Allowance Carried Forward</td>
                                          
                                        <td>
                                            <input type="text" id="capital-allowance-cf" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Taxable Profit</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Taxable Profit</td>
                                          
                                        <td>
                                            <input type="text" id="taxable-profit" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                                                <input type="checkbox" name="remember" class="custom-control-input" onchange="applyEdutax()" id="apply-edutax" required="">
                                                <label class="custom-control-label" for="apply-edutax">Apply Edutax</label>
                                            </div>
                                        </th>
                                        
                                    </tr>
                                    <tr id="edutax-box" style="display: none;">
                                        <td id="dc-label">
                                            Edutax
                                        </td>
                                          
                                        <td>
                                            <input type="text" id="edu-tax" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Minimum Tax</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Minimum Tax</td>
                                          
                                        <td>
                                            <input type="text" id="minimum-tax" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Company Income Tax</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Company Income Tax (CIT)</td>
                                          
                                        <td>
                                            <input type="text" id="cit" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Coperate Tax Liability</th>
                                        
                                    </tr>
                                    <tr>
                                        <td id="dc-label">Coperate Tax Liability (CTL)</td>
                                          
                                        <td>
                                            <input type="text" id="ctl" class="form-control" placeholder="0.00">
                                        </td>
                                    </tr>
                                    
			                     
			                </tbody>

			                       
			                     
			                </tbody>
			                </thead> 
			              </table> 
                    </div>
                    <button type="button" class="btn btn-primary mt-3" onclick="saveCIT()"> Save Computed Report</button>
                    </form>

                </div>
            </div>
        </div>


        <div class="box box-primary">
                <div class="modal fade" id="uploadTrialBalance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Upload Transactions</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{route('uploadTrialBalance')}}" method="post" id="T-balance-upload" enctype="multipart/form-data">
                            <div class="modal-body">


                                    <div class="form-group">
                                        <label for="">Upload Trial Balance(in excel)</label>
                                        <input type="file" name="trial_balance">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit"
                                        class="btn btn-success" id="">Upload</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="box box-primary">
                <div class="modal fade" id="disallowed-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Disallowed Entries</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped disallowed-mtable">
                                    <thead>
                                          <th>#</th>
                                          <th>Check</th>
                                          <th>Account</th>
                                          <th>Cr</th>
                                          <th>Dr</th>
                                    </thead>
                                    <tbody id="disallowed-mtbody">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>


@endsection