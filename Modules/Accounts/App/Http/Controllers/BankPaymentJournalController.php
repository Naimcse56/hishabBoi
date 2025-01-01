<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\Purchase;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DataTables;

class BankPaymentJournalController extends Controller
{
    private object $journalRepositoryInterface;

    public function __construct(JournalRepositoryInterface $journalRepositoryInterface)
    {
        $this->journalRepositoryInterface = $journalRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->journalRepositoryInterface->listForDataTable(['pay_bank'],'bank_payment_multiple');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('txn_id', function($row){
                        return $row->TypeName;
                    })
                    ->editColumn('amount', function($row){
                        return currencySymbol( $row->amount );
                    })
                    ->addColumn('status', function($row){
                        return view('accounts::voucher_approval.components.status', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::bank_payment_multiple.components.action', compact('row'));
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('accounts::bank_payment_multiple.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts::bank_payment_multiple.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $is_invoiced = 0;
        $total_debit_amount = 0;
        $referable_type = $request->purchase_id > 0 ? get_class(new Purchase) : null;
        $referable_id = $request->purchase_id > 0 ? $request->purchase_id : 0;
        $payment_account_id = $request->sale_id > 0 ? $request->credit_account_id[0] : 0;
        foreach ($request->credit_amount as $key => $credit_amount) {
            $total_debit_amount += $credit_amount;
            if ($credit_amount > 0 && $request->credit_account_id[$key] > 0 && $request->debit_account_id[$key] > 0) {
                $credit_amounts[] = $request->credit_amount[$key];
                $credit_account_id[] = $request->credit_account_id[$key];
                $credit_partner_id[] = isset($request->credit_sub_account_id[$key]) ? $request->credit_sub_account_id[$key] : 0;
                $credit_work_order_id[] = isset($request->work_order_id[$key]) ? $request->work_order_id[$key] : 0;
                $credit_work_order_site_detail_id[] = isset($request->work_order_site_detail_id[$key]) ? $request->work_order_site_detail_id[$key] : 0;
                $credit_narration[] = isset($request->credit_narration[$key]) ? $request->credit_narration[$key] : null;
                $credit_bank_name[] = isset($request->bank_name[$key]) ? $request->bank_name[$key] : null;
                $credit_bank_ac_name[] = isset($request->bank_account_name[$key]) ? $request->bank_account_name[$key] : null;
                $credit_check_no[] = isset($request->check_no[$key]) ? $request->check_no[$key] : null;
                $credit_check_mature_date[] = isset($request->check_mature_date[$key]) && $request->check_mature_date[$key] ? Carbon::createFromFormat('d/m/Y', $request->check_mature_date[$key])->format('Y-m-d') : null;
                

                $debit_amounts[] = $credit_amount;
                $debit_account_id[] = $request->debit_account_id[$key];
                $debit_partner_id[] = isset($request->debit_sub_account_id[$key]) ? $request->debit_sub_account_id[$key] : 0;
                $debit_work_order_id[] = isset($request->work_order_id[$key]) ? $request->work_order_id[$key] : 0;
                $debit_work_order_site_detail_id[] = isset($request->work_order_site_detail_id[$key]) ? $request->work_order_site_detail_id[$key] : 0;
                $debit_narration[] = isset($request->credit_narration[$key]) ? $request->credit_narration[$key] : null;
                $debit_bank_name[] = null;
                $debit_bank_ac_name[] = null;
                $debit_check_no[] = null;
                $debit_check_mature_date[] = null;
            }
        }
        $total_amount = $total_debit_amount;
        $type = "pay_bank";
        
        try {
            DB::beginTransaction();
            $item = $this->journalRepositoryInterface->create([
                'type' => $type,
                'amount'=> $total_amount,
                'date'=> app('day_closing_info')->from_date,
                'account_type'=>$request->account_type,
                'concern_person'=>$request->concern_person,
                'credit_account_id'=> $credit_account_id,
                'credit_sub_account_id'=> $credit_partner_id,
                'credit_work_order_id'=> $credit_work_order_id,
                'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                'credit_account_amount'=> $credit_amounts,
                'credit_narration'=> $credit_narration,
                'narration_voucher'=> $request->narration,
                'credit_period'=> $request->credit_period,
                'credit_bank_name'=> $credit_bank_name,
                'credit_bank_ac_name'=> $credit_bank_ac_name,
                'credit_check_no'=> $credit_check_no,
                'credit_check_mature_date'=> $credit_check_mature_date,
                'pay_or_rcv_type'=> $request->pay_or_rcv_type,
                'referable_type'=> $referable_type,
                'referable_id'=> $referable_id,
                'is_invoiced'=> $is_invoiced,
                'panel'=> 'bank_payment_multiple',
                'is_manual_entry'=> 1,
                'payment_account_id'=> $payment_account_id,

                'debit_account_id'=> $debit_account_id,
                'debit_sub_account_id'=> $debit_partner_id,
                'debit_work_order_id'=> $debit_work_order_id,
                'debit_work_order_site_detail_id'=> $debit_work_order_site_detail_id,
                'debit_account_amount'=> $debit_amounts,
                'debit_narration'=> $debit_narration,
                'debit_bank_name'=> $debit_bank_name,
                'debit_bank_ac_name'=> $debit_bank_ac_name,
                'debit_check_no'=> $debit_check_no,
                'debit_check_mature_date'=> $debit_check_mature_date,
                'is_approve' => 0,
                'attachment' => $request->hasFile('attachment') ? $path_attachment : null
            ]);
            DB::commit();
            session()->put('voucher_id',route('multi-bank-payment.print',encrypt($item->id)));
            return redirect()->back()->with('success', 'Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data['journal'] = $this->journalRepositoryInterface->findById(decrypt($id));
            return view('accounts::bank_payment_multiple.show_modal', $data);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['journal'] = $this->journalRepositoryInterface->findById(decrypt($id));
            $data['transactions'] = collect($this->getDataFormat($data['journal']->transactions));
            
            if ($data['journal']->is_approve != 1 && $data['journal']->is_work_order_based == 0) {
                return view('accounts::bank_payment_multiple.edit', $data);
            }
            return response()->json(["Message" => "Already Approved."]);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    private function getDataFormat($transactions)
    {
        $tr_data = array();
        foreach ($transactions->where('type','Dr') as $key => $transaction) {
            $new_data['dr_account_id'] = $transaction->ledger_id;
            $new_data['dr_account_name'] = $transaction->ledger->name;
            $new_data['dr_account_code'] = $transaction->ledger->code;
            $new_data['dr_party_account_id'] = $transaction->sub_ledger_id;
            $new_data['dr_party_account_name'] = $transaction->sub_ledger_id > 0 ? $transaction->sub_ledger->name : 'Select One';
            $new_data['amount'] = $transaction->amount;
            $new_data['dr_narration'] = $transaction->narration;
            $new_data['work_order_id'] = $transaction->work_order_id;
            $new_data['work_order_name'] = $transaction->work_order_id > 0 ? '('.$transaction->work_order->order_no.') '.$transaction->work_order->order_name : 'Select One';
            $new_data['work_order_site_id'] = $transaction->work_order_site_id;
            $new_data['work_order_site_name'] = $transaction->work_order_site_id > 0 ? $transaction->work_order_site_detail->site_name : 'Select One';
            $new_data['cr_account_id'] = 0;
            $new_data['cr_account_name'] = null;
            $new_data['cr_account_code'] = null;
            $new_data['cr_party_account_id'] = 0;
            $new_data['cr_party_account_name'] = null;
            $new_data['bank_name'] = null;
            $new_data['bank_account_name'] = null;
            $new_data['check_no'] = null;
            $new_data['check_mature_date'] = null;
            
            array_push($tr_data, $new_data);
        }
        $i = 0;
        foreach ($transactions->where('type','Cr') as $m => $credit) {
            $tr_data[$i]['cr_account_id'] = $credit->ledger->id;
            $tr_data[$i]['cr_account_name'] = $credit->ledger->name;
            $tr_data[$i]['cr_account_code'] = $credit->ledger->code;
            $tr_data[$i]['cr_party_account_id'] =  $credit->sub_ledger_id;
            $tr_data[$i]['cr_party_account_name'] = $credit->sub_ledger_id > 0 ? $credit->sub_ledger->name : 'Select One';
            $tr_data[$i]['bank_name'] = $credit->bank_name;
            $tr_data[$i]['bank_account_name'] = $credit->bank_account_name;
            $tr_data[$i]['check_no'] = $credit->check_no;
            $tr_data[$i]['check_mature_date'] = $credit->check_mature_date;
            $i = $i + 1;
        }
        return $tr_data;
    }

    public function print($id)
    {
        try {
            $data['journal'] = $this->journalRepositoryInterface->findById(decrypt($id));
            return view('accounts::bank_payment_multiple.receipt_print', $data);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $is_invoiced = 0;
        $total_debit_amount = 0;
        $referable_type = $request->purchase_id > 0 ? get_class(new Purchase) : null;
        $referable_id = $request->purchase_id > 0 ? $request->purchase_id : 0;
        $payment_account_id = $request->sale_id > 0 ? $request->credit_account_id[0] : 0;
        foreach ($request->credit_amount as $key => $credit_amount) {
            $total_debit_amount += $credit_amount;
            if ($credit_amount > 0 && $request->credit_account_id[$key] > 0 && $request->debit_account_id[$key] > 0) {
                $credit_amounts[] = $request->credit_amount[$key];
                $credit_account_id[] = $request->credit_account_id[$key];
                $credit_partner_id[] = isset($request->credit_sub_account_id[$key]) ? $request->credit_sub_account_id[$key] : 0;
                $credit_work_order_id[] = isset($request->work_order_id[$key]) ? $request->work_order_id[$key] : 0;
                $credit_work_order_site_detail_id[] = isset($request->work_order_site_detail_id[$key]) ? $request->work_order_site_detail_id[$key] : 0;
                $credit_narration[] = isset($request->credit_narration[$key]) ? $request->credit_narration[$key] : null;
                $credit_bank_name[] = isset($request->bank_name[$key]) ? $request->bank_name[$key] : null;
                $credit_bank_ac_name[] = isset($request->bank_account_name[$key]) ? $request->bank_account_name[$key] : null;
                $credit_check_no[] = isset($request->check_no[$key]) ? $request->check_no[$key] : null;
                $credit_check_mature_date[] = isset($request->check_mature_date[$key]) && $request->check_mature_date[$key] ? Carbon::createFromFormat('d/m/Y', $request->check_mature_date[$key])->format('Y-m-d') : null;
                

                $debit_amounts[] = $credit_amount;
                $debit_account_id[] = $request->debit_account_id[$key];
                $debit_partner_id[] = isset($request->debit_sub_account_id[$key]) ? $request->debit_sub_account_id[$key] : 0;
                $debit_work_order_id[] = isset($request->work_order_id[$key]) ? $request->work_order_id[$key] : 0;
                $debit_work_order_site_detail_id[] = isset($request->work_order_site_detail_id[$key]) ? $request->work_order_site_detail_id[$key] : 0;
                $debit_narration[] = isset($request->credit_narration[$key]) ? $request->credit_narration[$key] : null;
                $debit_bank_name[] = null;
                $debit_bank_ac_name[] = null;
                $debit_check_no[] = null;
                $debit_check_mature_date[] = null;
            }
        }

        $total_amount = $total_debit_amount;
        $type = "pay_bank";
        try {
            DB::beginTransaction();
            $item = $this->journalRepositoryInterface->update([
                'type' => $type,
                'amount'=> $total_amount,
                'date'=> app('day_closing_info')->from_date,
                'account_type'=>$request->account_type,
                'concern_person'=>$request->concern_person,
                'credit_account_id'=> $credit_account_id,
                'credit_sub_account_id'=> $credit_partner_id,
                'credit_work_order_id'=> $credit_work_order_id,
                'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                'credit_account_amount'=> $credit_amounts,
                'credit_narration'=> $credit_narration,
                'credit_bank_name'=> $credit_bank_name,
                'credit_bank_ac_name'=> $credit_bank_ac_name,
                'credit_check_no'=> $credit_check_no,
                'credit_check_mature_date'=> $credit_check_mature_date,
                'narration_voucher'=> $request->narration,
                'pay_or_rcv_type'=> $request->pay_or_rcv_type,
                'referable_type'=> $referable_type,
                'referable_id'=> $referable_id,
                'is_invoiced'=> $is_invoiced,
                'is_manual_entry'=> 1,
                'credit_period'=> $request->credit_period,
                'payment_account_id'=> $payment_account_id,

                'debit_account_id'=> $debit_account_id,
                'debit_sub_account_id'=> $debit_partner_id,
                'debit_work_order_id'=> $debit_work_order_id,
                'debit_work_order_site_detail_id'=> $debit_work_order_site_detail_id,
                'debit_account_amount'=> $debit_amounts,
                'debit_narration'=> $debit_narration,
                'debit_bank_name'=> $debit_bank_name,
                'debit_bank_ac_name'=> $debit_bank_ac_name,
                'debit_check_no'=> $debit_check_no,
                'debit_check_mature_date'=> $debit_check_mature_date,
                'is_approve' => 0,
                'attachment' => $request->hasFile('attachment') ? $path_attachment : null
            ], decrypt($id));
            DB::commit();
            session()->put('voucher_id',route('multi-bank-payment.print',encrypt($item->id)));
            return redirect()->route('multi-bank-payment.index')->with('success', 'Updated Successfully');
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
            DB::beginTransaction();
            $response = $this->journalRepositoryInterface->delete($request->id);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function add_new_line_cr()
    {
        $output = '';
        $output =   '<div class="row new_added_row_cr">                                    
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="">Credit Accounts <span class="text-danger">*</span></label>
                                    <select class="form-select credit_account_id" name="credit_account_id[]" required>
                                        <option value="0">Select One</option>
                                    </select>
                                    <span class="text-danger" id="_error"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Party Accounts (Cr)</label>
                                    <select class="form-select credit_sub_account_id" name="credit_sub_account_id[]" required>
                                        <option value="0">Select One</option>
                                    </select>
                                    <span class="text-danger" id="credit_sub_account_id_error"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Narration" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" min="0" step="0.0000001" class="form-control credit_amount" name="credit_amount[]" placeholder="0" value="0" required>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="Debit Account">Debit Account <span class="text-danger">*</span></label>
                                    <select class="form-select debit_account_id" name="debit_account_id[]" required>
                                        <option value="0" selected>Select Debit Account</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="">Party Account (Dr)</label>
                                    <select class="form-select credit_sub_account_id" name="debit_sub_account_id[]" required>
                                        <option value="0">Select One</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 work_order_div">
                                    <label class="form-label">Work Order <span class="text-danger">*</span></label>
                                    <select class="form-select work_order_id" name="work_order_id[]" required>
                                        <option value="0">Select One</option>
                                    </select>
                                    <span class="text-danger" id="work_order_id_error"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Work Order Site <span class="text-danger">(optional)</span></label>
                                    <select class="form-select work_order_site_detail_id" name="work_order_site_detail_id[]">
                                        <option value="0">Select One</option>
                                    </select>
                                    <span class="text-danger" id="work_order_site_detail_id_error"></span>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label class="form-label" for=""> Action </label>
                                    <div>
                                        <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row_cr"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <fieldset class="the-fieldset mt-2">
                                        <legend class="the-legend">Bank Information (optional)</legend>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label for="bank_name" class="form-label">Bank Name <span class="text-danger"> </span></label>
                                                <input id="bank_name" name="bank_name[]" placeholder="Bank Name" value="" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="bank_account_name" class="form-label">Bank Account Name <span class="text-danger"> </span></label>
                                                <input id="bank_account_name" name="bank_account_name[]" placeholder="Bank Account Name" value="" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label for="check_no" class="form-label">Cheque No <span class="text-danger"> </span></label>
                                                <input id="check_no" name="check_no[]" placeholder="Cheque No" value="" type="text" class="form-control">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-label">Check Maturity Date <span class="text-danger"> </span></label>
                                                <input name="check_mature_date[]" placeholder="dd/mm/yyyy" type="text" class="form-control datepicker flatpickr-input" value="28/11/2024">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="Narration" class="form-label">Narration</label>
                                    <textarea class="form-control" name="credit_narration[]" placeholder="Narration ..." rows="8"></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div><hr>
                    </div>';
        return response()->json($output);
    }
}
