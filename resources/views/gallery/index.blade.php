@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                @include('profile.partials.profileblock')
                @if(Auth::user()->id === $user->id)
                    <div class="col-lg-6">
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
                    </div>
                    <hr>
                @else
                    <div class="col-lg-6">
                        <p class="h4">{{$user->name}}'s Galleries</p>
                    </div>
                    <hr>
                @endif
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-10 gallery">


                @if(!$galleries->count())
                    <p>Nothing to show, yet.</p>
                @else
                    @foreach($galleries as $gallery)
                        <a href="{{ route('gallery.show',[$gallery->id]) }}" class="gallery-item">
                            <div class="d-flex justify-content-center">
                            <p>{{$gallery->name}}</p>
                            <form action="{{ route('gallery.destroy', $gallery) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn destroy">&times;</button>
                            </form>
                            </div>
                            <div class="gallery-obj-count">
                                [Contains {{ App\Models\Image::all()
                                            ->where('gallery_id', $gallery->id)->count() }}
                                {{ Str::plural('object', App\Models\Image::all()
                                                        ->where('gallery_id', $gallery->id)->count()) }}]
                            </div>
                            <img
                                src="https://www.gravatar.com/avatar/14ef2624dbd75dcee39808d305d69525?d=identicon&s=200"
                                class="media-object">

                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
