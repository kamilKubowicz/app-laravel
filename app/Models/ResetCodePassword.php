<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetCodePassword extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'email',
        'code',
        'created_at',
    ];

    public function isExpire(): bool
    {
        if ($this->created_at > now()->addHour()) {
            $this->delete();

            return true;
        }

        return false;
    }
}
