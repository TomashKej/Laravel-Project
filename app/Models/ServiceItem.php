<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * The ServiceItem model represents a service item in the application.
 * It defines the structure of the 'serviceitems' table and establishes relationships with other models.
 */
class ServiceItem extends Model
{
    protected $table = 'serviceitems';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Title',
        'Description',
        'Price',
        'ServiceCategoryId',
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
     * Defines a many-to-one relationship with the ServiceCategory model.
     * Each service item belongs to a single service category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'ServiceCategoryId', 'Id');
    }

    /**
     * Defines a many-to-many relationship with the ServiceOrder model.
     * Each service item can be associated with multiple service orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviceOrders(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceOrder::class,
            'serviceorderserviceitems',
            'ServiceItemId',
            'ServiceOrderId',
            'Id',
            'Id'
        );
    }
}