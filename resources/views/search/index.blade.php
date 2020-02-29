@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-center flex-column">
        <div>
        <h3>Results on Your search for "{{ Request::input('query') }}": </h3>

        @if (!$users->count())
            <p>No results found.</p>
        @else
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    @foreach($users as $user)
                        @include('user/partials/userblock')
                        <hr>
                    @endforeach
                </div>
            </div>
        @endif
        </div>
    </div>
@endsection
