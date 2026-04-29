<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'nativephp';

    protected $fillable = [
        'faculty_name',
        'category_id',
        'status',
        'remarks',
        'submission_date',
    ];

    protected $casts = [
        'submission_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}