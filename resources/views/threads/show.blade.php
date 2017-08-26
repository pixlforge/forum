@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/vendor/jquery.atwho.css') }}">
@endsection

@section('content')


    <ol class="breadcrumb bg-secondary">
        <div class="container">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/threads">All Threads</a></li>
            <li class="breadcrumb-item active">{{ $thread->title }}</li>
        </div>
    </ol>

    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h2>{{ $thread->title }}</h2>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile', $thread->owner) }}">{{ $thread->owner->name }}</a>
                                @can ('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="close close-red" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-block">
                            {!! nl2br(e($thread->body)) !!}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
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
                                , and currently has <strong><span v-text="repliesCount"></span></strong>
                                {{ str_plural('comment', $thread->replies_count) }}.
                            </p>

                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </thread-view>

@endsection
