<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $children = collect($this->children)->map(function ($value) {
            return [
                'name' => $value['name'],
                'slug' => $value['slug'],
                'product' => $value['product'],
                'ui' => $value['ui'],
            ];
        });

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'product' => $this->product,
            'ui' => $this->ui,
            'sub_categories' => $children,
        ];
    }
}
