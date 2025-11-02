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
        'file_path',
        'vendor_name',
        'description',
        'amount',
        'category',
        'receipt_date',
        'receipt_image'
    ];

    public function roiRecord()
    {
        return $this->belongsTo(RoiRecord::class);
    }

    public function getCategoryColor()
    {
        $colors = [
            'food' => 'success',
            'transport' => 'info',
            'utilities' => 'warning',
            'supplies' => 'primary',
            'other' => 'secondary'
        ];
        
        return $colors[$this->category] ?? 'secondary';
    }
}