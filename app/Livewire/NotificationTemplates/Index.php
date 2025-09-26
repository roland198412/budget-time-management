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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.notification-templates.index', ['notificationTemplates' => NotificationTemplate::paginate(15)]);
    }
}
