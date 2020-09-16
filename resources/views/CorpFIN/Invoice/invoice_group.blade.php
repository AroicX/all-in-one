@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Invoice | Invoice Groups</h5>
                <span class="d-block m-t-5">Invoice Groups</span>
                <a href="" class="btn btn-success float-right" data-toggle="modal" data-target="#myModal">Add Invoice Group</a>
            </div>
            <div class="card-body table-border-style">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Serial No.</th>
                      <th>Name</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $counter = 1; ?>
                    @foreach($invoice_groups as $invoice_grp)
                      <tr>
                      <td>{{$counter}}</td>  
                      <td>{{$invoice_grp->name}}</td>
                      <td><a href="#" class="btn btn-primary edit" onclick="editInvoiceGroup({{ $invoice_grp }})" id="{{$invoice_grp->id}}" name="{{$invoice_grp->name}}" data-toggle="modal" data-target="#myModal2"><i class="fa fa-edit"></i></a></td>
                      <td><a href="{{ url('corpfin/settings/delete/invoice_group', $invoice_grp->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                      </tr>
                      <?php $counter++ ;?>
                    @endforeach
                  </tbody>
                </table>    
                <div class="pager">
                  {{ $invoice_groups->links() }}
                </div>
                @if(empty($invoice_groups))
                <p style="text-align:center;">No Invoice groups Added.
                  <a href="{{url('corpfin/settings/invoice_groups')}}"> Add Invoice groups</a>
                </p>
                @endif        
              </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Invoice Group</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
             <form class="form-horizontal" action="{{url('')}}/corpfin/settings/invoice_group" method="post">
             {{csrf_field()}}
             <div id="entry_row">
                <div class="row">
                    <div class="col-md-12" >
                      <div class="form-group">
                        <label for="name">Name of Invoice Group</label>
                        <input type="text" name="name" class="form-control" required>
                        @if($errors->first('name'))
                          <span>{{$errors->first('name')}}</span>
                        @endif
                      </div>
                        
                    </div>
                   <input type="hidden" name="company_id" value="{{Auth::user()->company_id}}">
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="Submit" class="btn btn-success">Create</button>
         </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- edit invoice group modal -->
<div id="myModal2" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Invoice Group</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
             <form class="form-horizontal" id="edit_form" action="{{url('')}}/corpfin/settings/edit/invoice_group" method="post">
             {{csrf_field()}}
             <div id="entry_row">
                <div class="row">
                    <div class="col-md-12" >
                      <div class="form-group">
                        <label for="name">Name of Invoice Group</label>
                        <input type="text" name="editname" id = "edit_name" class="form-control" required>
                        @if($errors->first('editname'))
                          <span>{{$errors->first('editname')}}</span>
                        @endif
                      </div>
                      
                    </div>
                    <input type="hidden" name="id" id="invoice_grp_id">
                   <input type="hidden" name="company_id" value="{{Auth::user()->company_id}}">
                </div>
          
               
           </div>     
       
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="Submit" class="btn btn-success">Edit Invoice Group</button>
         </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

    const editInvoiceGroup = (data) => {
      var id = $(this).attr('id');
      var name = $(this).attr('name')
      console.log(data)
       $("#invoice_grp_id").val(data.id)
       $("#edit_name").val(data.name);
    }
 
</script>

@if($errors->first('name'))
  <script type="text/javascript">
    $("#myModal").modal();
  </script>
@endif

@if($errors->first('editname'))
  <script type="text/javascript">
    $("#myModal2").modal();
  </script>
@endif

@endsection
