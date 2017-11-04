{{--Edit mode--}}
<div class="card" v-if="editing">
    <div class="card-header d-flex align-items-center">

        {{--Avatar--}}
        <div class="col-12 col-lg-3">
            <img src="{{ asset('storage/' . $thread->owner->avatar_path) }}" class="img-fluid rounded" alt="">
        </div>

        <div class="col-12 col-lg-9">

            {{--Thread title--}}
            <input type="text" class="form-control" v-model="form.title">

            <div class="d-flex justify-content-between">

                {{--Thread owner--}}
                <div>
                    <a href="{{ route('profile', $thread->owner) }}">{{ $thread->owner->name }}</a>
                </div>

            </div>
        </div>
    </div>

    <div class="card-block">
        <textarea name="body"
                  id="body"
                  rows="15"
                  class="form-control"
                  style="resize: none;"
                  v-model="form.body"></textarea>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <div class="btn-group">
            <button class="btn btn-warning btn-sm" @click="cancel">Cancel</button>
            <button class="btn btn-success btn-sm" @click="update">Update</button>
        </div>

        {{--Delete thread--}}
        <div>
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
</div>

{{--Read mode--}}
<div class="card" v-else>
    <div class="card-header d-flex align-items-center">

        {{--Avatar--}}
        <div class="col-12 col-lg-3">
            <img src="{{ asset('storage/' . $thread->owner->avatar_path) }}" class="img-fluid rounded" alt="">
        </div>

        <div class="col-12 col-lg-9">

            {{--Thread title--}}
            <h2 class="text-capitalize" v-text="title"></h2>

            <div class="d-flex justify-content-between">

                {{--Thread owner--}}
                <div>
                    <a href="{{ route('profile', $thread->owner) }}">{{ $thread->owner->name }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card-block" v-text="body">
        {{--{!! nl2br(e($thread->body)) !!}--}}
    </div>

    <div class="card-footer" v-if="authorize('owns', dataThread)">
        <button class="btn btn-primary btn-sm" @click="editing = true">Edit</button>
    </div>
</div>