<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    
    protected $fillable = [
        'roi_record_id',
        'file_path'
    ];

    public function roiRecord()
    {
        return $this->belongsTo(RoiRecord::class);
    }
}