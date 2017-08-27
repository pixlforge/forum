@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-10 offset-md-1">
                <h1 class="text-center my-5">Forum Threads</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                @if (count($threads) === 0)
                    <h4 class="text-center my-5">There are no relevant results at this time.</h4>
                @endif
                <div class="card-columns">
                    @include ('threads._list')
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $threads->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>

            {{--Trending Threads--}}
            @if (count($trendingThreads))
                <div class="col-12 col-md-4">
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4 class="text-center">Trending threads</h4>
                        </div>
                        <div class="card-block">
                            <div class="list-group">
                                @foreach ($trendingThreads as $trendingThread)
                                    <a href="{{ url($trendingThread->path) }}"
                                       class="list-group-item list-group-item-action">{{ $trendingThread->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection