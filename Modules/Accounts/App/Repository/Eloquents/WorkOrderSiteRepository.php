<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\WorkOrderRepositoryInterface;
use Modules\Accounts\App\Models\WorkOrderSiteDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WorkOrderSiteRepository
{
    public function listForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return WorkOrderSiteDetail::with(['work_order'])->where('branch_id',app('branch_info')['current_branch_id'])->orderBy('id','desc');
        } else {
            abort(404);
        }
    }
    public function create(array $data)
    {
        $data = Arr::add($data, "created_by", auth()->user()->id);
        $data = Arr::add($data, "branch_id", app('branch_info')['current_branch_id']);
        $work_order = WorkOrderSiteDetail::create($data);
        return true;
    }

    public function findById($id)
    {
        return WorkOrderSiteDetail::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $data = Arr::add($data, "updated_by", auth()->user()->id);
        $work_order = WorkOrderSiteDetail::find($id);
        $work_order->update($data);
        return $work_order;
    }

    public function delete($id)
    {
        $order = $this->findById($id);
        $order->delete();
    }

    public function workOrderSitesForSelect($search, $branch_id, $work_order_id, $page)
    {
        $branch_id = $branch_id ? $branch_id : app('branch_info')['current_branch_id'];
        $items = WorkOrderSiteDetail::query();
        $items = $items->where('branch_id',$branch_id);
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
