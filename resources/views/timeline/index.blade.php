<div class="row justify-content-center">
    <div class="col-lg-6">

        @if(Auth::user()->id === $user->id)
        <form role="form" action="{{ route('post.create') }}" method="post">
            @csrf
            <div class="form-group{{ $errors->has('name') ? 'has-error': '' }}">
                        <textarea placeholder="What's up {{ Auth::user()->name }}?"
                                  name="post"
                                  class="form-control"
                                  rows="2"></textarea>
                @if ($errors->has('post'))
                    <span class="help-block">{{ $errors->first('post') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-success">Add Post</button>
        </form>
        <hr>
        @endif
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">News Feed</div>

            <div class="card-body">
                @if(!$posts->count())
                    <p>Nothing to show, yet.</p>
                @else
                    @foreach($posts as $post)
                        <div class="media">
                            <a class="pull-left" href="{{ route('profile.index', [
                                        'id'=>$post->user->id,
                                        'username'=>$post->user->username
                                        ]) }}">
                                <img class="media-object"
                                     alt="{{ $post->user->name }}"
                                     src="{{ $post->user->profile_picture_location }}">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="{{ route('profile.index', [
                                        'id'=>$post->user->id,
                                        'username'=>$post->user->username
                                        ]) }}">
                                        {{ $post->user->name }} {{ $post->user->surname }}
                                    </a>
                                </h4>
                                <p>{{ $post->body }}</p>
                                <ul class="list-inline">
                                    <li>{{ $post->created_at->diffForHumans() }}.</li>
                                    <li>
                                        <a href="{{ route('post.like', [
                                                    'postId' => $post->id]) }}">
                                            Like
                                        </a>
                                    </li>
                                    <li>
                                        {{ $post->likes->count() }}
                                        {{ Str::plural('like', $post->likes->count()) }}
                                    </li>
                                </ul>

                                @foreach($post->replies as $reply)
                                    <div class="media">
                                        <a class="pull-left"
                                           href="{{ route('profile.index', [
                                                    'id'=>$reply->user->id,
                                                    'username'=>$reply->user->username
                                                    ]) }}">
                                            <img class="media-object"
                                                 alt="{{ $reply->user->name }}"
                                                 src="{{ $reply->user->profile_picture_location }}">
                                        </a>
                                        <div class="media-body">
                                            <h5 class="media-heading">
                                                <a href="{{ route('profile.index', [
                                                        'id'=>$reply->user->id,
                                                        'username'=>$reply->user->username
                                                        ]) }}">
                                                    {{ $reply->user->name }} {{ $reply->user->surname }}
                                                </a>
                                            </h5>
                                            <p>{{ $reply->body }}</p>
                                            <ul class="list-inline">
                                                <li>{{ $reply->created_at->diffForHumans() }}.</li>
                                                <li>
                                                    <a href="{{ route('post.like', [
                                                            'postId' => $reply->id
                                                            ]) }}">
                                                        Like
                                                    </a>
                                                </li>
                                                <li>
                                                    {{ $reply->likes->count() }}
                                                    {{ Str::plural('like', $reply->likes->count()) }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
{{--                                @if($authUserIsFriend || Auth::user()->id === $post->user->id)--}}
                                <form role="form" action="{{route('post.reply',
                                        ['postId' => $post->id])}}" method="post">
                                    @csrf
                                    <div
                                        class="form-group{{ $errors
                                                ->has("reply-{$post->id}") ? 'has-error': '' }}">
                                                <textarea name="reply-{{ $post->id }}"
                                                          class="form-control"
                                                          rows="2"
                                                          placeholder="Reply to this status"></textarea>
                                        @if ($errors->has("reply-{$post->id}"))
                                            <span class="help-block alert-danger">
                                                        {{ $errors->first("reply-{$post->id}") }}
                                                    </span>
                                        @endif
                                    </div>
                                    <input type="submit"
                                           value="Reply"
                                           class="btn btn-outline-dark btn-sm">
                                </form>
{{--                                @endif--}}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
