<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Models\MemberType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class MemberTypeRepository
{
    public function listForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return MemberType::where('branch_id',app('branch_info')['current_branch_id'])->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function create(array $data)
    {
        $data = Arr::add($data, "branch_id", app('branch_info')['current_branch_id']);
        MemberType::create($data);
        return true;
    }

    public function findById($id)
    {
        return MemberType::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        return MemberType::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }

    public function businessUnitForSelect($search, $is_for)
    {
        $items = MemberType::query();
        if ($search != '') {
            $items = $items->whereLike(['name'], $search);
        }        
        $items = $items->where('branch_id',app('branch_info')['current_branch_id'])->where('is_for', $is_for)->paginate(10);
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
