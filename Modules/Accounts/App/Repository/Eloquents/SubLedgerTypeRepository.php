<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\SubLedgerType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SubLedgerTypeRepository extends BaseRepository
{
    public function __construct(SubLedgerType $model)
    {
        parent::__construct($model);
    }

    public function businessUnitForSelect($search, $is_for)
    {
        $items = SubLedgerType::query();
        if ($search != '') {
            $items = $items->whereLike(['name'], $search);
        }        
        $items = $items->where('is_for', $is_for)->paginate(10);
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
