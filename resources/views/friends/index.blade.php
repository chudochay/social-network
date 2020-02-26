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

                <h3>Your friends</h3>
                @if(!$friends->count())
                    <p>You have no friends.</p>
                @else
                    @foreach($friends as $user)
                        @include('user.partials.userblock')
                        <hr>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-4 col-lg-offset-3">
                <h4>Friend requests</h4>
                @if(!$requests->count())
                    <p>You have no friend requests.</p>
                @else
                    @foreach($requests as $user)
                        @include('user.partials.userblock')
                        <hr>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
