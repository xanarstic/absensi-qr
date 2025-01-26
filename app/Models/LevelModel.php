<?php

namespace App\Models;

use CodeIgniter\Model;

class LevelModel extends Model
{
    protected $table = 'levels';
    protected $primaryKey = 'id_level';
    protected $allowedFields = ['level_name'];
}
