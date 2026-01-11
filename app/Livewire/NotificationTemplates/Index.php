<?php

namespace App\Livewire\NotificationTemplates;

use Livewire\{Component, WithPagination};
use App\Models\{NotificationTemplate};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        NotificationTemplate::where('id', $id)->delete();
    }

    public function duplicate(int $id): void
    {
        $template = NotificationTemplate::findOrFail($id);

        $newTemplate = $template->replicate();
        $newTemplate->identifier = $template->identifier . ' (Copy)';
        $newTemplate->save();

        session()->flash('message', 'Template duplicated successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.notification-templates.index', [
            'notificationTemplates' => NotificationTemplate::with('client')->paginate(15)
        ]);
    }
}
