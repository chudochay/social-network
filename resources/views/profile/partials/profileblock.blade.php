<div class="media d-flex flex-column">
    <img src="{{$user->profile_picture_location}}"
         alt="{{ $user->name }} {{ $user->surname }}"
         class="media-object">
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
        <div class="">
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
               href="{{ route('profile.index', [Auth::user()->id, Auth::user()->username]) }}">
                Timeline
            </a>
            <a class="btn btn-outline-info" href="{{ route('friend.index') }}">
                Friends
            </a>

            <a class="btn btn-outline-info" href="{{ route('gallery.index') }}">
                Gallery
            </a>
        </div>
    </div>
</div>
<hr>
