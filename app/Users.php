<?php

namespace App;

use App\Core\Model;

class Users extends Model
{
    // Default table name = 'class name'
    protected static $table = "users";

    // Default primary key = 'id'
    protected static $primary_key = "id";
}
