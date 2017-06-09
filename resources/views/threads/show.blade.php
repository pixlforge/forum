@extends('layouts.app')

@section('content')


    <ol class="breadcrumb bg-secondary">
        <div class="container">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/threads">All Threads</a></li>
            <li class="breadcrumb-item active">{{ $thread->title }}</li>
        </div>
    </ol>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $thread->title }}</h2>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile', $thread->owner) }}">{{ $thread->owner->name }}</a>
                            <form action="{{ $thread->path() }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="close close-red" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-block">
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
                            <textarea class="form-control" id="body" name="body" rows="5"
                                      placeholder="Have something to say?" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-block">Submit</button>
                        </div>
                    </form>
                @else
                    <p class="text-center">Please, <a href="{{ route('login') }}">log in</a> to participate in this
                        discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Meta Infos</h4>
                    </div>
                    <div class="card-block">
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
