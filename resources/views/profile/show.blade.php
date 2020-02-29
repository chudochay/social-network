@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                @include('profile.partials.profileblock')
                @include('friends.partials.friendsblock')
                @include('timeline.index')
            </div>
        </div>
    </div>
@endsection
