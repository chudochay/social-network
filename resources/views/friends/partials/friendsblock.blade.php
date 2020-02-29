@if (Auth::user()->hasFriendRequestPending($user))
    <p>Waiting for {{ $user->name }} to accept your friend's request.</p>
    <hr>
@elseif (Auth::user()->hasFriendRequestReceived($user))
    <a href="{{ route('friend.edit', ['username' => $user->username]) }}"
       class="btn btn-primary">Accept friend request</a>
    <hr>
@elseif (Auth::user()->isFriendsWith($user))
    <p>You and {{ $user->name }} are friends.</p>
    <div class="col-lg-offset-3">
        <div class="d-flex">
            {{--                   Unfriend Function          --}}
            <form action="{{
                    route('friend.delete', ['username' => $user->username])
                    }}"
                  method="post">
                @csrf
                <input type="submit"
                       class="submit btn btn-outline-secondary"
                       value="Unfriend">
            </form>
            {{--                   Unfollow Function          --}}
            <form action="#"
                  method="post"
                  class="ml-1">
                @csrf
                <input type="submit"
                       class="submit btn btn-outline-secondary"
                       value="Unfollow">
            </form>
        </div>
    </div>
    <hr>
@elseif (Auth::user()->id !== $user->id)
    <a href="{{ route('friend.create', ['username' => $user->username]) }}"
       class="btn btn-primary">Add as friend</a>
    <hr>
@endif
