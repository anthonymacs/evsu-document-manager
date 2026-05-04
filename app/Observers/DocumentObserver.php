<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Document;

class DocumentObserver
{
    public function created(Document $document): void
    {
        AuditLog::create([
            'subject_type' => 'Document',
            'subject_id'   => $document->id,
            'action'       => 'created',
            'description'  => 'Logged submission for ' . $document->faculty_name,
            'changes'      => [
                'new' => $document->toArray(),
            ],
        ]);
    }

    public function updated(Document $document): void
    {
        $dirty = $document->getDirty();
        $old   = [];
        $new   = [];

        foreach ($dirty as $key => $newValue) {
            $old[$key] = $document->getOriginal($key);
            $new[$key] = $newValue;
        }

        // Build a human-readable description
        if (count($dirty) === 1 && isset($dirty['status'])) {
            $desc = 'Updated status to "' . ucfirst($new['status']) . '" for ' . $document->faculty_name;
        } else {
            $desc = 'Updated submission record for ' . $document->faculty_name;
        }

        AuditLog::create([
            'subject_type' => 'Document',
            'subject_id'   => $document->id,
            'action'       => 'updated',
            'description'  => $desc,
            'changes'      => ['old' => $old, 'new' => $new],
        ]);
    }

    public function deleted(Document $document): void
    {
        AuditLog::create([
            'subject_type' => 'Document',
            'subject_id'   => $document->id,
            'action'       => 'deleted',
            'description'  => 'Deleted submission for ' . $document->faculty_name,
            'changes'      => [
                'old' => $document->toArray(),
            ],
        ]);
    }
}