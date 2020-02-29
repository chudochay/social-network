@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                @include('profile.partials.profileblock')
                @if(Auth::user()->id === $user->id)
                    <div class="col-lg-6">
                        <form role="form"
                              action="{{ route('gallery.store', $gallery) }}"
                              method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('file') ? 'has-error': '' }}">
                                <input type="file" name="file">
                                @if ($errors->has('file'))
                                    <span class="help-block alert-danger">
                                    {{ $errors->first('file') }}
                                </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-outline-success">Add Files</button>
                        </form>
                    </div>
                    <hr>
                @endif
                <div class="gallery-name-block d-flex flex-row">
                    <div class="gallery-name">Gallery "{{$gallery->name}}"</div>
                    <div class="gallery-obj-count">
                        [Contains {{ $images->count() }} {{ Str::plural('object', $images->count()) }}]
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-10 d-flex flex-wrap justify-content-left">
                @if(!$images->count())
                    <p>Nothing to show, yet.</p>
                @else
                    @foreach($images as $image)
                        <div class="image-block">
                            <form action="{{ route('image.destroy', [$image->gallery_id, $image]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn destroy">&times;</button>
                            </form>
                            <!-- Link to open the modal -->
                            <div class="remove-btn table-bordered image"
                                 onclick="passToModal('{{asset('storage/'.$image->image_path)}}')">
                                <img
                                    src="{{ asset('storage/'.$image->thumbnail_path) }}"
                                    alt="Thumbnail"/>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    </div>
    @if($images->count())
    @include('modal.index')
    @endif
@endsection

{{--    <button type="button" class="btn btn-secondary">Like</button>--}}
