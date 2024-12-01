<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Interfaces\WorkOrderRepositoryInterface;
use Modules\Accounts\App\Http\Requests\WorkOrderRequest;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\Ledger;
use Carbon\Carbon;
use DataTables;

class WorkOrderController extends Controller
{
    private object $workOrderInterface;

    public function __construct(WorkOrderRepositoryInterface $workOrderInterface)
    {
        $this->workOrderInterface = $workOrderInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->workOrderInterface->listForDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('is_active', function($row){      
                        return view('accounts::work_orders.components.is_active', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::work_orders.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active'])
                    ->make(true);
        }
        return view('accounts::work_orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts::work_orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->workOrderInterface->create($request->except("_token"));
            DB::commit();
            return redirect()->back()->with('success',' Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data['item'] = $this->workOrderInterface->findById(decrypt($id));
            return view('accounts::work_orders.show', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['item'] = $this->workOrderInterface->findById(decrypt($id));
            return view('accounts::work_orders.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkOrderRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->workOrderInterface->update($request->except("_token"),decrypt($id));
            DB::commit();
            return redirect()->back()->with('success',' Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $response = $this->workOrderInterface->delete($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->workOrderInterface->workOrderForSelect($request->search, $request->branch_id ? $request->branch_id : app('branch_info')['current_branch_id'], $request->sub_ledger_id, $request->page);
        return response()->json($data);
    }

    public function get_row()
    {
        $output = '';
        $output = '<div class="row new_added_row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="Cost Type">Cost Type <span class="text-danger">*</span></label>
                            <select class="form-select cost_account_id" name="cost_type[]" required>
                                <option value="0">Select Cost Type</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="Cost Amount" class="form-label">Cost Amount</label>
                            <input type="number" min="0" step="0.001" class="form-control" name="cost_amounts[]" placeholder="0.00">
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-1 mb-3">
                            <div class="d-block">
                                <label class="form-label" for=""> Action </label>
                                <div>
                                    <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>';
        return response()->json($output);
    }

    public function profit_loss_report(Request $request)
    {
        $branch_id = app('branch_info')['current_branch_id'];
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['prve_date_end'] = null;
        $data['prve_date_from'] = null;
        
        if ($request->work_order_id > 0) {
            $work_order_id = $request->work_order_id > 0 ? $request->work_order_id : null;
            $data['work_order'] = $this->workOrderInterface->findById($work_order_id);
            $data['filtered_branch'] = $data['work_order']->branch;
            $ledgers = Ledger::with(['categories_base_on_transaction:id,parent_id,name,code,type,acc_type,is_cost_center,view_in_bs,view_in_is,level'])->whereIn('branch_id',[0, $branch_id])->get(['id','name','code','branch_id','parent_id','is_cost_center','acc_type','view_in_bs','view_in_is','type','level']);
        
            $data['dateFrom'] = $start_date;
            $data['dateTo'] = $end_date;
            
            $tr_data = array();
            $parent_data = array();
            $first_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_first_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], app('account_configurations')['inc_st_fourth_section'], 'report');
            $data['first_section'] = collect($first_section);
            $second_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_second_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], 0, 'report');
            $data['second_section'] = collect($second_section);
            $third_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_third_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], 0, 'report');
            $data['third_section'] = collect($third_section);
            $fourth_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_fourth_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], 0, 'report');
            $data['fourth_section'] = collect($fourth_section);
            $fifth_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_fifth_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], 0, 'report');
            $data['fifth_section'] = collect($fifth_section);
            $tax_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['inc_st_tax_expenses_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], 0, 'report');
            $data['tax_section'] = collect($tax_section);

            if ($request->has('print')) {
                return view('accounts::reports.work_order_profit_loss.print', $data);
            }
            if ($request->has('note')) {
                return view('accounts::reports.work_order_profit_loss.note_print', $data);
            }
        }
        return view('accounts::reports.work_order_profit_loss.index', $data);
    }

    public function balance_sheet_report(Request $request)
    {
        $branch_id = app('branch_info')['current_branch_id'];
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['prve_date_end'] = null;
        $data['prve_date_from'] = null;
        
        if ($request->work_order_id > 0) {
            $work_order_id = $request->work_order_id > 0 ? $request->work_order_id : null;
            $data['work_order'] = $this->workOrderInterface->findById($work_order_id);
            $data['filtered_branch'] = $data['work_order']->branch;
            $ledgers = Ledger::with(['categories_base_on_transaction:id,parent_id,name,code,type,acc_type,is_cost_center,view_in_bs,view_in_is,level'])->whereIn('branch_id',[0, $branch_id])->whereNotIn('id',[app('account_configurations')['retail_earning_account']])->get(['id','name','code','branch_id','parent_id','is_cost_center','acc_type','view_in_bs','view_in_is','type','level']);
        
            $data['dateFrom'] = $start_date;
            $data['dateTo'] = $end_date;
            
            $tr_data = array();
            $parent_data = array();
            $first_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_first_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], app('account_configurations')['retail_earning_account'], 'report', 'balance_sheet');
            $data['first_section'] = collect($first_section);
            $second_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_second_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], app('account_configurations')['retail_earning_account'], 'report', 'balance_sheet');
            $data['second_section'] = collect($second_section);
            $fifth_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_fifth_section']), $tr_data, $start_date, $end_date, $work_order_id, $data['prve_date_from'], $data['prve_date_end'], app('account_configurations')['retail_earning_account'], 'report', 'balance_sheet');
            $data['fifth_section'] = collect($fifth_section);            

            if ($request->has('print')) {
                return view('accounts::reports.work_order_balance_sheet.print', $data);
            }
            if ($request->has('note')) {
                return view('accounts::reports.work_order_balance_sheet.note_print', $data);
            }
        }
        return view('accounts::reports.work_order_balance_sheet.index', $data);
    }

    protected function getChildrenSummary($accounts, $tr_data, $start_date, $end_date, $work_order_id, $prev_start_date, $prev_end_date, $restricted_account = 0, $report_type, $reportData = null)
    {
        $list_accounts = $reportData == "balance_sheet" ? $accounts->whereNotIn('acc_type',['cash','bank'])->whereNotIn('id',[$restricted_account]) : $accounts->whereNotIn('id',[$restricted_account]);
        foreach ($list_accounts as $key => $child) {
            $amount_till_date = $child->TransactionBalanceAmountBetweenDate($start_date, $end_date, $work_order_id);
            $prev_amount_till_date = 0;
            $children_balance = 0;
            $prev_children_balance = 0;
            $new_data['id'] = $child->id;
            $new_data['name'] = $child->name;
            $new_data['code'] = $child->code;
            $new_data['level'] = $child->level;
            $new_data['view_in_bs'] = $reportData == "balance_sheet" ? $child->view_in_bs : $child->view_in_is;
            $new_data['is_parent'] = count($child->categories_base_on_transaction) > 0 ? "yes" : "no";
            $new_data['children_balance'] = count($child->categories_base_on_transaction) > 0 ? $this->getChildrenBalance($child->categories_base_on_transaction, $children_balance, $start_date, $end_date, $work_order_id, $prev_start_date, $prev_end_date, $report_type, $restricted_account, $reportData) : 0;
            $new_data['amount'] = $amount_till_date;
            array_push($tr_data, $new_data);

            if (count($child->categories_base_on_transaction) > 0) {
                $tr_data = $this->getChildrenSummary($child->categories_base_on_transaction, $tr_data, $start_date, $end_date, $work_order_id, $prev_start_date, $prev_end_date, $restricted_account, $report_type, $reportData);
            }
        }
        return $tr_data;
    }

    protected function getChildrenBalance($accounts, $children_balance, $start_date, $end_date, $work_order_id, $prev_start_date, $prev_end_date, $report_type, $restricted_account = 0, $reportData)
    {
        $list_accounts = $reportData == "balance_sheet" ? $accounts->whereNotIn('acc_type',['cash','bank'])->whereNotIn('id',[$restricted_account]) : $accounts->whereNotIn('id',[$restricted_account]);
        foreach ($list_accounts as $key => $child) {
            $children_balance += $child->TransactionBalanceAmountBetweenDate($start_date, $end_date, $work_order_id);
            if (count($child->categories_base_on_transaction) > 0) {
                $children_balance = $this->getChildrenBalance($child->categories_base_on_transaction, $children_balance, $start_date, $end_date, $work_order_id, $prev_start_date, $prev_end_date, $report_type, $restricted_account, $reportData);
            }          
        }
        return $children_balance;
    }

    public function receive_payment_report(Request $request)
    {
        $branch_id = app('branch_info')['current_branch_id'];
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->work_order_id > 0) {
            $work_order_id = $request->work_order_id > 0 ? $request->work_order_id : null;
            $data['work_order'] = $this->workOrderInterface->findById($work_order_id);
            $data['filtered_branch'] = $data['work_order']->branch;
            $data['accounts'] = Ledger::withOnly(['categories.parent:id,name','categories:id,parent_id,name,code,type'])->whereIn('branch_id',[0, $branch_id])->where('parent_id', 0)->get(['id','parent_id','name','code','type','is_cost_center','acc_type','ac_no']);
            $cash_accounts = Ledger::whereIn('branch_id',[0, $branch_id])->whereIn('acc_type', ['cash'])->get(['id'])->pluck('id');
            $bank_accounts = Ledger::whereIn('branch_id',[0, $branch_id])->whereIn('acc_type', ['bank'])->get(['id'])->pluck('id');
            
            $rcv_transactions = Transaction::whereHas('voucher', function($q) use ($start_date,$end_date,$branch_id,$cash_accounts){
                                    $q->whereIn('type',['rcv','rcv_cash'])->where('is_approve', 1)->where('branch_id', $branch_id)->whereBetween('date',[$start_date,$end_date])->whereHas('transactions', function($query) use($cash_accounts){
                                        $query->whereIn('ledger_id',$cash_accounts);
                                    });
                                })->when($request->work_order_id > 0, function ($q) use ($request) {
                                    return $q->where('work_order_id', $request->work_order_id);
                                })->whereNotIn('ledger_id', $cash_accounts)->get(['id','ledger_id','work_order_id','amount','type','voucher_id','date']);
            $pay_transactions = Transaction::whereHas('voucher', function($q) use ($start_date,$end_date,$branch_id,$cash_accounts){
                                    $q->whereIn('type',['pay','pay_cash'])->where('is_approve', 1)->where('branch_id', $branch_id)->whereBetween('date',[$start_date,$end_date])->whereHas('transactions', function($query) use($cash_accounts){
                                        $query->whereIn('ledger_id',$cash_accounts);
                                    });
                                })->when($request->work_order_id > 0, function ($q) use ($request) {
                                    return $q->where('work_order_id', $request->work_order_id);
                                })->whereNotIn('ledger_id', $cash_accounts)->get(['id','ledger_id','work_order_id','amount','type','voucher_id','date']);
            
            $rcv_bank_transactions = Transaction::whereHas('voucher', function($q) use ($start_date,$end_date,$branch_id,$bank_accounts){
                                    $q->whereIn('type',['rcv_bank'])->where('is_approve', 1)->where('branch_id', $branch_id)->whereBetween('date',[$start_date,$end_date])->whereHas('transactions', function($query) use($bank_accounts){
                                        $query->whereIn('ledger_id',$bank_accounts);
                                    });
                                })->when($request->work_order_id > 0, function ($q) use ($request) {
                                    return $q->where('work_order_id', $request->work_order_id);
                                })->whereNotIn('ledger_id', $bank_accounts)->get(['id','ledger_id','work_order_id','amount','type','voucher_id','date']);
            $pay_bank_transactions = Transaction::whereHas('voucher', function($q) use ($start_date,$end_date,$branch_id,$bank_accounts){
                                    $q->whereIn('type',['pay_bank'])->where('is_approve', 1)->where('branch_id', $branch_id)->whereBetween('date',[$start_date,$end_date])->whereHas('transactions', function($query) use($bank_accounts){
                                        $query->whereIn('ledger_id',$bank_accounts);
                                    });
                                })->when($request->work_order_id > 0, function ($q) use ($request) {
                                    return $q->where('work_order_id', $request->work_order_id);
                                })->whereNotIn('ledger_id', $bank_accounts)->get(['id','ledger_id','work_order_id','amount','type','voucher_id','date']);
            $tr_data = array();
            $parent_data = array();
            foreach ($data['accounts'] as $key => $child) {
                $tr_data = $this->getChildrenForRcvPay($child->categories, $tr_data, $parent_data, $branch_id, $rcv_transactions, $pay_transactions, $rcv_bank_transactions, $pay_bank_transactions);
            }
            $data['transactions'] = collect($tr_data)->unique()->groupBy('parent_name');
        }
        if ($request->has('print') || $request->has('detailParty')) {
            return view('accounts::reports.work_order_receive_payment_report.print', $data);
        }
        return view('accounts::reports.work_order_receive_payment_report.index', $data);
    }

    protected function getChildrenForRcvPay($childrens, $tr_data, $parent_data, $branch_id, $rcv_transactions, $pay_transactions, $rcv_bank_transactions, $pay_bank_transactions)
    {
        foreach ($childrens as $key => $child) {
            $new_data['parent_name'] = $child->parent->name;
            $new_data['name'] = $child->name;
            $new_data['id'] = $child->id;
            $new_data['rcv_balance'] = $rcv_transactions->where('ledger_id', $child->id)->where('type','Cr')->sum('amount');
            $new_data['pay_balance'] = $pay_transactions->where('ledger_id', $child->id)->where('type','Dr')->sum('amount');
            $new_data['rcv_bank_balance'] = $rcv_bank_transactions->where('ledger_id', $child->id)->where('type','Cr')->sum('amount');
            $new_data['pay_bank_balance'] = $pay_bank_transactions->where('ledger_id', $child->id)->where('type','Dr')->sum('amount');
            if ($new_data['rcv_balance'] != 0 || $new_data['pay_balance'] != 0 || $new_data['rcv_bank_balance'] != 0 || $new_data['pay_bank_balance'] != 0) {
                array_push($tr_data, $new_data);
            }
            if (count($child->categories) > 0) {
                $tr_data = $this->getChildrenForRcvPay($child->categories, $tr_data, $parent_data, $branch_id, $rcv_transactions, $pay_transactions, $rcv_bank_transactions, $pay_bank_transactions);
            }
        }
        return $tr_data;
    }
}
