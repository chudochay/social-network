<div class="media d-flex flex-column">
    <div class="media-body d-flex flex-row">
        <img src="{{asset('storage/'.$user->profile_picture_location)}}"
             alt="{{ $user->name }} {{ $user->surname }}"
             class="media-object mr-2 mb-2"
             width="200px" height="200px">
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
        </div>
    </div>
    <div class="nav-panel">
        @if(Auth::user()->id === $user->id)
            <a class="btn btn-outline-primary"
               href="{{ route('profile.edit', [
                                Auth::user()->id,
                                Auth::user()->username]) }}">
                Update profile
            </a>
            @csrf
        @endif
        <a class="btn btn-outline-info"
           href="{{ route('profile.show', [$user->id, $user->username]) }}">
            Timeline
        </a>
        <a class="btn btn-outline-info" href="{{
                route('friends.index', [$user->id, $user->username])
                }}">
            Friends
        </a>

        <a class="btn btn-outline-info" href="{{
                route('gallery.index', [$user->id, $user->username])
                }}">
            Photos
        </a>
    </div>

</div>
<hr>
