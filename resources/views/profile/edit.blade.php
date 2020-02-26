@extends('layouts.app')
@section('content')
    <?php use Illuminate\Support\Facades\Auth; ?>
    <div class="d-flex flex-column align-items-center mt-0">
        <div class="">
            <h3 class="text-uppercase m-3">
                Update profile
            </h3>
        </div>
        {{--    Update profile form--}}
        <form action="{{ route('profile.update', [
        Auth::user()->id, Auth::user()->username
        ]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="">
                {{--            Profile Picture--}}
                <div class="form-group d-flex align-items-center  justify-content-between">
                    <img src="{{ Auth::user()->profile_picture_location }}"
                         width="150px"
                         height="auto"/>
                    <div class="d-flex flex-column">
                        <label for="profile_picture" class="control-label">
                            Select new profile picture:
                        </label>
                        <input type="file"
                               name="profile_picture"
                        >
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                {{--            Name--}}
                <div class="form-group{{ $errors->has('name') ? 'has-error': '' }}">
                    <label for="name" class="control-label">Name:</label>
                    <input type="text" value="{{ Auth::user()->name }}" name="name" class="form-control"
                           placeholder="Name">
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                {{--            Surname--}}
                <div class="form-group{{ $errors->has('surname') ? 'has-error': '' }}">
                    <label for="surname" class="control-label">Surname:</label>
                    <input type="text" value="{{ Auth::user()->surname }}" name="surname" class="form-control"
                           placeholder="Surname">
                    @if ($errors->has('surname'))
                        <span class="help-block">{{ $errors->first('surname') }}</span>
                    @endif
                </div>
                {{--            Email--}}
                <div class="form-group{{ $errors->has('email') ? 'has-error': '' }}">
                    <label for="email" class="control-label">Email:</label>
                    <input type="email" value="{{ Auth::user()->email }}" name="email" class="form-control"
                           placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                {{--            Phone number--}}
                <div class="form-group{{ $errors->has('phone_number') ? 'has-error': '' }}">
                    <label for="phone_number" class="control-label">Phone number:</label>
                    <input type="tel" value="{{ Auth::user()->phone_number }}" name="phone_number"
                           class="form-control">
                    @if ($errors->has('phone_number'))
                        <span class="help-block">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>
                {{--            Biography--}}
                <div class="form-group{{ $errors->has('biography') ? 'has-error': '' }}">
                    <label for="biography" class="control-label">Biography:</label>
                    <textarea
                        id="biography"
                        rows="4"
                        cols="50"
                        name="biography"
                        class="form-control"
                    >{{ Auth::user()->biography }}</textarea>
                    @if ($errors->has('biography'))
                        <span class="help-block">{{ $errors->first('biography') }}</span>
                    @endif
                </div>
                {{--            Birthday--}}
                <div class="form-group{{ $errors->has('birthday') ? 'has-error': '' }}">
                    <label for="birthday" class="control-label">Birthday:</label>
                    <input type="date" value="{{ Auth::user()->birthday }}" name="birthday" class="form-control">
                    @if ($errors->has('birthday'))
                        <span class="help-block">{{ $errors->first('birthday') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-center">
                <button class="btn btn-outline-success" type="submit" name="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
