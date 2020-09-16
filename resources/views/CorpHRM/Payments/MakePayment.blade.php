@extends('CorpHRM.includes.base')

@section('content')
	<section class="content">
		<div class="row">

            <div class="col-md-12">
                @if(isset($success))
                <div class="alert alert-success">* Successfully Added</div>
                @endif
                                @if(session('error'))
                        <div class = "alert alert-error">
                            {{ session('error') }}.
                        </div>
                    @elseif(session('success'))
                        <div class = "alert alert-success">
                            {{ session('success') }}.
                        </div>
                    @endif

                <div class="box box-primary">
                	<div class="box-header with-border">
                		<h3>Payments</h3>
                	</div>

                </div>
                
            </div>
        </div>
    </section>


@stop
