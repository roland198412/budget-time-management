<?php

namespace App\Livewire\Buckets;

use App\Models\Bucket;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        Bucket::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.buckets.index', ['buckets' => Bucket::paginate(100)]);
    }
}
