<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogObserver
{
    protected array $excludedModels = [
        AuditLog::class,
        \App\Models\PageView::class,
    ];

    protected function shouldLog(Model $model): bool
    {
        foreach ($this->excludedModels as $excluded) {
            if ($model instanceof $excluded) {
                return false;
            }
        }
        return true;
    }

    protected function log(Model $model, string $action): void
    {
        if (!$this->shouldLog($model)) {
            return;
        }

        try {
            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => $action,
                'model_type' => class_basename($model),
                'record_id'  => $model->getKey(),
                'ip_address' => Request::ip(),
                'user_agent' => substr(Request::userAgent() ?? '', 0, 255),
                'changes'    => $this->getChanges($model, $action),
            ]);
        } catch (\Throwable $e) {
            // Fail silently — audit log should never break the app
        }
    }

    protected function getChanges(Model $model, string $action): array
    {
        if ($action === 'created') {
            return ['data' => $model->toArray()];
        }

        if ($action === 'updated') {
            return [
                'before' => $model->getOriginal(),
                'after'  => $model->getDirty(),
            ];
        }

        return [];
    }

    public function created(Model $model): void
    {
        $this->log($model, 'created');
    }

    public function updated(Model $model): void
    {
        $this->log($model, 'updated');
    }

    public function deleted(Model $model): void
    {
        $this->log($model, 'deleted');
    }

    public function restored(Model $model): void
    {
        $this->log($model, 'restored');
    }

    public function forceDeleted(Model $model): void
    {
        $this->log($model, 'force_deleted');
    }
}
