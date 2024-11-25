<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\SubLedgerRepositoryInterface;
use Modules\Accounts\App\Models\SubLedger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\App\Models\AccountingBillInfo;
use Illuminate\Support\Arr;

class SubLedgerRepository implements SubLedgerRepositoryInterface
{
    public function listForDataTable($type)
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return SubLedger::with(['member_type:id,name'])->where('branch_id',app('branch_info')['current_branch_id'])->where($type,'>',0)->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function create(array $data)
    {
        $customer = $supplier = $member = $land_owner = 0;
        foreach ($data['type'] as $key => $type) {
            if ($type == "Customer") {
                $customer = app('account_configurations')['account_recievable'];
            }
            if ($type == "Supplier") {
                $supplier = app('account_configurations')['account_payable'];
            }
            if ($type == "LandOwner") {
                $land_owner = app('account_configurations')['account_payable'];
            }
            if ($type == "Member") {
                $member = app('account_configurations')['leadger_account_for_employee'];
            }
        }
        $data = Arr::add($data, "customer", $customer);
        $data = Arr::add($data, "supplier", $supplier);
        $data = Arr::add($data, "land_owner", $land_owner);
        $data = Arr::add($data, "member", $member);
        $data = Arr::add($data, "branch_id", app('branch_info')['current_branch_id']);
        $data = Arr::add($data, "code", $data['code'] ? $data['code'] : substr(str_replace(' ', '', $data['name']), 0, 1).date('Ydhis'));
        
        Arr::forget($data, 'type');
        if (!empty($data['nid'])) {
            $file = $data['nid'];
            $name = uniqid() . '-nid-'.strtolower(str_replace(' ','-',$data['name'])).'.'.$file->extension();
            $file->move(public_path() . '/party-files/nid/', $name);
            $path_nid = '/party-files/nid/' . $name;
            Arr::forget($data, 'nid');
            $data = Arr::add($data, "nid", $path_nid);
        }
        if (!empty($data['trade_licence'])) {
            $trade_licence = $data['trade_licence'];
            $name = uniqid() . '-trade-licence-'.strtolower(str_replace(' ','-',$data['name'])).'.'.$trade_licence->extension();
            $trade_licence->move(public_path() . '/party-files/trade_licence/', $name);
            $path_trade_licence = '/party-files/trade_licence/' . $name;
            Arr::forget($data, 'trade_licence');
            $data = Arr::add($data, "trade_licence", $path_trade_licence);
        }
        SubLedger::create($data);
        return true;
    }

    public function findById($id)
    {
        return SubLedger::with(['ledger','customer_info','supplier_info','member_info'])->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $customer = $supplier = $member = $land_owner = 0;
        foreach ($data['type'] as $key => $type) {
            if ($type == "Customer") {
                $customer = app('account_configurations')['account_recievable'];
            }
            if ($type == "Supplier") {
                $supplier = app('account_configurations')['account_payable'];
            }
            if ($type == "LandOwner") {
                $land_owner = app('account_configurations')['account_payable'];
            }
            if ($type == "Member") {
                $member = app('account_configurations')['leadger_account_for_employee'];
            }
        }
        $data = Arr::add($data, "customer", $customer);
        $data = Arr::add($data, "supplier", $supplier);
        $data = Arr::add($data, "land_owner", $land_owner);
        $data = Arr::add($data, "member", $member);
        Arr::forget($data, 'type');
        if (!empty($data['nid'])) {
            $file = $data['nid'];
            $name = uniqid() . '-nid-'.strtolower(str_replace(' ','-',$data['name'])).'.'.$file->extension();
            $file->move(public_path() . '/party-files/nid/', $name);
            $path_nid = '/party-files/nid/' . $name;
            Arr::forget($data, 'nid');
            $data = Arr::add($data, "nid", $path_nid);
        }
        if (!empty($data['trade_licence'])) {
            $trade_licence = $data['trade_licence'];
            $name = uniqid() . '-trade-licence-'.strtolower(str_replace(' ','-',$data['name'])).'.'.$trade_licence->extension();
            $trade_licence->move(public_path() . '/party-files/trade_licence/', $name);
            $path_trade_licence = '/party-files/trade_licence/' . $name;
            Arr::forget($data, 'trade_licence');
            $data = Arr::add($data, "trade_licence", $path_trade_licence);
        }
        return SubLedger::find($id)->update($data);
    }

