<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $table = 'swiftsc_users';
}
