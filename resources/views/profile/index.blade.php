@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @include('profile.partials.profileblock')

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

                    @include('timeline.index')
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
