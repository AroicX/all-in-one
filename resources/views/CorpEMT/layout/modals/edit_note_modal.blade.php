<div class="modal fade modal-default" id="edit-note" tabindex="-1" role="dialog" aria-labelledby="EditNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{url('corpemt/client/editnote')}}" class="form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Edit Note</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-12">Note</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="note" id="note-note"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-6">
                              <label class="col-sm-12">Deal (<small>Select if note relates to a deal</small>)</label>
                              <div class="col-sm-12">
                                  <select class="form-control" name="deal" id="note-deal">
                                    <option value="">SELECT</option>
                                    @if(!$deals->isEmpty())
                                        @foreach($deals as $deal)
                                            <option value="{{$deal->id}}">{{$deal->deal_name}}</option>
                                        @endforeach;
                                    @endif
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <input type="hidden" name="note_id" value="" id="note-note-id">
                <input type="hidden" name="unique_id" value="{{$details->unique_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </div>
        </form>
    </div>
</div>