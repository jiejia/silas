<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelField extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'sila_model_fields';

    protected $fillable = ['name', 'comments', 'table_field_name', 'model_id', 'config', 'length', 'form_control', 'valid_rule', 'valid_msg'];

    /**
     * @return Attribute
     */
    protected function config(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
