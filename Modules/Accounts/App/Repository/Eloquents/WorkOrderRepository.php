<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\WorkOrderRepositoryInterface;
use Modules\Accounts\App\Models\WorkOrder;
use Modules\Accounts\App\Models\WorkOrderEstimationCost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class WorkOrderRepository implements WorkOrderRepositoryInterface
{
    public function listForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return WorkOrder::where('branch_id',app('branch_info')['current_branch_id'])->orderBy('id','desc');
        } else {
            abort(404);
        }
    }
    public function create(array $data)
    {
        $data = Arr::add($data, "date", Carbon::createFromFormat('d/m/Y', $data["create_date"])->format('Y-m-d'));
        $data = Arr::add($data, "final_date", Carbon::createFromFormat('d/m/Y', $data["end_date"])->format('Y-m-d'));
        $data = Arr::add($data, "branch_id", app('branch_info')['current_branch_id']);
        $work_order = WorkOrder::create($data);
        if (!empty($data['cost_type'])) {
            foreach ($data['cost_type'] as $key => $ledger_id) {
                WorkOrderEstimationCost::create([
                    'work_order_id' => $work_order->id,
                    'ledger_id' => $ledger_id,
                    'estimated_amount' => $data['cost_amounts'][$key],
                ]);
            }
        }
        return true;
    }

    public function findById($id)
    {
        return WorkOrder::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $data = Arr::add($data, "date", Carbon::createFromFormat('d/m/Y', $data["create_date"])->format('Y-m-d'));
        $data = Arr::add($data, "final_date", Carbon::createFromFormat('d/m/Y', $data["end_date"])->format('Y-m-d'));
        $work_order = WorkOrder::find($id);
        $work_order->update($data);
        $work_order->work_order_estimation_costs()->delete();
        if (!empty($data['cost_type'])) {
            foreach ($data['cost_type'] as $key => $ledger_id) {
                WorkOrderEstimationCost::create([
                    'work_order_id' => $work_order->id,
                    'ledger_id' => $ledger_id,
                    'estimated_amount' => $data['cost_amounts'][$key],
                ]);
            }
        }
        return $work_order;
    }

    public function delete($id)
    {
        $order = $this->findById($id);
        $order->work_order_estimation_costs()->delete();
        $order->delete();
    }

    public function workOrderForSelect($search, $branch_id, $sub_ledger_id, $page)
    {
        $branch_id = $branch_id ? $branch_id : app('branch_info')['current_branch_id'];
        $items = WorkOrder::query();
        $items = $items->where('branch_id',$branch_id)->where('is_active',1);
        if ($search != '') {
            $items = $items->whereLike(['order_name', 'order_no'], $search);
        }
        if ($sub_ledger_id > 0) {
            $items = $items->where('sub_ledger_id',$sub_ledger_id);
        }
        $items = $items->paginate(20,['id','order_no','order_name']);

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
                'text'  => '('.$item->order_no.') '.$item->order_name
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
