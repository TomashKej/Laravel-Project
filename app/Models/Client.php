<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The Client model represents a client in the system.
 */
class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'LastName',
        'FirstName',
        'DateOfBirth',
        'Email',
        'Phone',
        'Address',
        'City',
        'PostCode',
        'Notes',
        'IsActive',
        'CreationDateTime',
        'EditDateTime',
        'CreatedByUserId',
        'UpdatedByUserId',
        'DeletedByUserId',
        'DeletedDateTime',
    ];

    public function serviceOrders() : HasMany
    {
        return $this->hasMany(ServiceOrder::class, 'ClientId', 'Id');
    }
}
