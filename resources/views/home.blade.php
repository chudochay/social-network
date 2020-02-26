@extends('layouts.app')
@section('content')
    <div class="container">
        @include('timeline.index')
    </div>
    <style>
        .list-inline{
            display: flex;
        }
        .list-inline li {
            margin-left: 0.5%;
        }
    </style>
@endsection
