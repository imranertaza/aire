<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = ['id'];

    // Cast JSON column to array automatically
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Helper to get a value by key.
     */
    public function getValue(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Helper to set a value by key.
     */
    public function setValue(string $key, $value): void
    {
        $data = $this->data ?? [];
        $data[$key] = $value;
        $this->data = $data;
        $this->save();
    }
}
