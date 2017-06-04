<div class="panel panel-default">
    <div class="panel-heading">
        <a href="">
            {{ $reply->owner->name }}
        </a>
        <small>
            {{ $reply->created_at->format('d M Y') }} &mdash;
            {{ $reply->created_at->diffForHumans() }}
        </small>
    </div>

    <div class="panel-body">
       {{ $reply->body }}
    </div>
</div>