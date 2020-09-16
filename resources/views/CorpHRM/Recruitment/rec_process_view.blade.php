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
                        Recruitment Processes 
                        @if(CorpHRMAccessRoles('add_rprocess'))
                        <a href="{{url('corphrm/rec_process/new')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Add New</button>
                        </a>
                        @endif
                        </h3>
                    </div>

                        <div class="card-body table-responsive table-bordered table-hover table-striped no-padding" id="BlockUI">
                            <table class="table table-hover">

                                <tr>
                                    <th>ID</th>
                                    <th>process name</th>
                                    <th>Description</th>
                                    <th>Processes</th>
                                    <th>Action</th>
                                </tr>
                                <?php $sn = 0; ?>
                                @foreach ($rec_processes as $rec_process)
                                <?php $sn += 1;?>
                                <tr>
                                    <td>{{$sn}}</td>
                                    <td>{{ $rec_process->process_name }}</td>
                                    <td>{{ $rec_process->process_description }}</td>
                                    <td>{{$rec_process->interview_processes}}</td>
                                    <td>
                                    @if(CorpHRMAccessRoles('edit_rprocess'))
                                    <a href="{{ url('corphrm/rec_process/edit') }}/{{ $rec_process->id }}">
                                    <button type="button" title="Edit" 
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-check "></i>
                                    </button>
                                    </a>
                                    @endif
                                    @if(CorpHRMAccessRoles('delete_rprocess'))
                                     <a href="{{url('corphrm/delete/rec_process')}}/{{ $rec_process->id }}">
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
                            @if(empty($rec_processes))
                            <td><p style="text-align:center;" >No Recruitment Application.
                                </p></td>

                            @endif
                        </div>

                    </div>
            </div>
        </div>
    </section>

    @stop