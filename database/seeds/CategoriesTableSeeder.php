<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    protected $items = [

        [1, 'Соковыжималки', 0],
        [2, 'Дегидраторы', 0],
        [3, 'Блендеры', 0],
        [4, 'Вертикальные шнековые', 1],
        [5, 'Горизонтальные одношнековые', 1],
        [6, 'Горизонтальные двушнековые', 1],
        [7, 'Ручные шнековые', 1],
        [8, 'Прессовые', 1],
        [9, 'Для зелени', 8],
        [10, 'Для корнеплодов', 8],
        [11, 'Для ягод', 8],
        [12, 'Для цитрусовых', 8],
        [13, 'Профессиональные блендеры', 3],
        [14, 'Миксеры-измельчители', 3],
        [15, 'Персональные мини-блендеры', 3],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0, $iMax=count($this->items); $i<$iMax; $i++)
        {
            $row = array_combine(['id', 'name', 'parent_id'], $this->items[$i]);

            Category::create($row);
        }
    }
}
