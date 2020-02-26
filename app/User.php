<?php

namespace App;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Friend;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'username',
        'email', 'password', 'phone_number',
        'biography', 'birthdate',  'profile_picture_location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function galleries() {
        return $this->hasMany(Gallery::class);
    }
//
//    public function comments() {
//        return $this->hasMany(Comment::class);
//    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function friendOfMine()
    {
        return $this->belongsToMany(
            User::class,
            'friends',
            'friend_id',
            'user_id'
        );
    }

    public function friendOf() {
        return $this->belongsToMany(
            User::class,
            'friends',
            'user_id',
            'friend_id'
        );
    }

    public function friends()
    {
        return $this
            ->friendOfMine()
            ->wherePivot('accepted', true)
            ->get()
            ->merge($this
                ->friendOf()
                ->wherePivot('accepted', true)
                ->get());
    }

    public function friendRequests()
    {
        return $this->friendOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user):bool
    {
        return $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()
            ->where('id', $user->id)
            ->first()->pivot
            ->update([
            'accepted'=>true,
        ]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id',$user->id)->count();
    }

    public function hasLikedPost(Post $post)
    {
        return (bool) $post->likes
            ->where('user_id', $this->id)
            ->count();
    }
//
//    public function followers() {
//        return $this->hasMany(Follower::class);
//    }
}
