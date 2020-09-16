@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
          <h5>Manage Transaction Entries</h5>
          <span class="d-block m-t-5">Entries</span>
          <a href="" class="btn btn-success float-right " data-toggle="modal" data-target="#myModal">Add New Entry</a>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
          <!-- Calendar -->
            <div class="box box-solid bg-green-gradient">
              <div class="box-header">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Calendar</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bars"></i></button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="#">Add new event</a></li>
                      <li><a href="#">Clear events</a></li>
                      <li class="divider"></li>
                      <li><a href="#">View calendar</a></li>
                    </ul>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-black">
                <div class="row">
                  <div class="col-sm-6">
                    
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.box -->
      </div>
      <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Transation Entry</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
        <div class="box-body table-responsive no-padding" id="entryTable">
                <table class="table table-hover">
            
                  <tr>
                    <th>ID</th>
            <th>Transaction Type</th>
            <th>Transaction Partner</th>
            <th>Transaction Contact</th>
            <th>Transaction Amount</th>
            <th>Remove</th>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Purchase Expense</td>
            <td>Dangote Industries Limited</td>
            <td>Mr. Aliko Dangote</td>
            <td>2,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                  </tr>
          <tr>
                    <td>2</td>
                    <td>Credit Note</td>
            <td>Conoil PLC</td>
            <td>Chief. Mike Adenuga</td>
            <td>4,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                  </tr>
          <tr>
                    <td>3</td>
                    <td>Debit Note</td>
            <td>Forte Oil PLC</td>
            <td>Mr. Femi Otedola</td>
            <td>7,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                  </tr>
          <tr>
                    <td>3</td>
                    <td>Purchase Expense</td>
            <td>Dangote Industries Limited</td>
            <td>Mr. Aliko Dangote</td>
            <td>2,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                  </tr>
          <tr>
                    <td>4</td>
                    <td>Credit Note</td>
            <td>Conoil PLC</td>
            <td>Chief. Mike Adenuga</td>
            <td>4,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button></td>
                  </tr>
          <tr>
                    <td>5</td>
                    <td>Debit Note</td>
            <td>Forte Oil PLC</td>
            <td>Mr. Femi Otedola</td>
            <td>7,000</td>
            <td><button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
                  </tr>
          
          </table>
              </div>
              <!-- /.box-body -->
              </div>
            

          </div>
          <!--/.col (left) -->
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    //$("#entryTable").load("entrytable.html")
    $("button").click(function(){
        $("p").slideToggle();
    });
});
</script>
@endsection