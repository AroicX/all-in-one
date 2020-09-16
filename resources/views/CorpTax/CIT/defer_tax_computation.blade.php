@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4>Defer Tax Computation</h4>
                	</div>

                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <th></th>
                                <th>NGN</th>
                                <th>NGN</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Netbook value of QCE(per amounts) - (31/12/2015)</td>
                                    <td></td>
                                    <td>6,269,104</td>
                                </tr>
                                <tr>
                                    <td>Tax written down value at 31st Dec 2015 (2016 YOA)</td>
                                    <td>967,000</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Unrelieved Capital Allowance</td>
                                    <td>234,000</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1,201,000</td>
                                    <td>1,201,000</td>
                                </tr>
                                <tr>
                                    <td>Unused tax loss</td>
                                    <td></td>
                                    <td>56,000</td>
                                </tr>
                                <tr>
                                    <td>Temporary difference (deductible)</td>
                                    <td></td>
                                    <td>5,012,104</td>
                                </tr>
                                <tr>
                                    <td>Tax theorem at 30% as at 31st Dec. 2015</td>
                                    <td></td>
                                    <td>2,342,100</td>
                                </tr>
                                <tr>
                                    <td>Balance at the beginning</td>
                                    <td></td>
                                    <td>2,342,100</td>
                                </tr>
                                <tr>
                                    <td>Deferred Tax for the year</td>
                                    <td></td>
                                    <td>2,342,100</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                	
                </div>
                
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