<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Enregistre une action sensible avec l'utilisateur courant et son adresse IP.
     */
    public static function log(string $action, ?string $table = null, ?int $elementId = null): void
    {
        self::logForUser(Auth::id(), $action, $table, $elementId);
    }

    public static function logForUser(?int $userId, string $action, ?string $table = null, ?int $elementId = null): void
    {
        AuditLog::create([
            'utilisateur_id' => $userId,
            'action' => $action,
            'table_modifiee' => $table,
            'element_id' => $elementId,
            'adresse_ip' => Request::ip(),
            'date_action' => now(),
        ]);
    }

    public static function logModel(string $action, Model $model): void
    {
        self::log($action, $model->getTable(), $model->getKey());
    }
}
