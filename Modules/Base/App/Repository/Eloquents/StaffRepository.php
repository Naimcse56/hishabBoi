<?php

namespace Modules\Base\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Base\App\Models\Staff;
use Modules\Accounts\App\Models\SubLedger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StaffRepository extends BaseRepository
{
    public function listForSelect($search)
    {
        $items = Staff::query();
        if ($search != '') {
            $items = $items->whereLike(['users.name','staff_id'], $search);
        }
        $items = $items->with(['user'])->paginate(10);
        $response = [];
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->user_id,
                'text'  => $item->user->name
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
