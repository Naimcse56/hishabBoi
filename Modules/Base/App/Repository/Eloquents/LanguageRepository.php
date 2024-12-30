<?php

namespace Modules\Base\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Base\App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class LanguageRepository extends BaseRepository
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

    public function listForSelect($search)
    {
        $items = $this->model::query();
        if ($search != '') {
            $items = $items->whereLike(['name','code'], $search);
        }
        $items = $items->where('status', 1)->paginate(10);
        $response = [];
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->code,
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
