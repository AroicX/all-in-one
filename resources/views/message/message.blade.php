
        <div class="contact-profile">
            <img src="{{ $user->pic }}" alt="" />
            <p>{{$user->name}}</p>

        </div>
        <div class="messages">
            <ul class="list-message">
                @foreach ($messages as $message)
                <li class="{{ ($message->from == Auth::id()) ? 'replies' : ' sent ' }}">
                        <img src="{{ ($message->from == Auth::id()) ? Auth::user()->pic : $user->pic }}" alt="" />
                <p>{{$message->message}}</p>
                    </li>
                @endforeach
               

            </ul>
        </div>
        <div class="message-input">
            <div class="wrap">
                <input class="form-control input-text" type="text" placeholder="Write your message..." />
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="submit btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
  