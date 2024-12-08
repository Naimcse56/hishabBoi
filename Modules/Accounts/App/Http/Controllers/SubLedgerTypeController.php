<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Models\SubLedgerType;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Transaction;
use Modules\Configuration\App\Models\Branch;
use Modules\Accounts\App\Repository\Eloquents\SubLedgerTypeRepository;
use DataTables;
use Carbon\Carbon;

class SubLedgerTypeController extends Controller
{
    private object $subledgertypeRepository;

    public function __construct(SubLedgerTypeRepository $subledgertypeRepository)
    {
        $this->subledgertypeRepository = $subledgertypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->subledgertypeRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('accounts::subledger_type.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active'])
                    ->make(true);
        }
        return view('accounts::subledger_type.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_for' => $request->is_for ? $request->is_for : 0,
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'is_for' => 'nullable|in:0,1,2',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->subledgertypeRepository->create($validated);
            DB::commit();
            if ($request->ajax()) {
                return response()->json(["message" => 'Added Successfully'], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['item'] = $this->subledgertypeRepository->findById(decrypt($id));
            return view('accounts::subledger_type.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->merge([
            'is_for' => $request->is_for ? $request->is_for : 0,
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'is_for' => 'nullable|in:0,1,2',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->subledgertypeRepository->update(decrypt($id),$validated);
            DB::commit();
            return redirect()->back()->with('success', $item->name.' Updated Successfully');
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
            $response = $this->subledgertypeRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->subledgertypeRepository->businessUnitForSelect($request->search,$request->is_for);
        return response()->json($data);
    }

    public function index_report(Request $request)
    {
        $sub_ledger_ids = SubLedger::query();
        $is_for = is_numeric($request->is_for) ? $request->is_for : 0;

        if ($is_for == 1) {
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['account_payable']);
            $data['account_type'] = $ledger->type;
            $party_type = "supplier";
        } elseif ($is_for == 2) {
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['account_recievable']);
            $data['account_type'] = $ledger->type;
            $party_type = "customer";
        } else {
            $default_ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['advance_and_iou_account']);
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['leadger_account_for_employee']);
            $data['account_type'] = $ledger->type;
            $party_type = "member";
        }
        if ($request->type > 0) {
            $sub_ledger_ids = $sub_ledger_ids->whereIn('sub_ledger_type_id',[$request->type]);
            $members = $sub_ledger_ids->where($party_type, '>', 0)->whereIn('sub_ledger_type_id',[$request->type])->with(['transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id,narration,date,is_approve','sub_ledger_type:id,name'])->get(['id','name','sub_ledger_type_id','member','ledger_id']);
        } else {
            $type_ids = SubLedgerType::where('is_for', $is_for)->get()->pluck(['id'])->toArray();
            $sub_ledger_ids = $sub_ledger_ids->whereIn('sub_ledger_type_id',$type_ids);
            $members = $sub_ledger_ids->where($party_type, '>', 0)->whereIn('sub_ledger_type_id',$type_ids)->with(['transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id,narration,date,is_approve','sub_ledger_type:id,name'])->get(['id','name','sub_ledger_type_id','member','ledger_id']);
        }
        if ($request->party_id > 0) {
            $sub_ledger_ids = $sub_ledger_ids->where('id',$request->party_id);
        }
        $sub_ledger_ids = $sub_ledger_ids->get()->pluck(['id'])->toArray();

        if ($request->account_id > 0) {
            $data['filter_ledger'] = \Modules\Accounts\App\Models\Ledger::find($request->account_id,['id','name']);
            $ledger_id = $request->account_id;
        } else {
            $ledger_id = isset($default_ledger) && $default_ledger ? $default_ledger->id : $ledger->id;
        }
        
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        $transactions = array();

        foreach ($members->groupBy('sub_ledger_type_id') as $key => $member) {
            foreach ($member as $mem) {
                $op_data['sub_ledger_type'] = $mem->sub_ledger_type->name;
                $op_data['member_id'] = $mem->id;
                $op_data['name'] = $mem->name;
                $op_data['current_dr'] = $mem->DebitBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id);
                $op_data['current_cr'] = $mem->CreditBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id);
                $op_data['opening_amount'] = $mem->BalanceAmountTillDateByTypeByLedger($start_date, $party_type, $ledger_id);
                array_push($transactions, $op_data);
            }
        }
        $data['transactions'] = collect($transactions)->groupBy('sub_ledger_type');
        if ($request->has('print')) {
            return view('accounts::reports.member_report.print', $data);
        }
        return view('accounts::reports.member_report.index', $data);
    }

    public function index_report_preview (Request $request)
    {
        $sub_ledger_ids = SubLedger::query();
        $is_for = is_numeric($request->is_for) ? $request->is_for : 0;

        if ($is_for == 1) {
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['account_payable']);
            $data['account_type'] = $ledger->type;
            $party_type = "supplier";
        } elseif ($is_for == 2) {
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['account_recievable']);
            $data['account_type'] = $ledger->type;
            $party_type = "customer";
        } else {
            $default_ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['advance_and_iou_account']);
            $ledger = \Modules\Accounts\App\Models\Ledger::find(app('account_configurations')['leadger_account_for_employee']);
            $data['account_type'] = $ledger->type;
            $party_type = "member";
        }
        if ($request->type > 0) {
            $sub_ledger_ids = $sub_ledger_ids->whereIn('sub_ledger_type_id',[$request->type]);
            $members = $sub_ledger_ids->where($party_type, '>', 0)->whereIn('sub_ledger_type_id',[$request->type])->with(['transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id,narration,date,is_approve','sub_ledger_type:id,name'])->get(['id','name','sub_ledger_type_id','member','ledger_id']);
        } else {
            $type_ids = SubLedgerType::where('is_for', $is_for)->get()->pluck(['id'])->toArray();
            $sub_ledger_ids = $sub_ledger_ids->whereIn('sub_ledger_type_id',$type_ids);
            $members = $sub_ledger_ids->where($party_type, '>', 0)->whereIn('sub_ledger_type_id',$type_ids)->with(['transactions:id,voucher_id,sub_ledger_id,type,amount,ledger_id,narration,date,is_approve','sub_ledger_type:id,name'])->get(['id','name','sub_ledger_type_id','member','ledger_id']);
        }
        if ($request->party_id > 0) {
            $sub_ledger_ids = $sub_ledger_ids->where('id',$request->party_id);
        }
        $sub_ledger_ids = $sub_ledger_ids->get()->pluck(['id'])->toArray();

        if ($request->account_id > 0) {
            $data['filter_ledger'] = \Modules\Accounts\App\Models\Ledger::find($request->account_id,['id','name']);
            $ledger_id = $request->account_id;
        } else {
            $ledger_id = isset($default_ledger) && $default_ledger ? $default_ledger->id : $ledger->id;
        }
        
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        $transactions = array();

        foreach ($members->groupBy('sub_ledger_type_id') as $key => $member) {
            foreach ($member as $mem) {
                $op_data['sub_ledger_type'] = $mem->sub_ledger_type->name;
                $op_data['member_id'] = $mem->id;
                $op_data['name'] = $mem->name;
                $op_data['current_dr'] = $mem->DebitBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id) + $mem->NonApprovedDebitBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id);
                $op_data['current_cr'] = $mem->CreditBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id) + $mem->NonApprovedCreditBalanceAmountBetweenDateByLedger($start_date, $end_date, $ledger_id);
                $op_data['opening_amount'] = $mem->BalanceAmountTillDateByTypeByLedger($start_date, $party_type, $ledger_id) + $mem->NonApprovedBalanceAmountTillDateByTypeByLedger($start_date, $party_type, $ledger_id);
                array_push($transactions, $op_data);
            }
        }
        $data['transactions'] = collect($transactions)->groupBy('sub_ledger_type');
        if ($request->has('print')) {
            return view('accounts::reports.member_report.print', $data);
        }
        return view('accounts::preview_reports.member_report.index', $data);
    }
}
