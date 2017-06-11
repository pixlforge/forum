<div class="card my-4">
    <div id="reply-{{ $reply->id }}" class="card-header d-flex justify-content-between">
        <div class="d-flex flex-column">
            <a href="{{ route('profile', $reply->owner) }}">
                {{ $reply->owner->name }}
            </a>
            <small>
                {{ $reply->created_at->format('d M Y') }} &mdash;
                {{ $reply->created_at->diffForHumans() }}
            </small>
        </div>
        <div class="d-flex align-items-baseline">

            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-transparent" {{ $reply->isFavorited() ? ' disabled' : '' }}><i
                                class="fa fa-star fa-lg"></i></button>
                </div>
            </form>

            <small>{{ $reply->favorites_count }}</small>

            @can ('update', $reply)
                <button class="btn btn-transparent ml-2">
                    <i class="fa fa-pencil fa-lg"></i>
                </button>
                <form method="POST" action="/replies/{{ $reply->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="form-group">
                        <button type="submit" class="btn btn-transparent close-red" aria-label="Close">
                            <i class="fa fa-times fa-lg"></i>
                        </button>
                    </div>
                </form>
            @endcan

        </div>
    </div>

    <div class="card-block">
        {{ $reply->body }}
    </div>
</div>