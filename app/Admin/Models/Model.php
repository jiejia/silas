<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 模型类
 */
class Model extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'sila_models';

    protected $fillable = ['name', 'table_name', 'description', 'status'];

    /**
     * @return HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(ModelField::class, 'model_id', 'id');
    }
}
