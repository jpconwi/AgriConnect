<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProfile extends Model
{
    protected $fillable = ['user_id', 'company_name', 'business_permit_no', 'bio'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
