<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\LedgerRepositoryInterface;
use App\Repository\Eloquents\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\App\Models\Ledger;
use Illuminate\Support\Arr;

class LedgerRepository extends BaseRepository implements LedgerRepositoryInterface
{
    public function __construct(Ledger $model)
    {
        parent::__construct($model);
    }

    public function parentNullAccountList($relational_data = [], $selected_data = ['*'])
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return $this->model::with($relational_data)
                    ->where('parent_id',0)
                    ->orderBy('type','asc')
                    ->orderBy('id','desc')                    
                    ->paginate(20, $selected_data);
        } else {
            abort(404);
        }      
    }

    public function transactionalLeadgerForSelect($search, $type, $account_type, $view, $page)
    {
        $items = $this->model::query();
        $items = $items->where('is_active',1);
        if ($search != '') {
            $items = $items->whereLike(['name', 'code','ac_no'], $search);
        } 
        if ($type == "cash_bank") {
            $items = $items->whereIn('acc_type',['bank', 'cash']);
        } elseif ($type == "cash") {
            $items = $items->where('acc_type','cash');
        } elseif ($type == "bank") {
            $items = $items->where('acc_type','bank');
        } elseif ($type == "other") {
            $items = $items->where('acc_type','others');
        } elseif ($type == "transactional") {
            $items = $items;
        } elseif ($type == "expense") {
            $items = $items->where('type', 3);
        } elseif ($type == "income") {
            $items = $items->where('type', 4);
        } elseif ($type == "cash_other") {
            $items = $items->whereIn('acc_type',['cash','others']);
        } elseif ($type == "bank_other") {
            $items = $items->whereIn('acc_type',['bank','others']);
        } elseif ($type == "exp_asset") {
            $items = $items->whereIn('type', [1,3]);
        } elseif ($account_type) {
            $items = $items->where('type',$account_type);
        }
        $items = $items->paginate(10,['id','name','code','ac_no','acc_type']);

        $response = [];
        if ($page == 1) {
            $response[]  = [
                'id'    => 0,
                'text'  => 'Select One'
            ];
        }
        if ($view == "ledger") {
            foreach($items as $item){
                if ($item->acc_type == "bank") {
                    $ac_no = $item->ac_no ? ' ( '.$item->ac_no.' ) ' : ' ( '.$item->code.' ) ';
                } else {
                    $ac_no = ' ( '.$item->code.' ) ';
                }
                $response[]  =[
                    'id'    => $item->id,
                    'text'  => $item->name.$ac_no
                ];
            }
        } else {
            foreach($items as $item){
                if ($item->acc_type == "bank") {
                    $ac_no = $item->ac_no ? ' ( '.$item->ac_no.' ) ' : ' ( '.$item->code.' ) ';
                } else {
                    $ac_no = ' ( '.$item->code.' ) ';
                }
                if ($item->categories()->count() == 0) {
                    $response[]  =[
                        'id'    => $item->id,
                        'text'  => $item->name.$ac_no
                    ];
                }
            }
        }
        
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }
    
    public function codeChecker($code,$parent_id,$purpose, $id = null)
    {
        if ($code && !$purpose) {
            return $this->model::where("code", $code)->first();
        }
        if ($purpose) {
            return $this->model::whereLike("name", $code)->get(['name']);
        }
        if ($parent_id) {
            $type = $this->model::find($parent_id)->type;
            if ($id) {
                $existLedger = $this->model::find($id);
                if ($existLedger->type == $type) {
                    return $existLedger->code;
                }
            }
            $coa = $this->model::where("type", $type)->orderBy('id','desc')->first();
            if ($coa) {
                $pos = 0;
                $begin = substr($coa->code, 0, $pos+1);
                $end = substr($coa->code, $pos+1);

                $code = $begin.(int)$end + 1;
            } else {
                if ($type == 1) {
                    $code = "A1".sprintf("%03d", $count);
                } elseif ($type == 2) {
                    $code = "L2".sprintf("%03d", $count);
                } elseif ($type == 3) {
                    $code = "E3".sprintf("%03d", $count);
                } elseif ($type == 4) {
                    $code = "I4".sprintf("%03d", $count);
                } elseif ($type == 5) {
                    $code = "E5".sprintf("%03d", $count);
                } else {
                    $count = $this->model::count()+1;
                    $code = "G".sprintf("%03d", $count);
                }
            }
            $checkCode = $this->model::where("code", $code)->first();
            if ($checkCode) {
                $pos = 0;
                $begin = substr($checkCode->code, 0, $pos+1);
                $end = substr($checkCode->code, $pos+1);

                $code = $begin.(int)$end + 1;
            }
            return $code;
        }
    }
}
