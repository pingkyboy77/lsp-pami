<?php
namespace App\Observers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model)
    {
        $this->logActivity($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logActivity($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'deleted');
    }

    protected function logActivity(Model $model, string $action)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'description' => $this->generateDescription($model, $action),
            'changes' => $action === 'updated' ? $model->getChanges() : null,
        ]);
    }

    protected function generateDescription(Model $model, string $action): string
    {
        $modelName = class_basename($model);

        return match ($action) {
            'created' => "Menambahkan {$modelName} baru",
            'updated' => "Memperbarui {$modelName}",
            'deleted' => "Menghapus {$modelName}",
            default => "Melakukan aksi pada {$modelName}",
        };
    }
}
