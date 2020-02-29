<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model
{
    /**
     * @var User
     */

    private $user;

    public function __construct(User $user)
    {
        $this->$user = $user;
    }


}
