<?php

namespace App;

use App\Core\Model;

class Lectures extends Model
{
    // Default table name = 'class name'
    protected static $table = "lectures";

    // Default primary key = 'id'
    protected static $primary_key = "id";
}
