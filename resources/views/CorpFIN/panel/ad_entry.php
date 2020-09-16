<!DOCTYPE html>
<html>
<title>CORPFIN | Financial Entry</title>
@include('CorpFIN.includes.Head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('CorpFIN.includes.Header')
            <!-- Left side column. contains the logo and sidebar -->
  @if(Auth::user()->Corpfin_menutype == "Traditional")
            @include('CorpFIN.includes.Traditional_menu')
   @else
            @include('CorpFIN.includes.Diary_menu')
    @endif

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Transaction Entries
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Manage Transaction Entry</a></li>
                <li class="active">Register New Transaction Entry</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h4 class="box-title">Draggable Events</h4>
                        </div>
                        <div class="box-body">
                            <!-- the events -->
                            <div id="external-events">
                                <div class="external-event bg-green">Lunch</div>
                                <div class="external-event bg-yellow">Go home</div>
                                <div class="external-event bg-aqua">Do homework</div>
                                <div class="external-event bg-light-blue">Work on UI design</div>
                                <div class="external-event bg-red">Sleep tight</div>
                                <div class="checkbox">
                                    <label for="drop-remove">
                                        <input type="checkbox" id="drop-remove">
                                        remove after drop
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Event</h3>
                        </div>
                        <div class="box-body">
                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                    <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                </ul>
                            </div>
                            <!-- /btn-group -->
                            <div class="input-group">
                                <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                <div class="input-group-btn">
                                    <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add
                                    </button>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <!-- /input-group -->

                        </div>
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Transation Entry</h3>
                            </div>
                            <button class="btn btn-primary event-btn m-2" type="button">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span class="load-text">Loading...</span>
                            <span class="btn-text">Submit</span>
                        </button>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div style="text-align:center; padding:10px;">
                                <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addentry">Add
                                    new Entry
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="addentry" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span
                                                        class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Add Entry</h4>
                                        </div>
                                        <form method="post" action="">
                                            {{ csrf_field() }}
                                        <div class="modal-body">

                                                <input type="hidden" name="pp" id="pp" value="0">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="tt">Transaction Title</label>
                                                                <input type="text" class="form-control" name="TT"
                                                                       id="tt" placeholder="Transaction Title" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="tt">Transaction Partner</label>
                                                                <select class="form-control" name="partner" id="tp" required>
                                                                    <option value="">--Select Transaction Partner--</option>
                                                                    @foreach($clients as $client)
                                                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="tt">Transaction Date</label>
                                                                <div class="input-group date" data-provide="datepicker">
                                                                    <input type="text" class="form-control " name="date"
                                                                           id="tt" placeholder="Transaction Date" required>
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                                @if($errors->has('date'))
                                                                    <span>{{$errors->first('date')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                {{--<label for="TTC">Transaction Type Class</label>
                                                                <select class="form-control" id="TTC" name="TTC"
                                                                        data-live-search="true" required>
                                                                    <option selected disabled>--Select Transaction Category--</option>
                                                                @foreach(App\Account::all() as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    <!--  -->
                                                                @endforeach
                                                                </select>--}}
                                                                <label for="account_id">Select Account</label>
                                                                <select name="account_id[]" id="TTC" class="form-control">
                                                                    @foreach(App\Account::all() as $account)
                                                                        <option value="{{$account->id}}">{{$account->acct_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-12">
                                                           {{-- <label for="TTN">Transaction Type Name</label>
                                                            <select class="form-control" id="TTN" name="TTN"
                                                                    data-live-search="true" required>
                                                            </select>--}}
                                                            <label for="account_id">Select Sub Account</label>
                                                            <select name="subaccount_id[]" class="form-control">
                                                                @foreach(App\SubAccount::all() as $subaccount)
                                                                    <option value="{{$subaccount->id}}">{{$subaccount->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                   <div class="row vat_type" style="display:none;">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-12 " >
                                                            <label for="vat_type">Select Vat Type</label>
                                                            <select class="form-control" id="vat_type" name="vat_type">
                                                                <option value="Inclusive">Inclusive</option>
                                                                <option value="Exclusive">Exclusive</option>
                                                            </select>
                                                        </div>
                                                       
                                                    </div>
                                                </div>   
                                                 <div class="row product-box" style="">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-6 " >
                                                            <label for="product">Select Product</label>
                                                            <select class="form-control" id="product" name="product"
                                                                    data-live-search="true" >
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 " >
                                                            <label for="quantity_sold">Units sold</label>
                                                            <input type="text" name="quantity_sold" value="1" id="quantity_sold" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                              
                                                <div class="row service-box" style="">
                                                    <div class="col-md-12">
                                                        <div class="col-sm-12 " >
                                                            <label for="service">Select Service</label>
                                                            <select class="form-control" id="service" name="service"
                                                                    data-live-search="true" >
                                                            </select>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                       
                                                            <div class="col-md-6 amt" id="amt-box"  style="">
                                                                    <div class="form-group">
                                                                        <label>Amount</label>
                                                                        <input type="text" class="form-control money"
                                                                               id="amount"  name="product_amount"
                                                                              >
                                                                    </div>
                                                                </div>
                                                        
                                                                    <div class="col-sm-6 amt" id="gross-box"  style="">
                                                                        <div class="form-group">
                                                                            <label for="gross">Gross Amount</label>
                                                                            <input type="text" name="gross"
                                                                                   id="gross" class="form-control money"
                                                                                   readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 amt" id="markup-box"  style="">
                                                                        <div class="form-group">
                                                                            <label for="markup">Markup</label>
                                                                            <input type="text" name="markup"
                                                                                   id="markup" class="form-control"
                                                                                   readonly value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 amt" id="vat-box" style="">
                                                                        <label for="vat">VAT amount</label>
                                                                        <input type="text" class="form-control money"
                                                                               id="vat" value="0" name="vat"
                                                                               readonly>
                                                                    </div>
                                                                    <div class="col-sm-6 amt" id="net-box"  style="">
                                                                        <label for="net">Net Amount</label>
                                                                        <input type="text" class="form-control money"
                                                                               id="net" value="0" name="net"
                                                                               readonly>
                                                                    </div>

                                                               
                                                        

                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            
                                            <button type="submit" class="btn btn-primary">Add Entry</button>
                                            </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!--End Modal-->
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <!-- THE CALENDAR -->
                            @include('CorpFIN.includes.Calendar')
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">

                </div>
            </div>
            <!-- /.row -->

            <!--/.col (left) -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('includes.Footer')
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->

@include('includes.Includes')


<!-- Page specific script -->
<script>

    $(document).ready(function () {

        var zone = "05:30";  //Change this to your timezone

        $.ajax({
            url: '{{ url('corpfin/calendar_event_get/fetch')}}',
            type: 'GET', // Send post data
            // data: 'type=fetch',
            async: false,
            success: function (s) {
                json_events = s;
            }
        });


        var currentMousePos = {
            x: -1,
            y: -1
        };
        jQuery(document).on("mousemove", function (event) {
            currentMousePos.x = event.pageX;
            currentMousePos.y = event.pageY;
        });

        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events .external-event').each(function () {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
         -----------------------------------------------------------------*/

        $('#calendar').fullCalendar({
            events: JSON.parse(json_events),
            //events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
            utc: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true,
            slotDuration: '00:30:00',
            eventReceive: function (event) {
                var title = event.title;
                var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
                $.ajax({
                    url: '{{ url('corpfin/calendar_event')}}',
                    data: 'type=new&title=' + title + '&startdate=' + start + '&zone=' + zone,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        event.id = response.eventid;
                        $('#calendar').fullCalendar('updateEvent', event);
                        $('.external-event').remove();
                    },
                    error: function (e) {
                        console.log(e.responseText);

                    }
                });
                $('#calendar').fullCalendar('updateEvent', event);
                console.log(event);
            },
            eventDrop: function (event, delta, revertFunc) {
                var title = event.title;
                var start = event.start.format();
                var end = (event.end == null) ? start : event.end.format();
                $.ajax({
                    url: '{{ url('corpfin/calendar_event')}}',
                    data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status != 'success')
                            revertFunc();
                    },
                    error: function (e) {
                        revertFunc();
                        alert('Error processing your request: ' + e.responseText);
                    }
                });

            },
            eventClick: function (event, jsEvent, view) {
                console.log(event.id);
                var title = prompt('Event Title:', event.title, {buttons: {Ok: true, Cancel: false}});
                if (title) {
                    event.title = title;
                    console.log('type=changetitle&title=' + title + '&eventid=' + event.id);
                    $.ajax({
                        url: "{{ url('corpfin/calendar_event/changetitle')}}/" + title + "/" + event.id,
                        //data: 'type=changetitle&title='+title+'&eventid='+event.id,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response.status == 'success')
                                $('#calendar').fullCalendar('updateEvent', event);
                        },
                        error: function (e) {
                            alert('Error processing your request: ' + e.responseText);
                        }
                    });
                }
            },
            eventResize: function (event, delta, revertFunc) {
                console.log(event);
                var title = event.title;
                var end = event.end.format();
                var start = event.start.format();
                $.ajax({
                    url: '{{ url('corpfin/calendar_event')}}',
                    data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status != 'success')
                            revertFunc();
                    },
                    error: function (e) {
                        revertFunc();
                        alert('Error processing your request: ' + e.responseText);
                    }
                });
            },
            eventDragStop: function (event, jsEvent, ui, view) {
                if (isElemOverDiv()) {
                    var con = confirm('Are you sure to delete this event permanently?');
                    if (con == true) {
                        $.ajax({
                            url: '{{ url('corpfin/calendar_event')}}',
                            data: 'type=remove&eventid=' + event.id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                console.log(response);
                                if (response.status == 'success') {
                                    $('#calendar').fullCalendar('removeEvents');
                                    getFreshEvents();
                                }
                            },
                            error: function (e) {
                                alert('Error processing your request: ' + e.responseText);
                            }
                        });
                    }
                }
            }
        });

        function getFreshEvents() {
            $.ajax({
                url: '{{ url('corpfin/calendar_event')}}',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
        }


        function isElemOverDiv() {
            var trashEl = jQuery('#trash');

            var ofs = trashEl.offset();

            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);

            if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
                    currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                return true;
            }
            return false;
        }

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
            e.preventDefault();
            //Save color
            currColor = $(this).css("color");
            //Add color effect to button
            $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
            e.preventDefault();
            //Get value and make sure it is not null
            var val = $("#new-event").val();
            if (val.length == 0) {
                return;
            }

            //Create events
            var event = $("<div />");
            event.css({
                "background-color": currColor,
                "border-color": currColor,
                "color": "#fff"
            }).addClass("external-event");
            event.html(val);
            $('#external-events').prepend(event);

            //Add draggable funtionality
            ini_events(event);

            //Remove event from text input
            $("#new-event").val("");
        });
    });
</script>
</body>
</html>
