<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $fillable = [
    'first_name',
    'last_name',
    'roll_no',
    'college_mail_id',
    'stream',
    'joining_year',
    'is_alumuni',
    'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
