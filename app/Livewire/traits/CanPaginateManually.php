<?php

namespace App\Livewire\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait CanPaginateManually
{
    protected function paginate($collection, $perPage, $pageName)
    {
        return new LengthAwarePaginator(
            $collection->slice(
                ($this->getPage($pageName) - 1) * $perPage,
                $perPage
            ), 
            $collection->count(), 
            $perPage, 
            $this->getPage($pageName), 
            ['pageName' => $pageName]
        );
    }
}