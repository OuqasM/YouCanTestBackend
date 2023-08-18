<?php

namespace App\Repositories;

use App\Models\Product;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{

    public function model()
    {
        return Product::class;
    }
    public function getAllWithFiltersAndSort($categoryId = null, $sortByPrice = false)
    {
        $query = $this->model->newQuery();
        
        // filtering only product that belongs to that category provided by $categoryId
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('id', $categoryId);
            });
        }

        if ($sortByPrice) {
            $query->orderBy('price', 'asc');
        }

        return $query->get();
    }

}




