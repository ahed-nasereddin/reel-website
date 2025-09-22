<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Spatial;

class Contact extends Model
{
    use Spatial;

    protected $spatial = ['coordinates'];
}
