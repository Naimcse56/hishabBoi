<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\WorkOrderSiteDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WorkOrderSiteRepository extends BaseRepository
{
    public function __construct(WorkOrderSiteDetail $model)
    {
        parent::__construct($model);
    }
    public function workOrderSitesForSelect($search, $work_order_id, $page)
    {
        $items = WorkOrderSiteDetail::query();
        if ($search != '') {
            $items = $items->whereLike(['site_name', 'est_budget'], $search);
        }
        if ($work_order_id > 0) {
            $items = $items->where('work_order_id',$work_order_id);
        }
        $items = $items->paginate(20,['id','site_name','site_pm_name']);

        $response = [];
        if ($page == 1) {
            $response[]  = [
                'id'    => 0,
                'text'  => 'Select One'
            ];
        }
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->id,
                'text'  => $item->site_name
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
