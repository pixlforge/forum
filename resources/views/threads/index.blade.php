@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading">Forum Threads</div>

                <div class="panel-body">
                    @foreach ($threads as $thread)
                        <article>

                            <div class="level">
                                
                                <h4>
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
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

                            <div class="body" style="padding-top: 25px;">
                                {{ $thread->body }}
                            </div>
                        </article>
                        
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection