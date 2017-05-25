<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'price' => 'integer'
    ];

    /**
     * Get plan by name
     *
     * @param $query
     * @param $name
     * @return mixed
     */
    public function scopeFindByName($query, $name)
    {
        return $query->where('name', $name)
            ->first();
    }
}
