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
                        <h5> Interview Process </h5>
                        @if(CorpHRMAccessRoles('add_iprocess'))
                            <a href="{{url('corphrm/interview_process/new')}}">
                            <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                            </a>
                        @endif
                       
                    </div>

                        <div class="card-body table-responsive  table-hover  no-padding" >
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>Process Name</th>
                                    <th>Job Title</th>
                                    <th>Date</th>
                                    <th>Time Frame</th>
                                    <th>Interviewers</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($interview_processes as $interview_process)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $interview_process['process_name'] }}</td>
                                    <td>{{ $interview_process['job_title'] }}</td>
                                    <td>{{ $interview_process['rec_date'] }}</td>
                                    <td>{{ $interview_process['from_time']}} - {{ $interview_process['to_time']}}</td>
                                    <td>
                                    @foreach($interview_process['interviewers'] as $a) 
                                    @foreach( $a as $b) 
                                    <?php print_r($b); ?>;
                                    @endforeach
                                    @endforeach
                                    </td>
                                    <td>
                                    @if(CorpHRMAccessRoles('edit_iprocess'))
                                    <a href="{{url('corphrm/interview_process/edit')}}/{{ $interview_process['id'] }}">
                                    <button type="button" title="Edit" 
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                    </a>
                                    @endif
                                    @if(CorpHRMAccessRoles('delete_iprocess'))
                                    <a href="{{url('corphrm/delete/interview_process')}}/{{ $interview_process['id'] }}">
                                            <button type="button" title="Delete" 
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                    </a>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @if(empty($interview_processes))
                            <td><p style="text-align:center;" >No  Process Yet.
                                </p></td>

                            @endif
                        </div>

                    </div>
            </div>
        </div>
    </section>
    @stop
