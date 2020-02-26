@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                @include('profile.partials.profileblock')
                <form role="form" action="{{ route('gallery.create') }}" method="post">
                    @csrf
                    <div class="form-group{{ $errors->has('name') ? 'has-error': '' }}">
                        <input placeholder="Gallery name..."
                               name="name"
                               class="form-control">
                        @if ($errors->has('name'))
                            <span class="help-block alert-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-outline-success">Create Gallery</button>
                </form>
                <hr>

                @foreach($galleries as $gallery)
                   {{$gallery->name}}
                @endforeach
            </div>
        </div>
    </div>
@endsection
