@extends('CorpHRM.layout.master')

@section('content')
<section class="content">
    <div class="row">

        <div class="col-md-12">
            @if(isset($success))
            <div class="alert alert-success">* Successfully Added</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}.
            </div>
            @elseif(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}.
            </div>
            @endif
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>User Action Logs</h5>

                </div>


                <div class="card-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">

                        <tr>
                            <th>ID</th>
                            <th>Staff Name</th>
                            <th>Action</th>
                            <th>Date</th>

                        </tr>
                        <?php $sn = 1;?>
                        @foreach ($all_actions as $all_action)
                        <tr>
                            <td>{{$sn++}}</td>
                            <td>
                                {{ $all_action['staff_name'] }}
                            </td>
                            <td>
                                <code> {{ $all_action['action'] }} </code>
                            </td>
                            <td>
                                {{$all_action['date']}}
                            </td>
                        </tr>
                        @endforeach
                    </table>





                </div>
            </div>
        </div>
</section>


@stop