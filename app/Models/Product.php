<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name Название товара
 * @property string $description Описание товара
 * @property int $category_id
 * @property int|null $file_id
 * @property string|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\File $poster
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product filterCategory($category)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @mixin \Eloquent
 */
class Product extends Model
{

    /**
     * @inheritdoc
     */
    protected $table = 'products';

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'file_id'
    ];

    /**
     * Фильтр товаров по категориям
     * @param Builder $builder
     * @param $categoryId
     */
    static public function scopeFilterCategory(Builder $builder, $categoryId)
    {
        if (!empty($categoryId)) {
            $builder->where('category_id', '=', $categoryId);
        }
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function poster(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

}
