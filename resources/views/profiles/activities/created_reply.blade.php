@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a>
    @endslot
    @slot('owner')
        <a href="{{ route('profile', $activity->subject->owner->name) }}">
            {{ $activity->subject->owner->name }}
        </a>
    @endslot
    @slot('action')
        <small>replied to this thread {{ $activity->subject->created_at->diffForHumans() }}.</small>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent