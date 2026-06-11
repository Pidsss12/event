<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TopupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'proof_image',
        'status',
    ];
    /**
    * Get the user that owns the top‑up request.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
?>
