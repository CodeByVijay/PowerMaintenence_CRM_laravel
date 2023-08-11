<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    use HasFactory;
    protected $fillable = [
      'lead_id',
      'callback_date',
      'notes',
      'user_id',
      'created_at',
      'updated_at',
  ];
}
