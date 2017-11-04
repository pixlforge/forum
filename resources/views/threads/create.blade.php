@extends('layouts.app')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <div class="card-header">
                        <h1 class="text-center">Create a New Thread</h1>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">Channel</label>
                                <select class="form-control" id="channel_id" name="channel_id" required>
                                    <option value="">Choose one...</option>
                                    <option disabled>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>

                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Thread title" value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Content</label>
                                <textarea class="form-control" id="body" name="body" rows="5" placeholder="Thread content" required>{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LcQMDcUAAAAAN3vXBbHDtOvzBPuuBDgnYTl1-xV"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if (count($errors))
                                <div class="form-group">
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
