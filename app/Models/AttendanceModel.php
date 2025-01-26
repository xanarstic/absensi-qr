<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id_attendance';
    protected $allowedFields = ['id_user', 'attendance_date', 'attendance_time', 'status'];
}
