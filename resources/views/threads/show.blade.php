@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/vendor/jquery.atwho.css') }}">
@endsection

@section('content')


    <ol class="breadcrumb bg-secondary text-capitalize">
        <div class="container">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/threads">All Threads</a></li>
            <li class="breadcrumb-item active">{{ $thread->title }}</li>
        </div>
    </ol>

    <thread-view :data-thread="{{ $thread }}" inline-template>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-8">

                    {{--Original post--}}
                    @include ('threads.partials._original')

                    {{--Replies--}}
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

                            {{--Subscribe--}}
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"
                                              v-if="signedIn"></subscribe-button>

                            {{--Lock--}}
                            <button class="btn btn-danger"
                               v-if="authorize('isAdmin')"
                               @click="toggleLock">
                                <span v-if="! locked">
                                    <i class="fa fa-lock mr-2"></i>
                                    Lock
                                </span>
                                <span v-else>
                                    <i class="fa fa-unlock mr-2"></i>
                                    Unlock
                                </span>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </thread-view>

@endsection
