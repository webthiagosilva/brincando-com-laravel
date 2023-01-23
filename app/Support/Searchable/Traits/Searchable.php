<?php

namespace App\Support\Searchable\Traits;

use App\Support\Searchable\Filter;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{

    public function scopeCustomPaginate(Builder $builder, $useSimplePaginate = false, ?array $data = null)
    {
        if (is_null($data)) {
            $data = request()->query();
        }

        $order = 'ASC';
        $perPage = 15;

        if (!empty($data['per_page'])) {
            $perPage = $data['per_page'];
        }

        if (!empty($data['sort'])) {
            $orderBy = $data['sort'];

            if ($data['sort'][0] === '-') {
                $orderBy = substr($data['sort'], 1);
                $order = 'DESC';
            }

            $builder->orderBy($orderBy, $order);
        }

        return $useSimplePaginate
            ? $builder->simplePaginate((int) $perPage)->appends($data)
            : $builder->paginate((int) $perPage)->appends($data);
    }

    public function scopeSearchable(Builder $builder, array $searchable)
    {
        foreach ($searchable as $filter) {
            if (!($filter instanceof Filter)) {
                throw new \InvalidArgumentException('Searchable must be an Filter instance');
            }

            $value = $filter->getValue();

            if (!$filter->isValid($value)) {
                continue;
            }

            $attribute = $filter->getAttribute();

            if ($filter->getOperator() === 'IN') {
                $builder->whereIn($attribute, $value);
            } else {
                $builder->where($attribute, $filter->getOperator(), $value);
            }
        }

        return $builder;
    }
}
