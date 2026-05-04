<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        AuditLog::create([
            'subject_type' => 'Category',
            'subject_id'   => $category->id,
            'action'       => 'created',
            'description'  => 'Created category "' . $category->name . '"',
            'changes'      => [
                'new' => $category->toArray(),
            ],
        ]);
    }

    public function updated(Category $category): void
    {
        $dirty = $category->getDirty();
        $old   = [];
        $new   = [];

        foreach ($dirty as $key => $newValue) {
            $old[$key] = $category->getOriginal($key);
            $new[$key] = $newValue;
        }

        AuditLog::create([
            'subject_type' => 'Category',
            'subject_id'   => $category->id,
            'action'       => 'updated',
            'description'  => 'Updated category "' . $category->name . '"',
            'changes'      => ['old' => $old, 'new' => $new],
        ]);
    }

    public function deleted(Category $category): void
    {
        AuditLog::create([
            'subject_type' => 'Category',
            'subject_id'   => $category->id,
            'action'       => 'deleted',
            'description'  => 'Deleted category "' . $category->name . '"',
            'changes'      => [
                'old' => $category->toArray(),
            ],
        ]);
    }
}