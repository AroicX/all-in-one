@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                		<h4> Effective Tax Rate</h4>
                	</div>

                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <th>Current Tax Expense</th>
                                <th>NGN</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Company Income tax</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Education tax</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Deferred tax expense</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Originating and reversing temporary difference</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Tax Expense(credit)</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Profit/Loss before Income Tax</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Tax calculated at the rate of 30%</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Effect of</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Education tax</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Permanent Differences</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Impact of loss absorbed in the 2nd year of commencement</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Total income tax expense (credit) in SOCI</th>
                                    <th></th>
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