<div class="card my-4">
    <div class="card-header d-flex justify-content-between">
        <div class="d-flex flex-column">
            <a href="{{ route('profile', $reply->owner) }}">
                {{ $reply->owner->name }}
            </a>
            <small>
                {{ $reply->created_at->format('d M Y') }} &mdash;
                {{ $reply->created_at->diffForHumans() }}
            </small>
        </div>
        <div class="d-flex justify-content-center align-items-baseline">
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-transparent" {{ $reply->isFavorited() ? ' disabled' : '' }}><i class="fa fa-star fa-lg"></i> </button>
                </div>
            </form>
            <small>{{ $reply->favorites_count }}</small>
        </div>
    </div>

    <div class="card-block">
       {{ $reply->body }}
    </div>
</div>