<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The following model represents a service category in the application. 
 * It defines the structure of the 'servicecategories' table and establishes relationships with other models.
 */
class ServiceCategory extends Model
{
    protected $table = 'servicecategories';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Title',
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
     * Defines a one-to-many relationship with the ServiceItem model.
     * Each service category can have multiple service items associated with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceItems(): HasMany
    {
        return $this->hasMany(ServiceItem::class, 'ServiceCategoryId', 'Id');
    }
}