<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Models\FiscalYear;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class FiscalyearRepository
{
    public function listForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return FiscalYear::orderBy('id','desc');
        } else {
            abort(404);
        }
    }
    public function create(array $data)
    {
        abort(404);
        $data = Arr::add($data, "from_date", Carbon::createFromFormat('d/m/Y', $data["start_date"])->format('Y-m-d'));
        $data = Arr::add($data, "to_date", Carbon::createFromFormat('d/m/Y', $data["end_date"])->format('Y-m-d'));
        FiscalYear::create($data);
        return true;
    }

    public function findById($id)
    {
        return FiscalYear::findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $data = Arr::add($data, "from_date", Carbon::createFromFormat('d/m/Y', $data["start_date"])->format('Y-m-d'));
        $data = Arr::add($data, "to_date", Carbon::createFromFormat('d/m/Y', $data["end_date"])->format('Y-m-d'));
        $fiscalYear = FiscalYear::find($id);
        $fiscalYear->update($data);
        if ($data['is_closed'] == 1) {
            $yearData = explode('-',$fiscalYear->year);
            $newYear = ($yearData[0]+1).'-'.($yearData[1]+1);
            FiscalYear::create(['from_date' => Carbon::createFromFormat('d/m/Y', $data["end_date"])->addDays(1), 'year' => $newYear]);
        }
        return true;
    }

    public function listForSelect($search, $type, $branch_id)
    {
        $items = FiscalYear::query();
        if ($search != '') {
            $items = $items->whereLike(['from_date','year'], $search);
        }        

        $response = [];
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->id,
                'text'  => $item->year
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
