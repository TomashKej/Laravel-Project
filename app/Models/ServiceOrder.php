<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * The ServiceOrder model represents a service order in the system. 
 * It defines the relationships with clients, employees, and service items, and specifies the table name, primary key, 
 * and fillable attributes for mass assignment.
 */
class ServiceOrder extends Model
{
    protected $table = 'serviceorders';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Title',
        'ClientId',
        'Status',
        'StartDateTime',
        'Deadline',
        'Description',
        'Notes',
        'IsActive',
        'CreationDateTime',
        'EditDateTime',
        'CreatedByUserId',
        'UpdatedByUserId',
        'DeletedByUserId',
        'DeletedDateTime',
    ];

    /**
     * Defines the relationship between a service order and its associated client.
     *
     * @return BelongsTo The relationship instance.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'ClientId', 'Id');
    }

    /**
     * Defines the relationship between a service order and its associated employees.
     *
     * @return BelongsToMany The relationship instance.
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(
            Employee::class,
            'employeeserviceorders',
            'ServiceOrderId',
            'EmployeeId',
            'Id',
            'Id'
        );
    }

    /**
     * Defines the relationship between a service order and its associated service items.
     *
     * @return BelongsToMany The relationship instance.
     */
    public function serviceItems(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceItem::class,
            'serviceorderserviceitems',
            'ServiceOrderId',
            'ServiceItemId',
            'Id',
            'Id'
        );
    }
}