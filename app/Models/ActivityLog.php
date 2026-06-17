<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'details',
        'ip_address',
    ];

    /**
     * Get the user who performed this action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create an activity log entry helper.
     *
     * @param string $action
     * @param string|null $details
     * @return ActivityLog
     */
    public static function log(string $action, ?string $details = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'details' => $details,
            'ip_address' => request()->ip(),
        ]);
    }
}
