<?php

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 模型类
 */
class Category extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['deleted_at'];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $table = 'sila_categories';

    protected $fillable = ['model_id', 'model_name', 'name', 'slug', 'parent_id', 'cover', 'status'];
}
