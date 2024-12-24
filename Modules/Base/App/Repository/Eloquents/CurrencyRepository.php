<?php

namespace Modules\Base\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Base\App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CurrencyRepository extends BaseRepository
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    public function listForSelect($search)
    {
        $items = $this->model::query();
        if ($search != '') {
            $items = $items->whereLike(['name','code','symbol'], $search);
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
