<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DataTables;

class JournalController extends Controller
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
            $data = $this->journalRepositoryInterface->listForDataTable(['others'],'general_basis');
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
                        return view('accounts::journals.components.action', compact('row'));
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('accounts::journals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts::journals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:1024',
        ]);
        $total_debit_amount = 0;
        $total_credit_amount = 0;
        foreach ($request->debit_amount as $key => $debit_amount) {
            if ($debit_amount > 0) {
                $total_debit_amount += $debit_amount;
                $debit_amounts[] = $debit_amount;
                $debit_account_id[] = $request->account_id[$key];
                $debit_partner_id[] = isset($request->sub_account_id[$key]) ? $request->sub_account_id[$key] : 0;
                $debit_work_order_id[] = 0;
                $debit_narration[] = $request->narration;
            }
        }
        foreach ($request->credit_amount as $m => $credit_amount) {
            if ($credit_amount > 0) {
                $total_credit_amount += $credit_amount;
                $credit_amounts[] = $credit_amount;
                $credit_account_id[] = $request->account_id[$m];
                $credit_partner_id[] = isset($request->sub_account_id[$m]) ? $request->sub_account_id[$m] : 0;
                $credit_work_order_id[] = 0;
                $credit_narration[] = $request->narration;
                if (in_array($request->account_id[$m],$debit_account_id)) {
                    return response()->json(["message_warning" => "Same Account Entered Dr and Cr side"]);
                }
            }
        }
        $is_invoiced = 0;
        $type = "others";
        $referable_type = null;
        $referable_id = 0;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/voucher-attachments'), $filename); // Store in public/uploads
            $path_attachment = '/uploads/voucher-attachments/' . $filename;
        }

        if (number_format($total_debit_amount, 2, '.', '') == number_format($total_credit_amount, 2, '.', '')) {
            try {
                DB::beginTransaction();
                $item = $this->journalRepositoryInterface->create([
                    'type' => $type,
                    'amount'=> $total_debit_amount,
                    'date'=> app('day_closing_info')->from_date,
                    'account_type'=>$request->account_type,
                    'concern_person'=>$request->concern_person,
                    'credit_account_id'=> $credit_account_id,
                    'credit_sub_account_id'=> $credit_partner_id,
                    'credit_work_order_id'=> $credit_work_order_id,
                    'credit_account_amount'=> $credit_amounts,
                    'credit_narration'=> $credit_narration,
                    'narration_voucher'=> $request->narration,
                    'referable_type'=> $referable_type,
                    'referable_id'=> $referable_id,
                    'is_invoiced'=> $is_invoiced,
                    'panel'=> 'general_basis',
                    'is_manual_entry'=> 1,

                    'debit_account_id'=> $debit_account_id,
                    'debit_sub_account_id'=> $debit_partner_id,
                    'debit_work_order_id'=> $debit_work_order_id,
                    'debit_account_amount'=> $debit_amounts,
                    'debit_narration'=> $debit_narration,
                    'is_approve' => 0,
                    'attachment' => $request->hasFile('attachment') ? $path_attachment : null
                ]);
                DB::commit();
                session()->put('voucher_id', route('journal.print',encrypt($item->id)));
                return response()->json([
                                            "message" => "Added Successfully",
                                            "url" => route('journal.create'),
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(["message_error" => $e->getMessage()]);
            }
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data['journal'] = $this->journalRepositoryInterface->findById(decrypt($id));
            return view('accounts::journals.show_modal', $data);
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
            if ($data['journal']->is_approve != 1 && $data['journal']->is_work_order_based == 0) {
                return view('accounts::journals.edit', $data);
            }
            return response()->json(["Message" => "Already Approved."]);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    public function print($id)
    {
        try {
            $data['journal'] = $this->journalRepositoryInterface->findById(decrypt($id));
            return view('accounts::journals.receipt_print', $data);
        } catch (\Exception $e) {
            return response()->json(["message_error" => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:1024',
        ]);
        $total_debit_amount = 0;
        $total_credit_amount = 0;
        foreach ($request->debit_amount as $key => $debit_amount) {
            if ($debit_amount > 0) {
                $total_debit_amount += $debit_amount;
                $debit_amounts[] = $debit_amount;
                $debit_account_id[] = $request->account_id[$key];
                $debit_partner_id[] = isset($request->sub_account_id[$key]) ? $request->sub_account_id[$key] : 0;
                $debit_work_order_id[] = 0;
                $debit_narration[] = $request->narration;
            }
        }
        foreach ($request->credit_amount as $m => $credit_amount) {
            if ($credit_amount > 0) {
                $total_credit_amount += $credit_amount;
                $credit_amounts[] = $credit_amount;
                $credit_account_id[] = $request->account_id[$m];
                $credit_partner_id[] = isset($request->sub_account_id[$m]) ? $request->sub_account_id[$m] : 0;
                $credit_work_order_id[] = 0;
                $credit_narration[] = $request->narration;
                if (in_array($request->account_id[$m],$debit_account_id)) {
                    return response()->json(["message_warning" => "Same Account Entered Dr and Cr side"]);
                }
            }
        }
        
        $is_invoiced = 0;
        $type = "others";
        $referable_type = null;
        $referable_id = 0;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/voucher-attachments'), $filename); // Store in public/uploads
            $path_attachment = '/uploads/voucher-attachments/' . $filename;
        }

        if (number_format($total_debit_amount, 2, '.', '') == number_format($total_credit_amount, 2, '.', '')) {
            try {
                DB::beginTransaction();
                $item = $this->journalRepositoryInterface->update([
                    'type' => $type,
                    'amount'=> $total_debit_amount,
                    'date'=> app('day_closing_info')->from_date,
                    'account_type'=>$request->account_type,
                    'concern_person'=>$request->concern_person,
                    'credit_account_id'=> $credit_account_id,
                    'credit_sub_account_id'=> $credit_partner_id,
                    'credit_work_order_id'=> $credit_work_order_id,
                    'credit_account_amount'=> $credit_amounts,
                    'credit_narration'=> $credit_narration,
                    'narration_voucher'=> $request->narration,
                    'referable_type'=> $referable_type,
                    'referable_id'=> $referable_id,
                    'is_invoiced'=> $is_invoiced,
                    'is_manual_entry'=> 1,

                    'debit_account_id'=> $debit_account_id,
                    'debit_sub_account_id'=> $debit_partner_id,
                    'debit_work_order_id'=> $debit_work_order_id,
                    'debit_account_amount'=> $debit_amounts,
                    'debit_narration'=> $debit_narration,
                    'is_approve' => 0,
                    'attachment' => $request->hasFile('attachment') ? $path_attachment : null
                ], decrypt($id));
                DB::commit();
                session()->put('voucher_id', route('journal.print',encrypt($item->id)));
                return response()->json([
                                            "message" => "Updated Successfully",
                                            "url" => route('journal.create')
                                        ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(["message_error" => $e->getMessage()]);
            }
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
            if ($response == "done") {
                DB::commit();
                return response()->json(['success' => true]);
            }
            return response()->json(['error' => 'Request Data Not Found']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function add_new_line()
    {
        $row_cash_flow = '';
        $output = '';

        $row_count = request()->get('row', 2);

        $output = '<div class="row new_added_row">
                    <div class="col-md-4 mb-3">
                        <select class="form-select account_id" name="account_id[]" required>
                            <option value="0">Select One</option>
                        </select>
                        <span class="text-danger" id="_error"></span>
                    </div>                                   
                    <div class="col-md-3 mb-3">
                        <select class="form-select sub_account_id" name="sub_account_id[]" required>
                            <option value="0">Select One</option>
                        </select>
                        <span class="text-danger" id="_error"></span>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" min="0" step="0.0000001" class="form-control debit_amount" name="debit_amount[]" placeholder="0" value="0" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" min="0" step="0.0000001" class="form-control credit_amount" name="credit_amount[]" placeholder="0" value="0" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-1 mb-3">
                        <div class="d-block">
                            <div>
                                <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div></div>';
        return response()->json($output);
    }
}
