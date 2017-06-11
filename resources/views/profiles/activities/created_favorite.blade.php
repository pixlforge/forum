@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $activity->subject->favorited->thread->title }}
        </a>
    @endslot
    @slot('owner')
        <a href="{{ route('profile', $activity->subject->favorited->owner->name) }}">
            {{ $activity->subject->favorited->owner->name }}
        </a>
    @endslot
    @slot('action')
        <small>favorited a reply {{ $activity->subject->created_at->diffForHumans() }}.</small>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent