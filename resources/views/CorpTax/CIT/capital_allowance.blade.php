@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4> Capital Allowance Table</h4>
                	</div>

                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Asset</th>
                                    <th>Cost</th>
                                    <th>addition</th>
                                    <th>total</th>
                                    <th></th>
                                    <th>Investment Allowance</th>
                                    <th>Initial Allowance</th>
                                    <th>Annual Allowance</th>
                                    <th>Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $ca = 0 ?>
                                @foreach($assets as $asset)
                                <tr>
                                    <td>{{$asset->asset}}</td>
                                    <td>{{$asset->cost}}</td>
                                    <td></td>
                                    <td>{{$asset->cost}}</td>
                                    <td></td>
                                    <td>{{$asset->investment_allowance}}</td>
                                    <td>{{$asset->initial_allowance}}</td>
                                    <td>{{$asset->annual_allowance}}</td>
                                    <td>{{$asset->total}}</td>
                                </tr>
                                <?php $ca += $asset->total ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align:right"><b>Capital Allowance</b></td>
                                    <td>{{$ca}}</td>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                	
                </div>
                <div class="alert alert-success" style="display:none">New Asset added</div>
            </div>
        </div>
    </section>    

@stop

@section('script')
<script type="text/javascript">
$(document).ready(function(){

});
</script>
@stop
