<?php

namespace App;

use App\Core\Model;

class Courses extends Model
{
    // Default table name = 'class name'
    protected static $table = "courses";

    // Default primary key = 'id'
    protected static $primary_key = "id";
}
