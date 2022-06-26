<?php

namespace App\Models\Base\Mustahiq;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MustahiqEducation extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    const EXAM_BOARDS = [1 => 'Dhaka', 2 => 'Chattogram', 3 => 'Rajshahi', 4 => 'Joshore', 5 => 'Cumilla', 6 => 'Barishal', 7 => 'Sylhet', 8 => 'Dinajpur', 9 => 'Mymensing', 10 => 'Madrasha', 11 => 'BTEB', 12 => 'UGC', 13 => 'Others'];
    const EXAM_NAMES = [1 => 'SSC/Dakhil', 2 => 'Diploma', 3 => 'HSC/Alim', 4 => 'Degree', 5 => 'Honors/Bachelor', 6 => 'PGD', 7 => 'Masters/Kamil', 8 => 'M.Phil', 9 => 'PhD', 10 => 'Training'];

    protected $table = 'mustahiq_educations';

    protected $fillable = [
        'mustahiq_id',
        'mustahiq_name',
        'exam_name',
        'board_name',
        'institute_name',
        'department_name',
        'passing_year',
        'passing_year',
        'result',
        'certificate_number',
        'registration_number',
        'roll_number',
        'admission_score',
        'hall_name',
        'running_semester',
        'created_by',
        'updated_by',
    ];
}
