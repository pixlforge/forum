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
                @include('threads._list')

                {{ $threads->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection