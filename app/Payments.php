<?php

namespace App;

use App\Core\Model;

class Payments extends Model
{
    // Default table name = 'class name'
    protected static $table = "payments";

    // Default primary key = 'id'
    protected static $primary_key = "id";
}
