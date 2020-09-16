@extends('CorpHRM.layout.master')

@section('content')
<link type="text/css" rel="stylesheet" href="{{asset('calendar/css/fullcalendar.css')}}">

	<section class="content">
		<div class="row">
            @if(isset($success))
                <div class="alert alert-success">Successfully added</div>
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

            <div class="col-md-12">

                <div class="card card-primary">
                	<div class="card-header with-border">
                		<h5>Leave Application</h5>
                	</div>

                	<div class="card-body">
                        <div id='calendar'></div>
                	</div>
                </div>
            </div>
        </div>
    </section>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>

<script src="{{asset('calendar/js/fullcalendar.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false,
        events: <?php echo $leave; ?>

    })

});
</script>
@stop

