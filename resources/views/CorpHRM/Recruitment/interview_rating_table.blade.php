@extends('CorpHRM.layout.master')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3>
                        Interview Rating
                        @if(CorpHRMAccessRoles('add_irating'))
                        <a href="{{url('corphrm/interview_rating/new')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                        @endif
                        </h3>
                    </div>

                        <div class="card-body table-responsive table-bordered table-hover table-striped no-padding" id="BlockUI">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Process Name</th>
                                    <th>Minimum Rate</th>
                                    <th>Maximum Rate</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($interview_ratings as $interview_rating)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $interview_rating['interview_process'] }}</td>
                                    <td>{{ $interview_rating['minimum_rate']}}</td>
                                    <td>{{ $interview_rating['maximum_rate'] }}</td>
                                    <td>
                                    @if(CorpHRMAccessRoles('edit_irating'))
                                    <a href="{{url('corphrm/interview_rating/edit')}}/{{ $interview_rating['id'] }}">
                                    <button type="button" title="Edit" 
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                    </a>
                                    @endif
                                    @if(CorpHRMAccessRoles('delete_irating'))
                                    <a href="{{url('corphrm/delete/interview_rating')}}/{{ $interview_rating['id'] }}">
                                            <button type="button" title="Delete" 
                                                class="btn btn-sm btn-danger">
                                                <i class="fa fa-remove "></i>
                                            </button>
                                    </a>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(empty($interview_ratings))
                            <td><p style="text-align:center;" >No  Ratings Yet.
                                </p></td>

                            @endif
                        </div>

                    </div>
            </div>
        </div>
    </section>
    @stop
