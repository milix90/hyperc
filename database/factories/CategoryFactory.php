<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name;
        $rand = rand(1, 1000);

        return [
            'parent_id' => $rand,
            'latitude' => null,
            'name' => $name,
            'slug' => Str::slug($name),
            'product' => 0,
            'ui' => [
                'icon' => 'fa-ball',
                'background' => "/images/{$rand}.jpg",
                'color' => 'blue',
            ],
        ];
    }
}