    public function delete($id)
    {
        $charAccount = $this->findById($id);
        if ($charAccount->is_blocked) {
            return "failed";
        }else {
            $charAccount->delete();
            return "done";
        }
    }

    public function transactionalLeadgerForSelect($search, $type, $branch_id, $page)
    {
        $items = SubLedger::query();
        $items = $items->where('is_active',1);
        if ($search != '') {
            $items = $items->whereLike(['name', 'code'], $search);
        }
        if ($type == "customer") {
            $items = $items->where('customer','>',0);
        }
        if ($type == "supplier") {
            $items = $items->where('supplier','>',0);
        }
        if ($type == "member") {
            $items = $items->where('member','>',0);
        }
        if ($type == "land_owner") {
            $items = $items->where('land_owner','>',0);
        }
        if ($type == "member_supplier") {
            $items = $items->where('member','>',0)->orWhere('supplier','>',0);
        }
        if ($branch_id && $type != "member") {
            $items = $items->where('branch_id',$branch_id)->paginate(20);
        } else {
            $items = $items->where('branch_id',app('branch_info')['current_branch_id'])->paginate(20);
        }

        $response = [];
        if ($page == 1) {
            $response[]  = [
                'id'    => 0,
                'text'  => 'Select One'
            ];
        }
        foreach($items as $item){
        
            $displaytype = $item->customer > 0 ? 'Client: ' : ($item->supplier > 0 ? 'Sup: ' : ($item->land_owner > 0 ? 'Land: ' : 'Mem'));
            $response[]  =[
                'id'    => $item->id,
                'text'  => $item->name .' ('.$displaytype.$item->code.')'
            ];
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }

    public function billInfoForSelect($search, $sub_ledger_id, $type)
    {
        $items = AccountingBillInfo::query();
        $items = $items->where('sub_ledger_id', $sub_ledger_id);
        if ($search != '') {
            $items = $items->whereLike(['bill_no', 'bill_date'], $search);
        }
        if($type == "due_payable") {
            $items = $items->with(['sub_ledger:id,name,member_type_id','sub_ledger.member_type:id,name','vouchers_sales_purchases:id,accounting_bill_info_id,date,narration,amount,type','vouchers_payments:id,type,accounting_bill_info_id,date,narration,amount'])->where('type','payment')
                            ->paginate(40)
                            ->filter(function ($bill) {
                                $purchaseTotal = $bill->vouchers_sales_purchases->where('type', 'purchase')->sum('amount');
                                $paymentTotal = $bill->vouchers_payments->whereIn('type', ['pay', 'pay_cash', 'pay_bank'])->sum('amount');
                                
                                return $purchaseTotal > $paymentTotal;
                            });
        }
        // $items = $items->paginate(20);
        $response = [];
        if ($type == "due_payable") {
            foreach($items as $item){
                $due = $item->vouchers_sales_purchases->sum('amount') - $item->vouchers_payments->sum('amount');
                if ($due > 0) {
                    $response[] = [
                        'id'    => $item->id,
                        'text'  => $item->bill_no .' > Due : '. currencySymbol($due)
                    ];
                }
            }
        } elseif ($type == "due_receivable") {
            foreach($items as $item){
                $due = $item->vouchers_sales_purchases->sum('amount') - $item->vouchers_payments->sum('amount');
                if ($due > 0) {
                    $response[] = [
                        'id'    => $item->id,
                        'text'  => $item->bill_no .' > Due : '. currencySymbol($due)
                    ];
                }
            }
        } else {
            foreach($items as $item){
                $response[] = [
                    'id'    => $item->id,
                    'text'  => $item->bill_no .' > '.date('d/m/Y', strtotime($item->bill_date)).' > Amount : '. currencySymbol($item->amount)
                ];
            }
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }

    public function billInfoDetails($id)
    {
        return AccountingBillInfo::find($id);
    }
}
