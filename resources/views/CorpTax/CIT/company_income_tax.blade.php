@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4> Company Income Tax</h4>
                	</div>

                    <div class="box-body">
                        <h4>Final Corporate Tax Liability</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>CIT computed</td>
                                    <td>1890</td>
                                   
                                </tr>

                                 <tr>
                                    <td>Edu. Tax Computed</td>
                                    <td>2000</td>
                                   
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>3890</td>
                                   
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center"><h4>Final Corporate Tax Liability</h4></div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>CIT</td>
                                    <td>Edu Tax</td>
                                    <td>Total</td>
                                </tr>
                                <tr>
                                    <td>Balance at tde Beginning of tde year</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Tax change for tde year</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Payments during tde year</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
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