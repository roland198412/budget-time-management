<?php

namespace App\Livewire\Buckets;

use App\Models\Bucket;
use App\Models\Client;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public ?int $client = null;
    private ?int $selectedClient = null;

    public function updatedClient($value): void
    {
        if (empty($value)) {
            $this->selectedClient = null;
        } else {
            $this->selectedClient = $value;
        }
    }

    public function delete(int $id): void
    {
        Bucket::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.buckets.index', [
            'buckets' => Bucket::when($this->selectedClient, function ($query, $value) {
                return $query->where('client_id', $value);
            })->paginate(100),
            'clients' => Client::get()
        ]);
    }
}
