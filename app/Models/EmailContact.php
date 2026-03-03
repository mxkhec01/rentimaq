<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmailContact extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'recibe_facturacion',
        'recibe_cotizacion',
        'recibe_contacto',
        'activo',
    ];

    protected $casts = [
        'recibe_facturacion' => 'boolean',
        'recibe_cotizacion' => 'boolean',
        'recibe_contacto' => 'boolean',
        'activo' => 'boolean',
    ];

    /**
     * Scope: only active contacts.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: contacts that receive a specific form type.
     *
     * @param string $type One of: 'facturacion', 'cotizacion', 'contacto'
     */
    public function scopeForType(Builder $query, string $type): Builder
    {
        $column = "recibe_{$type}";

        if (!in_array($column, ['recibe_facturacion', 'recibe_cotizacion', 'recibe_contacto'])) {
            return $query->whereRaw('1 = 0'); // Safety: invalid type returns nothing
        }

        return $query->where($column, true);
    }
}
