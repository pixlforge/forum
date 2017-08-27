@foreach ($threads as $thread)
    <article class="card my-2">
        <div class="card-header">
            <h4 class="card-title">
                <a href="{{ $thread->path() }}">
                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                        <strong>{{ $thread->title }}</strong>
                    @else
                        {{ $thread->title }}
                    @endif
                </a>
            </h4>
            <small>
                By
                <a href="/threads?by={{ $thread->owner->name }}">
                    {{ $thread->owner->name }}
                </a>
                &mdash;
                <strong>
                    <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }}
                        {{ str_plural('comment', $thread->replies_count) }}
                    </a>
                </strong>
            </small>
        </div>

        <div class="card-block">
            {{ $thread->body }}
        </div>

        @if ($thread->visits()->count())
            <div class="card-footer text-center">
                <strong>{{ $thread->visits()->count() }}</strong>
                {{ str_plural('visit', $thread->visits()->count()) }}
            </div>
        @endif

    </article>
@endforeach
