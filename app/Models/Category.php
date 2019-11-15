<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string $name Название категории
 * @property string|null $deleted_at
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Category[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereRgt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{

    use NodeTrait;

    /**
     * @inheritdoc
     */
    protected $table = 'categories';

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        '_lft',
        '_rgt',
        'deleted_at'
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

}
