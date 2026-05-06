<?php
// app/Models/Matching.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matching extends Model
{
    use SoftDeletes;
    
    protected $table = 'matchings';
    
    protected $fillable = [
        'sidainfo_code',
        'dhis2_id',
        'nom_formation',
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Scope pour les codes actifs
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    // Recherche par code SIDAInfo
    public static function findBySidainfoCode($code)
    {
        return self::where('sidainfo_code', $code)
                    ->where('is_active', true)
                    ->first();
    }
}