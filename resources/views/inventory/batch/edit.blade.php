<!doctype html>
<html>
<title>ManRetail | Batch</title>
@include('CorpFIN.includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('CorpFIN.includes.Header')
            <!-- Left side column. contains the logo and sidebar -->
    @if(Auth::user()->Corpfin_menutype == "Traditional")
        @include('CorpFIN.includes.Traditional_menu')
    @else
        @include('CorpFIN.includes.Diary_menu')
    @endif

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
      
        <br>
    @include('includes.status')
    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class = "col-sm-12">
                <section class="content" id="blockUI" style="background:#fff !important; margin-left:10px; margin-right:50px;">
                <h3>Edit Batch</h3>
            <!-- Small boxes (Stat box) -->
            <form  action="{{route('batch.update', $batch->id)}}" method="post">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        {{method_field('PATCH')}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Quantity ordered</label>
                                    <input type="text" name="quantity_ordered" class="form-control" placeholder="Enter quantity ordered"
                                         value="{{$batch->quantity_ordered}}"  required>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Total invoice costs</label>
                                    <input type="text" name="total_invoice_cost" class="form-control"
                                        value="{{$batch->total_invoice_cost}}"   placeholder="Total invoice costs" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Shipping costs</label>
                                    <input type="text" name="shipping" class="form-control"
                                        value="{{$batch->shipping}}"   placeholder="Shipping costs" required>
                                </div>
                            </div>
                             <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Clearing costs</label>
                                    <input type="text" name="clearing" class="form-control"
                                        value="{{$batch->clearing}}"   placeholder="Enter clearing costs" required>
                                </div>
                            </div>
                          
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Insurance</label>
                                    <input type="text" name="insurance" class="form-control" placeholder="Enter insurance costs"
                                        value="{{$batch->insurance}}"   required>
                                </div>
                                    </div>
                               <div class="col-sm-6">
                                 <div class="form-group">
                                    <label>Miscellaneous costs</label>
                                   <input type="text" name="other_costs" class="form-control" placeholder="Enter other costs"
                                        value="{{$batch->other_costs}}"   required>
                                </div>
                               </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" style="">
                                    <label>Commission</label>
                                    <input type="text" name="commission" class="form-control" placeholder="Enter margin threshold"
                                        value="{{$batch->commission}}"   required>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group" style="">
                                    <label>Cost of goods sold/unit</label>
                                    <input type="text" name="unit_cost_sold" class="form-control" placeholder="Enter per unit cost of goods sold"
                                        value="{{$batch->unit_cost_sold}}"   required>
                                </div>
                                
                            </div>
                            
                        </div>
                          <div class="row">
                           
                            <div class="col-sm-6">
                                <div class="form-group" style="">
                                    <label>Margin threshold</label>
                                    <input type="text" name="margin_threshold" class="form-control" placeholder="Enter margin threshold"
                                        value="{{$batch->margin_threshold}}"   required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
            </div>
        </div>
    </div>
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
    @include('includes.Sidebar')
</div>
<!-- ./wrapper -->
@include('includes.Includes')
<script src="{{asset('js/general/Setup.js')}}"></script>
</body>
</html>