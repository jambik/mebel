<?php

namespace App;

use App\Traits\ImageableTrait;
use App\Traits\ResourceableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model implements SluggableInterface
{
    use NodeTrait, ImageableTrait, SluggableTrait, ResourceableTrait;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'about',
        'title',
        'keywords',
        'description',
        'image',
        'parent_id',
        '_lft',
        '_rgt'
    ];

    protected $appends = ['text', 'img_url'];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * Get the text attribute.
     */
    public function getTextAttribute()
    {
        return $this->name;
    }

    /**
     * Get all products of category.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Добавляем пробелы в начале названий категорий, чтобы была видна вложенность
     *
     * @param $categories
     */
    public static function addSpaces($categories)
    {
        /*$categories = Category::withDepth()->get()->toTree();
        $traverse = function ($categories) use (&$traverse) {
            foreach ($categories as $category) {
                $prefix = str_repeat(' ', $category->depth * 5);
                $category->name = $prefix . $category->name;
                $traverse($category->children);
            }
        };
        $traverse($categories);*/

        foreach ($categories as $category) {
            $prefix = str_repeat('&nbsp;', $category->depth * 8);
            $category->name = $prefix . $category->name;
        }
    }

    /**
     * Категории со свойствами
     */
    public static function categoriesWithProperties()
    {
        $categories = static::withDepth()->defaultOrder()->get()->toTree();

        $propertiesList = trans('vars.properties');

        foreach($categories as $category) {
            $properties = null;

            // Get category products
            $productsId = Product::all()->where('category_id', $category->id)->pluck('id')->all();

            // Get all products properties
            $productsProperties = ProductProperties::all()->whereInLoose('product_id', $productsId);

            // Get each property value array
            foreach ($propertiesList as $property => $propertyName) {
                $currentProperties = $productsProperties->pluck($property, $property.'_slug')->unique()->sortBy($property)->except('');
                $currentProperties->count() ? $properties[$property] = $currentProperties : null;
            }

            $category->properties = $properties;
        }

        return $categories;
    }
}
