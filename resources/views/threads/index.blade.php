@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-10 offset-md-1">
                <h1 class="text-center my-5">Forum Threads</h1>
            </div>
        </div>
        <div class="row">
            @if (count($threads) === 0)
                <div class="col-12">
                    <h4 class="text-center my-5">There are no relevant results at this time.</h4>
                </div>
            @endif
            <div class="card-columns">
                @foreach ($threads as $thread)
                    <article class="card my-2">
                        <div class="card-header">
                            <h4 class="card-title">
                                <a href="{{ $thread->path() }}">
                                    @if ($thread->hasUpdatesFor(auth()->user()))
                                        <strong>{{ $thread->title }}</strong>
                                    @else
                                        {{ $thread->title }}
                                    @endif
                                </a>
                            </h4>
                            <small>
                                By <a href="/threads?by={{ $thread->owner->name }}">{{ $thread->owner->name }}</a>
                                &mdash;
                                <strong>
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                                    </a>
                                </strong>
                            </small>
                        </div>
                        <div class="card-block">
                            {{ $thread->body }}
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>

@endsection