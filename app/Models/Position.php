<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $table = 'positions';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Title',
        'Description',
        'CreationDateTime',
        'EditDateTime',
        'IsActive',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'PositionId', 'Id');
    }
}