<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function listForSelect($search, $status, $is_selling, $is_purchase, $type)
    {
        $items = $this->model::query();
        if ($search != '') {
            $items = $items->whereLike(['name'], $search);
        }
        if ($status == "yes") {
            $items = $items->where('is_active', 1);
        }
        if ($is_selling == "yes") {
            $items = $items->where('for_selling', 1);
        }
        if ($is_purchase == "yes") {
            $items = $items->where('for_purchase', 1);
        }
        $items = $items->paginate(10);
        $response = [];
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->id,
                'text'  => $item->name
            ];
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }
}
