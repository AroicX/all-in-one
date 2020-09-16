@extends('CorpTax.index')

@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                	<div class="box-header">
                	<h4>CIT</h4>
                	</div>
               

                <div class="box-body">
                	<form method="post" action="{{url('/dashboard/corp-tax/CIT/upload_file')}}" files="true" enctype="multipart/form-data">
                	<div class="text-center">
                		<input type="file" name="doc" class="form-control" >
                	</div>
                	<div class="text-center"><input type="submit" class="form-control" value="Upload"></div>
                	</form>
                </div>
            </div>
        </div>
    </section>
@stop