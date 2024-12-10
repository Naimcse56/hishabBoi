<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Repository\Interfaces\SubLedgerRepositoryInterface;
use Modules\Accounts\App\Models\SubLedger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SubLedgerRepository extends BaseRepository implements SubLedgerRepositoryInterface
{
    public function __construct(SubLedger $model)
    {
        parent::__construct($model);
    }

    public function transactionalLeadgerForSelect($search, $type, $page)
    {
        $items = SubLedger::query();
        $items = $items->where('is_active',1);
        if ($search != '') {
            $items = $items->whereLike(['name', 'code'], $search);
        }
        if ($type == "Client") {
            $items = $items->where('type','Client');
        }
        if ($type == "Vendor") {
            $items = $items->where('type','Vendor');
        }
        if ($type == "Staff") {
            $items = $items->where('type','Staff');
        }
        $items = $items->paginate(20);

        $response = [];
        if ($page == 1) {
            $response[]  = [
                'id'    => 0,
                'text'  => 'Select One'
            ];
        }
        foreach($items as $item){
        
            $displaytype = $item->type;
            $response[]  =[
                'id'    => $item->id,
                'text'  => $item->name .' ('.$displaytype.' '.$item->code.')'
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
