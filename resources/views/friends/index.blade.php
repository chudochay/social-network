@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                @include('profile.partials.profileblock')
                @include('friends.partials.friendsblock')

                @if(Auth::user()->id === $user->id)
                    <div class="col-lg-4">
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
                @endif
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
@endsection
