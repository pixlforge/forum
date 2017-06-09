@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-5">Profiles</h1>

                <div class="card my-5">
                    <div class="card-block">
                        <h2 class="card-title mt-2">{{ $profileUser->name }}</h2>
                        <small>created {{ $profileUser->created_at->diffForHumans() }}.</small>
                    </div>
                </div>

            </div>

            @foreach ($threads as $thread)

                <div class="col-4 d-flex align-items-stretch">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $thread->title }}</h5>
                            <small>created {{ $thread->created_at->diffForHumans() }}.</small>
                        </div>
                        <div class="card-block">
                            {{ $thread->body }}
                        </div>
                    </div>
                </div>

            @endforeach
            <div class="col-12 d-flex justify-content-center my-5">
                {{ $threads->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection