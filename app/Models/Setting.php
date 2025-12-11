<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'valeur',
        'description',
    ];

    protected $casts = [
        'valeur' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get setting by type and user
     */
    public static function getByType($type, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return static::where('type', $type)->where('user_id', $userId)->first();
    }

    /**
     * Set setting value by type
     */
    public static function setByType($type, $valeur, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return static::updateOrCreate(
            ['type' => $type, 'user_id' => $userId],
            ['valeur' => $valeur]
        );
    }
}