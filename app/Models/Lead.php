<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'displayName',
        'firstName',
        'middleName',
        'lastName',
        'homePhone',
        'workPhone',
        'email',
        'dateOfBirth',
        'energy',
        'gas',
        'water',
        'phone',
        'broadband',
        'paytv',
        'solar',
        'insurance',
        'storage',
        'removalist',
        'finance',
        'currentElectricityRetailer',
        'currentGasRetailer',
        'status',
        'salesType',
        'connectionDate',
        'type',
        'createdBy',
        'updatedBy',
        'assignedTo',
        'assignedBy',
        'accountType',
        'notes',
        'phyUnitnumber',
        'phyUnitType',
        'phyLotnumber',
        'phyStreetnumber',
        'phyStreetNumberSuffix',
        'phyStreetSuffix',
        'phyStreetname',
        'phyStreetType',
        'phySuburb',
        'phyState',
        'phyPostcode',
        'leadSource',
        'lifeSupport',
        'promocode',
        'crmNotify',
        'assigned_at',
        'hasConcession',
    ];


}
