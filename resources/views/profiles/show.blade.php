@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center my-5">Profiles</h1>

                <div class="card my-5">
                    <div class="card-block row">

                        <div class="col-6 col-lg-2">
                            <img src="{{ asset('storage/' . $profileUser->avatar_path) }}" class="img-fluid rounded mb-4" alt="Avatar">
                            @can('update', $profileUser)
                                <form method="POST" action="{{ route('avatar', $profileUser) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="file" name="avatar">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-sm btn-primary" type="submit">Upload Avatar</button>
                                    </div>
                                </form>
                            @endcan
                        </div>

                        <div class="col-6 col-lg-10">
                            <h2 class="card-title mt-2">{{ $profileUser->name }}</h2>
                            <small>created {{ $profileUser->created_at->diffForHumans() }}.</small>
                        </div>
                    </div>
                </div>

            </div>

            @forelse ($activities as $date => $activity)
                <div class="col-12 text-center my-5">
                    <h2>{{ $date }}</h2>
                </div>
                @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include ("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
            @empty
                <h4>There is no activity for this user yet.</h4>
            @endforelse
        </div>
    </div>

@endsection