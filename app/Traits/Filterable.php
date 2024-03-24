<?php
// app/Traits/Filterable.php

namespace App\Traits;

trait Filterable
{
    public function scopeFilter($query, $filters = [])
    {
        $defaultFilters = [
            'name_bangla' => null,
            'type' => null,
            'status' => null,
            'id' => 0,
            'per_page' => 10,
        ];

        $filters = array_merge($defaultFilters, $filters);

        foreach ($filters as $key => $value) {
            if (method_exists($this, $filterMethod = 'filterBy' . ucfirst($key))) {
                $this->{$filterMethod}($query, $value);
            }
        }

        if ($filters['id']) {
            $query->orderBy('id', 'desc');
        }

        if ($filters['per_page']) {
            return $query->paginate($filters['per_page']);
        }

        return $query->get();
    }

    public function scopeFilterByNameBangla($query, $search)
    {
        return $query->where('name_bangla', 'like', '%' . $search . '%');
    }

    public function scopeFilterByCategoryType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFilterBystatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
