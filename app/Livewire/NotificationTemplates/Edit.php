<?php

namespace App\Livewire\NotificationTemplates;

use App\Enums\{NotificationChannel, NotificationTemplateType};
use App\Models\{Client, NotificationTemplate};
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|string|min:3')]
    public string $identifier = '';

    #[Validate(new Enum(NotificationChannel::class))]
    public string $channel = '';

    #[Validate('required|string|min:10')]
    public string $subject = '';

    #[Validate('required|exists:clients,id')]
    public ?int $client_id = null;

    #[Validate('required|string|min:100')]
    public string $content = '';

    #[Validate('required|string|min:20')]
    public string $available_placeholders = '';

    public ?string $template_type = null;

    public NotificationTemplate $notificationTemplate;

    public function mount(NotificationTemplate $notificationTemplate): void
    {
        $this->notificationTemplate = $notificationTemplate;
        $this->identifier = $notificationTemplate->identifier;
        $this->channel = $notificationTemplate->channel->value;
        $this->subject = $notificationTemplate->subject;
        $this->client_id = $notificationTemplate->client_id;
        $this->content = $notificationTemplate->content;
        $this->available_placeholders = $notificationTemplate->available_placeholders;
        $this->template_type = $notificationTemplate->template_type?->value;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255', Rule::unique('notification_templates')->ignore($this->notificationTemplate->id)],
            'client_id' => ['required', 'exists:clients,id'],
            'template_type' => ['nullable', Rule::enum(NotificationTemplateType::class)],
            'subject' => ['nullable', 'string'],
            'channel' => ['required', 'string'],
            'content' => ['required', 'string'],
            'available_placeholders' => ['nullable', 'json'],
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->notificationTemplate->update($data);

        $this->redirectRoute('notification-templates.index');
    }

    public function render()
    {
        return view('livewire.notification-templates.edit', [
            'clients' => Client::all(),
            'templateTypes' => NotificationTemplateType::cases(),
        ]);
    }
}
