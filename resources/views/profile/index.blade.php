@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="media d-flex flex-column">
                    <img src="{{$user->profile_picture_location}}"
                         alt="{{ $user->name }} {{ $user->surname }}"
                         class="media-object">
                    <div class="media-body">
                        <h4 class="media-heading">
                            {{ $user->name }} {{ $user->surname }}
                        </h4>
                        @if($user->email)
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        @endif
                        @if($user->phone_number)
                            <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        @endif
                        @if($user->location)
                            <p><strong>Location:</strong> {{ $user->location }}</p>
                        @endif
                        @if($user->biography)
                            <p><strong>Biography:</strong> {{ $user->biography }}</p>
                        @endif
                        <div class="">
                        @if(Auth::user()->id === $user->id)
                            <a class="btn btn-outline-primary"
                               href="{{ route('profile.edit', [
                                Auth::user()->id,
                                Auth::user()->username]) }}">
                                Update profile
                            </a>
                            @csrf
                        @endif
                        <a class="btn btn-outline-info" href="{{ route('friend.index') }}">
                            Friends
                        </a>

                        <a class="btn btn-outline-info" href="#">
                            Gallery
                        </a>
                        </div>
                    </div>
                </div>

                <div class="">
                    @if (Auth::user()->hasFriendRequestPending($user))
                        <p>Waiting for {{ $user->name }} to accept your friend's request.</p>
                    @elseif (Auth::user()->hasFriendRequestReceived($user))
                        <a href="{{ route('friend.accept', ['username' => $user->username]) }}"
                           class="btn btn-primary">Accept friend request</a>
                    @elseif (Auth::user()->isFriendsWith($user))
                        <p>You and {{ $user->name }} are friends.</p>
                        <div class="col-lg-offset-3">
                            <div class="d-flex">
                                {{--                   Unfriend Function          --}}
                                <form action="{{ route('friend.delete', ['username' => $user->username]) }}"
                                      method="post">
                                    @csrf
                                    <input type="submit" class="submit btn btn-outline-secondary" value="Unfriend">
                                </form>
                                {{--                   Unfollow Function          --}}
                                <form action="#"
                                      method="post"
                                      class="ml-1">
                                    @csrf
                                    <input type="submit" class="submit btn btn-outline-secondary" value="Unfollow">
                                </form>
                            </div>
                        </div>
                    @elseif (Auth::user()->id !== $user->id)
                        <a href="{{ route('friend.add', ['username' => $user->username]) }}"
                           class="btn btn-primary">Add as friend</a>
                    @endif
                <hr>

                @if(!$posts->count())
                    <p>{{ $user->name }} hasn't posted anything, yet.</p>
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
                                                            'postId' => $post->id
                                                            ]) }}">
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
                                @if($authUserIsFriend || Auth::user()->id === $post->user->id)
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
                                @endif
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @endif

            </div>


                <h4>
                    @if(Auth::user()->id === $user->id)
                        Your
                    @else
                        {{ $user->name }}'s
                    @endif
                    friends:
                </h4>

                @if(!$user->friends()->count())
                    <p>{{ $user->name }} has no friends.</p>
                @else
                    @foreach($user->friends() as $user)
                        @include('user.partials.userblock')
                        <hr>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
