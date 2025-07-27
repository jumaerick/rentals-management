<div class="msg right-msg">
    <div class="msg-img" style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

    <div class="msg-bubble">
        <div class="msg-info">
            <div class="msg-info-name">{{$comment->user->name}}</div>
            <div class="msg-info-time">{{$comment->created_at}}</div>
        </div>

        <div class="msg-text">
            {{$comment->message}}
        </div>
    </div>
</div>