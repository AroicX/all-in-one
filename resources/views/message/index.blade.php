@extends('message.layout.master')


@section('title')

<title>My Messages - {{  Auth::User()->name }}</title>

@endsection


@section('css')
{{-- <script
src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'>
</script>
<script
src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'>
</script>
<script
src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'>
</script>
<meta charset='UTF-8'>
<meta name="robots" content="noindex">
<link rel="shortcut icon" type="image/x-icon"
href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
<link rel="mask-icon" type=""
href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg"
color="#111" />


<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script>
try {
    Typekit.load({
        async: true
    });
} catch (e) {}
</script> --}}

<link rel="stylesheet" href="{{ asset('assets/css/message.css') }}">

@endsection




@section('content')

<div id="frame">
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap">
                <img id="profile-img" src="{{ Auth::User()->pic }}" class="online" alt="" />
                <p>{{Auth::User()->name}}</p>
                <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                <div id="status-options">
                    <ul>
                        <li id="status-online" class="active"><span class="status-circle"></span>
                            <p>Online</p>
                        </li>
                        <li id="status-away"><span class="status-circle"></span>
                            <p>Away</p>
                        </li>
                        <li id="status-busy"><span class="status-circle"></span>
                            <p>Busy</p>
                        </li>
                        <li id="status-offline"><span class="status-circle"></span>
                            <p>Offline</p>
                        </li>
                    </ul>
                </div>
                <div id="expanded">
                    <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="mikeross" />
                    <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="ross81" />
                    <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
                    <input name="twitter" type="text" value="mike.ross" />
                </div>
            </div>
        </div>

        <div id="contacts">
            <ul>


                <style>
                    .pending {
                        width: 25px;
                        height: 25px;
                        position: absolute;
                        top: -10px;
                        left: -10px;
                        border-radius: 50%;
                        background: red;
                        color: #fff;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        font-size: 13px;
                    }
                </style>

                <br />
                <br />

                @foreach ($employees as $user)
                <li class="contact" id="{{ $user->id }}">
                    <div class="wrap">
                        {{-- @if($user->is_unread)
                        <p class="pending">{{$user->is_unread}}</p>
                        @endif --}}
                        {{-- <span class="contact-status busy"></span> --}}
                        <img src="{{ $user->pic }}" alt="" />
                        <div class="meta">
                            <p class="name">{{ $user->name}}</p>
                            <p class="preview"></p>
                        </div>
                    </div>
                </li>
                @endforeach


            </ul>
        </div>

    </div>

    <div class="content">
        <div class="card px-2 py-3 mx-4 my-5">
            <h2 class="mx-2 py-x py-5">Welcome {{ Auth::User()->name }}</h2>
        </div>

    </div>

</div>

@endsection


@section('js')
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
    var receiver_id = '';
    var my_id = '{{ Auth::User()->id }}';
    $(document).ready(() => {



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            }
        });




        Pusher.logToConsole = true;

        var pusher = new Pusher('5548615cf5212223f507', {
            cluster: 'eu',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            console.log(JSON.stringify(data));

            if (my_id == data.from) {

                // alert('sender');

            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {
                    // if receiver is not selected, add notification 

                    var pending = parseInt($('#' + data.from).find('.pending').html());

                    if (pending) {
                        $('#', data.from).find('.pending').html(pending + 1);

                    } else {
                        $('#' + data.from).append('<p class="pending">1</p>');
                    }

                }
            }

        });

        //end pusher




        $('.contact').click(function () {


            $('.contact').removeClass('active');
            $(this).addClass('active');

            receiver_id = $(this).attr('id');
            // alert(receiver_id);

            $.ajax({
                type: 'GET',
                url: "message/" + receiver_id,
                data: "",
                cache: false,
                success: function (data) {

                    $('.content').html(data);
                    scrollToBottomFunc();
                }
            })

        });

        $(document).on('keyup', '.wrap input', function (e) {
            var message = $(this).val();


            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val('');

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;


                $('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' +
                    message +
                    '</p></li>').appendTo($('.messages ul'));
                $('.message-input input').val(null);
                $('.contact.active .preview').html('<span>You: </span>' + message);
                $(".messages").animate({
                    scrollTop: $(document).height()
                }, "fast");

                $.ajax({
                    type: "POST",
                    url: "message",
                    data: datastr,
                    cache: false,
                    success: function (data) {

                        scrollToBottomFunc();
                    },
                    error: function (jqXHR, status, err) {

                    },
                    complete: function (data) {
                        scrollToBottomFunc();
                    }

                })


            }
        })




    })


    function scrollToBottomFunc() {
        $('.messages').animate({
            scrollTop: $('.messages').get(0).scrollHeight
        }, 50);
    }
</script>


@endsection