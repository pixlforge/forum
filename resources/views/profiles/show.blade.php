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