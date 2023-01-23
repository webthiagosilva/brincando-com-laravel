<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $endereco
 */
class Person extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pessoas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['id', 'nome', 'endereco'];

    /**
     * The table's timestamp columns.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the cpf wit mask.
     *
     * @return string
     */
    public function getCpfAttribute()
    {
        return $this->attributes['cpf'] = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->attributes['cpf']);
    }

    /**
     * Set the cpf without mask.
     *
     * @param  string  $value
     * @return void
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }
}
