@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li><a href="/threads">All Threads</a></li>
    <li class="active">{{ $thread->title }}</li>
</ol>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{ $thread->title }}</h2>
                    <a href="">{{ $thread->owner->name }}</a>
                </div>

                <div class="panel-body">
                   {{ $thread->body }}
                </div>
            </div>

            @foreach ($replies as $reply)
                @include ('threads.partials.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="body">Add a Comment</label>
                        <textarea class="form-control" id="body" name="body" rows="5" placeholder="Have something to say?" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            @else
                <p class="text-center">Please, <a href="{{ route('login') }}">log in</a> to participate in this discussion.</p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center">Meta Infos</h4>
                </div>
                <div class="panel-body">
                    <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="">{{ $thread->owner->name }}</a>
                        , and currently has <strong>{{ $thread->replies_count }}</strong>
                        {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
