<?php

namespace App\Services;

use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;

class LogService
{
    public static function log($action, $description, $data = [], $userId = null)
    {
        // Fix: Properly handle null auth case
        $userId = $userId ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::id() : null);
        
        $logData = [
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data' => $data,
            'hash' => self::generateHash($action, $description, $userId),
        ];

        return UserLog::create($logData);
    }

    private static function generateHash($action, $description, $userId)
    {
        // Create a consistent hash based on the log data
        $hashData = $action . $description . ($userId ?? 'anonymous') . now()->timestamp;
        return hash('sha256', $hashData);
    }

    public static function verifyLogIntegrity(UserLog $log)
    {
        // For verification, we need to recreate the hash with the original timestamp
        $hashData = $log->action . $log->description . ($log->user_id ?? 'anonymous') . $log->created_at->timestamp;
        $expectedHash = hash('sha256', $hashData);
        return $expectedHash === $log->hash;
    }
}