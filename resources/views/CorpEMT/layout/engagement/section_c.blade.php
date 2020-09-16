<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#ec1"><i class="fa fa-info"></i> Engagement Economics</a>
                    </h4>
                </div>
                <div id="ec1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="pull-left">
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i> Add item to engagement Analysis</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add-expense"><i class="fa fa-code"></i> Add Expenses</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#add-discount"><i class="fa fa-flash"></i> Add Discount(%)</button>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                @if($analysis->isEmpty() && $expenses->isEmpty() && $discounts->isEmpty())
                                    <p>No item or expenses or discount added yet</p>
                                @else
                                    @if(!$analysis->isEmpty())
                                        <form method="post" action="{{url('corpemt/engagement/deleteitem')}}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                            <input type="hidden" name="client_id" value="{{$client_id}}">

                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>
                                                        <button type="submit" class="btn btn-xs btn-danger" title="Delete Selected Item"><i class="fa fa-trash"></i> Delete </button>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Designation</th>
                                                    <th>No. of Hours</th>
                                                    <th>Hourly Rate</th>
                                                    <th>Fees</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $sn = 0; $total = 0; $hours = 0;?>
                                                @foreach($analysis as $data)
                                                    <?php
                                                    $sn += 1;
                                                    $sum = $data->hours * $data->rate;
                                                    $total += $sum;
                                                    $hours += $data->hours;
                                                    ?>
                                                    <tr>
                                                        <td>{{$sn}}</td>
                                                        <td><input type="checkbox" name="item[]" value="{{$data->id}}"></td>
                                                        <td>{{$data->name}}</td>
                                                        <td>{{$data->designation}}</td>
                                                        <td>{{$data->hours}}</td>
                                                        <td>{{ number_format($data->rate) }}</td>
                                                        <td>{{ number_format($sum) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                    @endif

                                    @if(!$expenses->isEmpty())
                                        <form method="post" action="{{url('corpemt/engagement/deleteitem')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                        <input type="hidden" name="client_id" value="{{$client_id}}">

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><button type="submit" class="btn btn-xs btn-danger" title="Delete Selected Item"><i class="fa fa-trash"></i> Delete</button></th>
                                                <th>Expenses Name</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $sn = 0; ?>
                                            @foreach($expenses as $expense)
                                                <?php $total += $expense->amount; ?>
                                                <tr>
                                                    <td>{{ ++$sn }}</td>
                                                    <td><input type="checkbox" name="expsense[]" value="{{$expense->id}}"></td>
                                                    <td>{{ $expense->name }}</td>
                                                    <td>{{ $expense->description }}</td>
                                                    <td>{{ $expense->amount }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                    @endif

                                    <?php $total_discount = 0; ?>

                                    @if(!$discounts->isEmpty())
                                        <form method="post" action="{{url('corpemt/engagement/deleteitem')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="deal_id" value="{{$deal_id}}">
                                        <input type="hidden" name="client_id" value="{{$client_id}}">

                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><button type="submit" class="btn btn-xs btn-danger" title="Delete Selected Item"><i class="fa fa-trash"></i> Delete</button></th>
                                                <th>Discount Name</th>
                                                <th>Description</th>
                                                <th>Amount(%)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $sn = 0; ?>
                                                @foreach($discounts as $discount)
                                                    <?php
                                                        $total_discount += ($discount->amount/100) * $total;
                                                    ?>
                                                    <tr>
                                                        <td>{{ ++$sn }}</td>
                                                        <td><input type="checkbox" name="discount[]" value="{{$discount->id}}"></td>
                                                        <td>{{ $discount->name }}</td>
                                                        <td>{{ $discount->description }}</td>
                                                        <td>{{ $discount->amount }} %</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                    @endif

                                    <?php
                                        $total -= $total_discount;
                                        $vat = 0.05 * $total;
                                        $overall = $vat + $total;
                                        $realization = ($deal_amount/$overall) * 100;
                                    ?>

                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td>{{ number_format($total) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>VAT @ 5%</b></td>
                                            <td>{{ number_format($vat) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Final Fee</b></td>
                                            <td>{{ number_format($overall) }}</td>
                                        </tr>
                                    </table>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h4><b>Agreed Fee</b></h4>
                                            <p>{{ $deal_amount }}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4><b>Engagement Hours</b></h4>
                                            <p>{{$hours}}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4><b>Expected Realization</b></h4>
                                            <p>{{round($realization, 2)}} %</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
