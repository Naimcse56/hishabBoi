<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\AccountConfiguration;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\WorkOrder;
use Carbon\Carbon;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function report_config()
    {
        $data['settings'] = AccountConfiguration::get();
        return view('accounts::configs.report_config', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function general_config_store(Request $request): RedirectResponse
    {
        try {
            foreach ($request->field_name as $key => $field_name) {
                AccountConfiguration::where('name', $field_name)->first()->update(['value'=> $request->get($field_name)]);
            }
            return redirect()->back()->with('success','Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cashbook(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $cash_account_id = $request->cash_account_id > 0 ? $request->cash_account_id : 5;
        
        if ($cash_account_id > 0) {
            $data['filtered_account'] = Ledger::find($cash_account_id,['id','name']);
            $cash_account = Ledger::with('categories:id,parent_id,name,type')->where('acc_type','cash')->where('id', $cash_account_id)->get(['id','name','type']);
            $infos = array();
            $infos = $this->getChildrenID($cash_account, $infos, $start_date);            
            $data['opening'] = collect($infos)->sum('opening_balance');
            $cash_account_ids = collect($infos)->pluck(['id']);
            
            $transactions = Transaction::whereHas('voucher', function($query) use($cash_account_ids,$start_date,$end_date){
                                            $query->where('is_approve', 1);
                                        })->when($request->party_id > 0, function ($q) use ($request) {
                                            return $q->where('sub_ledger_id', $request->party_id);
                                        })->whereIn('ledger_id', $cash_account_ids)->whereBetween('date',[$start_date,$end_date])
                                        ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening,date','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                                        ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_id']);
            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions));
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.cashbook.cashbook_print', $data);
        }
        
        return view('accounts::reports.cashbook.cashbook', $data);
    }

    public function bankbook(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $bank_id = $request->bank_id > 0 ? $request->bank_id : 4;
        if ($bank_id > 0) {
            $data['filtered_account'] = Ledger::find($bank_id,['id','name','ac_no']);
            $bank_account = Ledger::with('categories:id,parent_id,name,type')->where('acc_type','bank')->where('id', $bank_id)->get(['id','name','type']);
            $infos = array();
            $infos = $this->getChildrenID($bank_account, $infos, $start_date);
            $data['opening'] = collect($infos)->sum('opening_balance');
            $bank_account_ids = collect($infos)->pluck(['id']);
            $transactions = Transaction::whereHas('voucher', function($query) use($bank_account_ids,$start_date,$end_date){
                                            $query->where('is_approve', 1)->whereBetween('date',[$start_date,$end_date]);
                                        })->when($request->party_id > 0, function ($q) use ($request) {
                                            return $q->where('sub_ledger_id', $request->party_id);
                                        })->whereIn('ledger_id',$bank_account_ids)
                                        ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                                        ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_id']);
            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions));
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.bankbook.bankbook_print', $data);
        }
        return view('accounts::reports.bankbook.bankbook', $data);
    }

    public function ledger_report(Request $request)
    {
        if ($request->has('account_id')) {
            $validated = $request->validate([
                'account_id' => 'required|numeric|gt:0',
            ],
            [
                'account_id.gt' => 'Please Select An Account',
            ]);
        }
        
        $party_account_id = $request->party_account_id > 0 ? $request->party_account_id : null;
        $data['party'] = Subledger::find($request->party_account_id > 0 ? $request->party_account_id : 0);
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['filtered_account_balance'] = 0;
        if ($request->account_id > 0) {
            $transactions = Transaction::query();
            $transactions = $transactions->where('is_approve', 1)
                                        ->whereBetween('date',[$start_date,$end_date]);
                                        
            if ($request->account_id > 0) {
                $account_id = $request->account_id;
                if($request->party_account_id > 0) {
                    $data['filtered_account'] = Ledger::with(['transactions:id,ledger_id,sub_ledger_id,accounting_additional_information_id,type,amount,is_approve,date'])->find($request->account_id,['id','name','ac_no','type']);
                    $data['filtered_account_balance'] = $data['filtered_account']->TransactionBalanceAmountTillDate($start_date,$party_account_id);
                } else {
                    $data['filtered_account'] = Ledger::with(['transactions'])->find($request->account_id,['id','name','ac_no','type']);
                    $data['filtered_account_balance'] = $data['filtered_account']->BalanceAmountTillDate($start_date);
                }
                $transactions = $transactions->where('ledger_id', $account_id)->when($party_account_id != null, function ($q) use ($party_account_id) {
                    return $q->where('sub_ledger_id', $party_account_id);
                });
            }
            $transactions = $transactions->with(['voucher:id,txn_id,f_year,type,narration,is_opening','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name'])
                                            ->get(['id','voucher_id','type','date','amount','ledger_id','sub_ledger_id','narration','credit_period']);
            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions));
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.ledger.print', $data);
        }
        return view('accounts::reports.ledger.index', $data);
    }

    public function sub_ledger_report(Request $request)
    {
        if ($request->has('party_id')) {
            $validated = $request->validate([
                'party_id' => 'required|numeric|gt:0',
            ],
            [
                'party_id.gt' => 'Please Select Account',
            ]);
        }
        
        $accounting_bill_info_id = $request->accounting_bill_info_id ? $request->accounting_bill_info_id : null;
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['filtered_account_balance'] = 0;
        if ($request->party_id > 0) {
            $party_id = $request->party_id;
            $data['filtered_account'] = SubLedger::with(['ledger:id,name,type'])->find($request->party_id,['id','name','email','ledger_id','code']);
            $data['filtered_account_balance'] = $data['filtered_account']->BalanceAmountTillDate($start_date);
            $transactions = Transaction::whereHas('voucher', function($query) use($party_id,$start_date,$end_date, $accounting_bill_info_id){
                $query->where('is_approve', 1)->whereBetween('date',[$start_date,$end_date])->whereHas('transactions', function($query) use($party_id, $accounting_bill_info_id){
                    $query->where('sub_ledger_id',$party_id)->when($accounting_bill_info_id != null, function ($q) use ($accounting_bill_info_id) {
                        return $q->where('accounting_bill_info_id', $accounting_bill_info_id);
                    });
                });
            })->whereNot('sub_ledger_id', $party_id)
            ->when($request->account_id > 0, function ($q) use ($request) {
                return $q->where('ledger_id', $request->account_id);
            })
            ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening','voucher.transactions:id,voucher_id,type,credit_period','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
            ->orderBy('id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_id']);

            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions,'party_report'));
        }
        if ($request->account_id > 0) {
            $data['ledger'] = Ledger::find($request->account_id,['id','name']); 
        }
        
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.sub_ledger.print', $data);
        }
        return view('accounts::reports.sub_ledger.index', $data);    
    }

    public function sub_ledger_summary_report(Request $request)
    {
        if ($request->has('type')) {
            $validated = $request->validate([
                'type' => 'required',
            ]);
        }
        
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        if ($request->type) {
            $sub_ledgers = SubLedger::query();
            $sub_ledgers = $sub_ledgers->with(['sub_ledger_type:id,name','transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id,narration,date,is_approve','transactions.voucher:id,date,type,f_year,txn_id','transactions.voucher.transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id']);
            $sub_ledgers = $sub_ledgers->when($request->type != null, function ($q) use ($request) {
                                return $q->where('type', $request->type);
                            })->get(['id','name','code','sub_ledger_type_id','ledger_id']);

            $ledger_id = $request->account_id ? $request->account_id : 0;
            if ($request->party_id > 0) {
                $data['party'] = SubLedger::find($request->party_id);
            }
            if ($request->account_id > 0) {
                $data['ledger'] = Ledger::find($request->account_id);
            }
            $tr_data = array();
            $parent_data = array();
            $reports = $this->getPartySummaryDataFormat($sub_ledgers, $tr_data, $start_date, $end_date, $request->type, $ledger_id, "approved_report");
            $data['reports'] = collect($reports);
        }
        $data['type'] = $request->type;
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.sub_ledger_summary.print', $data);
        }
        return view('accounts::reports.sub_ledger_summary.index', $data);    
    }

    protected function getDataFormatCashBankBookLedger($transactions, $report_type = null)
    {
        $tr_data = array();
        foreach ($transactions as $key => $transaction) {
            $new_data['date'] = $transaction->date;
            $new_data['voucher_id'] = $transaction->voucher_id;
            $new_data['is_opening'] = $transaction->voucher->is_opening;
            $new_data['particular'] = '('.$transaction->ledger->code.') '.$transaction->ledger->name;
            $new_data['voucher_type'] = $transaction->voucher->type;
            $new_data['txn_id'] = $transaction->voucher->TypeName;
            $new_data['type'] = $transaction->type;
            $new_data['amount'] = $transaction->amount;
            $new_data['narration'] = $transaction->narration;
            $new_data['party_id'] = $transaction->sub_ledger_id;
            $new_data['party'] = $transaction->sub_ledger->name;
            $new_data['work_order_id'] = $transaction->work_order_id;
            
            $new_data['work_order'] = '('.$transaction->work_order->order_name.') '.$transaction->work_order->order_no;
            $new_data['work_order_client'] = $transaction->work_order->sub_ledger->name;
            $new_data['work_order_site'] = $transaction->work_order_site_detail->site_name;
            foreach ($transaction->voucher->transactions->where('type', '!=',$transaction->type) as $k => $opposite_data) {
                $new_data['opposite_data'][$k]['info_type'] = $opposite_data->type.' Info';
                $new_data['opposite_data'][$k]['ledger'] = ' ('.$opposite_data->ledger->code.') '.$opposite_data->ledger->name;
                $new_data['opposite_data'][$k]['party'] =  $opposite_data->sub_ledger->name;
            }
            array_push($tr_data, $new_data);
            $new_data['opposite_data'] = [];
        }
        return $tr_data;
    }

    protected function getChildrenId($accounts, $tr_data, $start_date)
    {
        foreach ($accounts as $key => $child) {
            $new_data['id'] = $child->id;
            $new_data['name'] = $child->name;
            $new_data['opening_balance'] = $child->BalanceAmountTillDate($start_date);
        
            array_push($tr_data, $new_data);
            if (count($child->categories) > 0) {
                $tr_data = $this->getChildrenId($child->categories, $tr_data, $start_date);
            }
        }
        return $tr_data;
    }
    public function work_order_report(Request $request)
    {
        if ($request->has('work_order_id')) {
            $validated = $request->validate([
                'work_order_id' => 'required|numeric|gt:0',
            ],
            [
                'work_order_id.gt' => 'Please Select Work Order First !',
            ]);
        }
        
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')->from_date;
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        if ($request->work_order_id) {
            $work_order_id = $request->work_order_id ? $request->work_order_id : null;
            $data['work_order'] = WorkOrder::find($request->work_order_id);
            $work_order_ledger_id = $data['work_order']->sub_ledger_id;
            if ($request->work_order_site_id > 0) {
                $data['site_detail'] = WorkOrderSiteDetail::find($request->work_order_site_id);
            }
            $data['income_transactions'] = Transaction::whereHas('ledger', function ($query) {
                                                    $query->where('type', 4);
                                                })
                                                ->where('is_approve',1)
                                                ->where('work_order_id', $work_order_id)
                                                ->when($request->work_order_site_id > 0, function ($q) use ($request) {
                                                    return $q->where('work_order_site_id', $request->work_order_site_id);
                                                })
                                                ->whereBetween('date',[$start_date,$end_date])
                                                ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                                                ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id','work_order_site_id']);
            $data['rcv_income_transactions'] = Transaction::whereHas('ledger', function ($query) {
                                                    $query->where('type', 1);
                                                })->whereHas('voucher', function ($query) {
                                                    $query->whereIn('type', ['rcv_cash','rcv_bank','rcv']);
                                                })
                                                ->where('is_approve',1)
                                                ->where('type',"Dr")
                                                ->where('work_order_id', $work_order_id)
                                                ->when($request->work_order_site_id > 0, function ($q) use ($request) {
                                                    return $q->where('work_order_site_id', $request->work_order_site_id);
                                                })
                                                ->whereBetween('date',[$start_date,$end_date])
                                                ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                                                ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id','work_order_site_id']);
            
            $data['expense_transactions'] = Transaction::whereHas('ledger', function ($query) {
                                                    $query->where('type', 3);
                                                })
                                                ->where('is_approve',1)
                                                ->where('work_order_id', $work_order_id)
                                                ->when($request->work_order_site_id > 0, function ($q) use ($request) {
                                                    return $q->where('work_order_site_id', $request->work_order_site_id);
                                                })
                                                ->whereBetween('date',[$start_date,$end_date])
                                                ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                                                ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id','work_order_site_id']);
            $data['pay_expense_transactions'] = Transaction::whereHas('ledger', function ($query) {
                                                    $query->where('type', 1);
                                                })->whereHas('voucher', function ($query) {
                                                    $query->whereIn('type', ['pay_cash','pay_bank','pay']);
                                                })
                                                ->where('is_approve',1)
                                                ->where('type',"Cr")
                                                ->where('work_order_id', $work_order_id)
                                                ->when($request->work_order_site_id > 0, function ($q) use ($request) {
                                                    return $q->where('work_order_site_id', $request->work_order_site_id);
                                                })
                                                ->whereBetween('date',[$start_date,$end_date])
                                                ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                                                ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id','work_order_site_id']);

            $data['account'] = SubLedger::find($work_order_ledger_id,['id','name','code']);
            $data['filtered_account_balance'] = $data['account']->BalanceAmountTillDate($start_date);
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.work_order.print', $data);
        }
        return view('accounts::reports.work_order.index', $data);
    }

    public function work_order_summary_report(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        if ($request->client > 0) {
            $data['client'] = SubLedger::find($request->client,['id','name']);
        }
        $work_orders = WorkOrder::when($request->client > 0, function ($q) use ($request) {
            return $q->where('sub_ledger_id', $request->client);
        })->when($request->awarded_by > 0, function ($q) use ($request) {
            return $q->where('awarded_by', $request->awarded_by);
        })->get();
        $data['awarded_persons'] = WorkOrder::get()->unique('awarded_by')->pluck(['awarded_by']);
        $transactions = Transaction::whereHas('ledger', function ($query) {
                            $query->where('type', 1);
                        })->whereHas('voucher', function ($query) {
                            $query->whereIn('type', ['pay_cash','pay_bank','pay']);
                        })
                        ->where('is_approve',1)
                        ->where('type',"Cr")
                        ->whereIn('work_order_id', $work_orders->pluck('id')->toArray())
                        ->whereBetween('date',[$start_date,$end_date])
                        ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                        ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id']);

        $exp_transactions = Transaction::whereHas('ledger', function ($query) {
                            $query->where('type', 3);
                        })
                        ->where('is_approve',1)
                        ->whereIn('work_order_id', $work_orders->pluck('id')->toArray())
                        ->whereBetween('date',[$start_date,$end_date])
                        ->with(['voucher:id,type,txn_id,f_year','ledger:id,name,ac_no'])
                        ->get(['id','date','voucher_id','narration','amount','type','work_order_id','ledger_id','sub_ledger_id']);
                        
        $tr_data = array();
        $reports = $this->getWorkOrderDataFormat($work_orders, $tr_data, $start_date, $end_date, $transactions, $exp_transactions);
        $data['reports'] = collect($reports);
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.work_order_summary.print', $data);
        }
        return view('accounts::reports.work_order_summary.index', $data);    
    }

    protected function getPartySummaryDataFormat($accounts, $tr_data, $start_date, $end_date, $type, $ledger_id, $approval_type)
    {
        foreach ($accounts as $key => $child) {
            if ($child->BalanceAmount != 0) {
                $new_data['name'] = $child->name;
                $new_data['code'] = $child->code;
                $new_data['sub_ledger_type'] = $child->sub_ledger_type->name;
                $new_data['opening_balance'] = $ledger_id > 0 ? $child->BalanceAmountTillDateByTypeByLedger($start_date, $type, $ledger_id) : $child->BalanceAmountTillDateByType($start_date, $type);
                $new_data['transaction_data'] = array();
                if ($ledger_id > 0) {
                    $all_transactions = $child->transactions->where('is_approve', 1)->where('ledger_id', $ledger_id)->whereBetween('date',[$start_date, $end_date]);
                } else {
                    $all_transactions = $child->transactions->where('is_approve', 1)->whereBetween('date',[$start_date, $end_date]);
                }
                foreach ($all_transactions as $key => $transaction) {
                    $transac_data['voucher_id'] = $transaction->voucher_id;
                    $transac_data['date'] = date('d/m/Y', strtotime($transaction->voucher->date));
                    $transac_data['type'] = $transaction->type;
                    $transac_data['txn_id'] = $transaction->voucher->TypeName;
                    $transac_data['narration'] = $transaction->narration;
                    $transac_data['amount'] = $transaction->amount;
                    $transac_data['ledger'] = $transaction->ledger->name;
                    $transac_data['opposite_transaction_data'] = array();
                    foreach ($transaction->voucher->transactions->where('type', '!=', $transaction->type) as $trn) {
                        $opp_data['opposite_type'] = $trn->type;
                        $opp_data['opposite_ledger'] = $trn->ledger->name;
                        array_push($transac_data['opposite_transaction_data'], $opp_data);
                    }
                    array_push($new_data['transaction_data'], $transac_data);
                }
                array_push($tr_data, $new_data);
            }
        }
        return $tr_data;
    }

    protected function getWorkOrderDataFormat($work_orders, $tr_data, $start_date, $end_date, $transactions, $expense_transactions)
    {
        foreach ($work_orders as $work_order)
        {
            $total_payment = $transactions->where('work_order_id', $work_order->id)->sum('amount');
            $total_exp = $expense_transactions->where('work_order_id', $work_order->id)->sum('amount');
            $est_cost = $work_order->work_order_estimation_costs()->sum('estimated_amount') > 0 ?$work_order->work_order_estimation_costs()->sum('estimated_amount') : 1;
            $actual_exp_cal = $total_exp - $total_payment;
            $est_profit = $work_order->order_value - $est_cost;
            $new_data['customer'] = $work_order->sub_ledger->name;
            $new_data['name'] = $work_order->order_name;
            $new_data['code'] = $work_order->order_no;
            $new_data['order_value'] = $work_order->order_value;
            $new_data['estimated_cost'] = $est_cost;
            $new_data['estimated_profit'] = $est_profit;
            $new_data['total_exp'] = $total_exp;
            $new_data['total_payment'] = $total_payment;
            $new_data['investment_percent'] = ($total_payment / $est_cost) * 100;
            array_push($tr_data, $new_data);
        }
        return $tr_data;
    }
}
