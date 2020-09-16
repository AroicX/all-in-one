<!-- PDF Modal -->
<div id="pdf-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pdf Viewer</h4>
      </div>
      <div class="modal-body">
               <iframe class="pdf_iframe" src="" width="100%" height="500px"></iframe>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
    </div>

  </div>
</div>

<!--Image Modal -->
<div id="img-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Image Viewer</h4>
      </div>
      <div class="modal-body">
               <img class="img_view" style=" width:100%; height:auto;">
      </div>
      <div class="modal-footer">
<!--         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
    </div>

  </div>
</div>


  <!--upload scores Modal -->
  <div class="modal fade" id="modal-upload-scores" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Scores</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="{{ url('corphrm/rec_application/applications/upload_scores') }}" enctype='multipart/form-data'>
        {{csrf_field()}}
        <input type="hidden" name="rec_id" required="">
        <input type="hidden" name="Iprocess" required="">
        <input type="hidden" name="stage" required="">
          <div class="form-group">
            <label>Attach Excel File</label>
            <input type="file" name="report" class="form-control" required="">
          </div>

          <div class="form-group">
            <button type="submit" class="btn pull-right btn-primary btn-sm" style="border-radius: 0px;">Upload</button>
          </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

    <!--upload scores Modal -->
  <div class="modal fade" id="modal-upload-scores-manually" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manually score applicant</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="{{ url('corphrm/rec_application/applications/upload_scores_manually') }}" enctype='multipart/form-data'>
        {{csrf_field()}}
        <input type="hidden" name="id" required="">
        <input type="hidden" name="rec_id" required="">
        <input type="hidden" name="Iprocess" required="">
         <input type="hidden" name="stage" required="">
          <div class="form-group">
            <label>Enter Score</label>
            <input type="number" name="score" class="form-control" required="">
          </div>
          <div class="form-group">
            <button type="submit" class="btn pull-right btn-primary btn-sm" style="border-radius: 0px;">submit</button>
          </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

<!-- <script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script> -->
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    //$('#dialog').dialog(); 
    $('.view_pdf').click(function () {
        $('.pdf_iframe').attr('src', '');
        var src = $(this).attr('src');
        //alert(src);
        $('.pdf_iframe').attr('src', src);
        $('#pdf-modal').modal('show');
        return false;
    });
});

  $(document).ready(function () {
    //$('#dialog').dialog(); 
    $('.view_img').click(function () {
      //alert("kk");
        $('.img_view').attr('src', '');
        var src = $(this).attr('src');
        //alert(src);
        $('.img_view').attr('src', src);
        $('#img-modal').modal('show');
        return false;
    });
});

  $(document).ready(function () {

    $('.upload_applicant_scores').click(function () {

        var rec_id = $(this).attr('rec_id');
        var Iprocess = $(this).attr('Iprocess');
        var stage = $(this).attr('stage');

        $('[name="rec_id"]').val(rec_id);
        $('[name="Iprocess"]').val(Iprocess);
        $('[name="stage"]').val(stage);
        $('#modal-upload-scores').modal('show');
        return false;
    });


    $('.upload_applicant_scores_manually').click(function () {

        //var applicants_id = $([]).val();
        var checkcardes = document.getElementsByName('applicant_id[]');
        var count = $("input:checkcard:checked").length;
        var rec_id = $(this).attr('rec_id');
        var Iprocess = $(this).attr('Iprocess');
        var stage = $(this).attr('stage');
        if(count <= 0){
          alert('select applicants first!');
          return false;
        }
        var vals = "";
        for (var i=0, n=checkcardes.length;i<n;i++) 
        {
            if (checkcardes[i].checked) 
            {
                vals += ","+checkcardes[i].value;
            }
        }
        if (vals) vals = vals.substring(1);

        $('[name="id"]').val(vals);
        $('[name="rec_id"]').val(rec_id);
        $('[name="Iprocess"]').val(Iprocess);
        $('[name="stage"]').val(stage);
        $('#modal-upload-scores-manually').modal('show');
        return false;
  });

  $("#checkAll").click(function () {
     $('input:checkcard').not(this).prop('checked', this.checked);
 });
});
</script>