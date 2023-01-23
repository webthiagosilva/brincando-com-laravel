<?php

namespace App\Models;

use App\Support\Searchable\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    use Searchable;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created', 'modified'];

    public function scopeFromWithIndex(Builder $builder, string $index, string $table = null): Builder
    {
        if ($table === null) {
            $table = $this->table;
        }

        if ($builder->getConnection()->getName() == 'mysql') {
            $builder->from(DB::raw(sprintf('%s use index(%s)', $table, $index)));
        } else {
            $builder->from(DB::raw($table));
        }

        return $builder;
    }

    public static function concat(array $fields): string
    {
        if (DB::getDefaultConnection() == 'mysql') {
            $concat = 'concat(' . implode(',', $fields) . ')';
        } else {
            $concat = '(' . implode(' || ', $fields) . ')';
        }

        return $concat;
    }
}
