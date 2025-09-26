<?php

namespace App\Livewire\Buckets;

use App\Helpers\BucketAllocator;
use App\Models\{Bucket, Client};
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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $query = Bucket::when($this->selectedClient, function ($query, $value) {
            return $query->where('client_id', $value);
        });

        $buckets = $query->orderBy('client_id')
            ->orderBy('id')
            ->paginate(100);

        $buckets = BucketAllocator::allocate($buckets);

        return view('livewire.buckets.index', [
            'buckets' => $buckets,
            'clients' => Client::all(),
        ]);
    }
}
