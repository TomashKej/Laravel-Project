<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Position',
        'Notes',
        'IsActive',
        'CreationDateTime',
        'EditDateTime',
        'CreatedByUserId',
        'UpdatedByUserId',
        'DeletedByUserId',
        'DeletedDateTime',
    ];

    public function serviceOrders(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceOrder::class,
            'employeeserviceorders',
            'EmployeeId',
            'ServiceOrderId',
            'Id',
            'Id'
        );
    }
}