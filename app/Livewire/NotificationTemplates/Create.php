<?php

namespace App\Livewire\NotificationTemplates;

use App\Enums\{NotificationChannel, NotificationTemplateType};
use App\Models\{Client, NotificationTemplate};
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
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

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255', 'unique:notification_templates'],
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

        NotificationTemplate::create($data);

        $this->redirectRoute('notification-templates.index');
    }

    public function render()
    {
        return view('livewire.notification-templates.create', [
            'clients' => Client::all(),
            'templateTypes' => NotificationTemplateType::cases(),
        ]);
    }
}
