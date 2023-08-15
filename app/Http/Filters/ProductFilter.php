<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    const TITLE = 'title';
    const PRICE = 'price';
    const SYSTEM = 'system';
    const CATEGORY = 'category';


    public function getCallbacks(): array
    {
        return [
          self::PRICE => 'price',
          self::TITLE => 'title',
          self::SYSTEM => 'system',
          self::CATEGORY => 'category'
        ];
    }

    public function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%");
    }
    public function price(Builder $builder, $value)
    {
        $builder->whereHas('categories', function (Builder $query) use ($value){
            $query->where('title', $value);
        });
    }

    public function system(Builder $builder, $value)
    {
        $builder->whereHas('categories', function (Builder $query) use ($value){
            $query->where('title', $value);
        });
    }
    public function category(Builder $builder, $value)
    {
        $builder->whereHas('categories', function (Builder $query) use ($value){
            $query->where('title', $value);
        });
    }
}
