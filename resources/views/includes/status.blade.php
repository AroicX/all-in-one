@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('status') }} status-box" style="text-align:center; ">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('message') }}
    </div>
@endif


    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))

      <div class="alert alert-{{ $msg }} no-border">
      <center>
      {{ Session::get('alert-' . $msg) }} <!--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>-->
        </center>
      </div>
      @endif
    @endforeach
