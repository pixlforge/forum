<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
                        <button type="submit"
                                class="btn btn-transparent" {{ $reply->isFavorited() ? ' disabled' : '' }}><i
                                    class="fa fa-star fa-lg"></i></button>
                    </div>
                </form>

                <small>{{ $reply->favorites_count }}</small>

                @can ('update', $reply)
                    <button class="btn btn-transparent ml-2" @click="editing = true">
                        <i class="fa fa-pencil fa-lg"></i>
                    </button>

                    <button class="btn btn-transparent" @click="destroy">
                        <i class="fa fa-times fa-lg close-red"></i>
                    </button>
                @endcan

            </div>
        </div>

        <div class="card-block">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" rows="15" v-model="body"></textarea>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer" v-if="editing">
            <div class="form-group mt-3">
                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-default btn-sm" @click="editing = false">Cancel</button>
            </div>
        </div>
    </div>
</reply>