<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\VouchersRepository;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Carbon\Carbon;
use DataTables;

class VouchersController extends Controller
{
    private object $vouchersRepository;

    public function __construct(VouchersRepository $vouchersRepository)
    {
        $this->vouchersRepository = $vouchersRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function approval_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->vouchersRepository->listForDataTable($request['amount']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" class="form-check-input voucher_ids bg-primary" value="'.$row->id.'" name="ids"/>';
                    })
                    ->addColumn('comment', function ($row) {
                        return '<textarea class="form-control '.$row->id.'_comment" name="rejection_comment" placeholder="Enter Comments" rows="2"></textarea>';
                    })
                    ->editColumn('txn_id', function($row){
                        return $row->date.'<br>'.$row->TypeName;
                    })
                    ->addColumn('details', function($row){
                        return view('accounts::voucher_approval.components.details', compact('row'));
                    })
                    ->addColumn('status', function($row){
                        return view('accounts::voucher_approval.components.status', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::voucher_approval.components.action', compact('row'));
                    })
                    ->rawColumns(['action','checkbox','comment','status','txn_id','details'])
                    ->make(true);
        }
        return view('accounts::voucher_approval.index');
    }

    public function rejected_by_accountant_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->vouchersRepository->listForRejectedVoucherAccountant();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('narration', function($row){
                        $output = "Purpose: ".$row->narration ."<br>";
                        if ($row->type == "pay_bank" || $row->type == "pay_cash" || $row->type == "pay") {
                            $trans = $row->transactions->where('type','Dr');
                            foreach ($trans as $key => $tran) {
                                $output .= "Debit AC: ".$tran->ledger->name ."<br>";
                                if ($tran->sub_ledger_id > 0) {
                                    $output .= "Party: ".$tran->sub_ledger->name ."<br>";
                                }
                            }
                        }
                        if ($row->type == "rcv_bank" || $row->type == "rcv_cash" || $row->type == "rcv") {
                            $trans = $row->transactions->where('type','Cr');
                            foreach ($trans as $key => $tran) {
                                $output .= "Credit AC: ".$tran->ledger->name ."<br>";
                                if ($tran->sub_ledger_id > 0) {
                                    $output .= "Party: ".$tran->sub_ledger->name ."<br>";
                                }
                            }
                        }
                        return $output;
                    })
                    ->editColumn('txn_id', function($row){
                        return $row->TypeName;
                    })
                    ->editColumn('amount', function($row){
                        return currencySymbol( $row->amount );
                    })
                    ->addColumn('status', function($row){
                        return view('accounts::rejected_by_accountant.components.status', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::rejected_by_accountant.components.action', compact('row'));
                    })
                    ->rawColumns(['action','comment','status','narration'])
                    ->make(true);
        }
        return view('accounts::rejected_by_accountant.index');
    }

    public function show($id)
    {
        try {
            $data['journal'] = $this->vouchersRepository->findById(decrypt($id));
            return view('accounts::voucher_approval.show_modal', $data);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->vouchersRepository->delete($request->id);
            if ($response == "done") {
                DB::commit();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function approve_now(Request $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->vouchersRepository->approveStatus($request->id);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function multiple_approve_now(Request $request)
    {
        try {
            foreach ($request->id as $key => $id) {
                DB::beginTransaction();
                    if ($request->approval == "approve") {
                        $response = $this->vouchersRepository->approveStatus($id);
                    } else {
                        $response = $this->vouchersRepository->rejectStatus($id, $request->rejection_comment[$key]);
                    }
                DB::commit();
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
