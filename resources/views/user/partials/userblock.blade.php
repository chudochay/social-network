<div class="media">
    <a href="{{ route('profile.show', [
                        'id'=>$user->id, 'username' => $user->username
                ]) }}"
       class="pull-left">
        <img src="{{asset('storage/'.$user->profile_picture_location)}}"
             alt="{{ $user->name }} {{ $user->surname }}"
             class="media-object" width="40px">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="{{ route('profile.show', ['id'=>$user->id, 'username' => $user->username]) }}">
                {{ $user->name }} {{ $user->surname }}
            </a>
        </h4>
        @if($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
