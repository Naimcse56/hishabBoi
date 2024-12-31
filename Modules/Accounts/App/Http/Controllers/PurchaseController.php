<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\PurchaseRepository;
use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use DataTables;

class PurchaseController extends Controller
{
    private object $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository,JournalRepositoryInterface $journalRepositoryInterface)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->journalRepositoryInterface = $journalRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->purchaseRepository->allDataTable([],['*'],['sub_ledger:id,name']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('date', function($row){
                        return showDateFormat($row->date);
                    })
                    ->editColumn('payable_amount', function($row){
                        return currencySymbol($row->payable_amount);
                    })
                    ->addColumn('is_approved', function($row){      
                        return view('accounts::purchases.components.is_active', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::purchases.components.action', compact('row'));
                    })
                    ->rawColumns(['is_approved','action'])
                    ->make(true);
        }
        return view('accounts::purchases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['invoice_no'] = $this->purchaseRepository->invoiceNo();
        return view('accounts::purchases.create_view',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            if (app('general_setting')['purchase_discount_ledger'] == 0 && $request->discount_percentage > 0) {
                return redirect()->back()->with('error', "Set Purchase discount Ledger First!");
            }
            DB::beginTransaction();
            $item = $this->purchaseRepository->createData($request->except('_token'));
            DB::commit();
            return redirect()->route('purchases.show',encrypt($item->id))->with('success', $item->invoice_no.' Added Successfully');
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
            $data['purchase'] = $this->purchaseRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','purchase_details']);
            return view('accounts::purchases.show', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function print($id)
    {
        try {
            $data['purchase'] = $this->purchaseRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','purchase_details']);
            return view('accounts::purchases.print', $data);
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
            $data['purchase'] = $this->purchaseRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','purchase_details']);
            if ($data['purchase']->is_approved != "Approved") {
                return view('accounts::purchases.edit_view', $data);
            }
            return back();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $id = (int) decrypt($id);
            $item = $this->purchaseRepository->updateData($id, $request->except('_token'));
            DB::commit();
            return redirect()->route('purchases.index')->with('success', $item->invoice_no.' Updated Successfully');
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
            $response = $this->purchaseRepository->deleteData($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->purchaseRepository->listForSelect($request->search,$request->filter_for);
        return response()->json($data);
    }

    public function approve_status(Request $request)
    {
        try {
            DB::beginTransaction();
            $purchase = $this->purchaseRepository->statusApproval($request->id,"Approved");
            $referable_type = get_class($purchase);
            $referable_id = $request->id;
            $type = "purchase";
            foreach ($purchase->purchase_details as $i => $sold_product) {
                $credit_amounts[] = $sold_product->total_price;
                $credit_account_id[] = $sold_product->product->purchase_ledger_id;
                $credit_partner_id[] = 0;
                $credit_work_order_id[] = $purchase->work_order_id;
                $credit_work_order_site_detail_id[] = $purchase->work_order_site_id;
                $credit_narration[] = $sold_product->product->name.' Purchased in '.$purchase->invoice_no;
            }
            $debit_amounts[] = $purchase->discount_amount;
            $debit_account_id[] = app('general_setting')['purchase_discount_ledger'];
            $debit_partner_id[] = 0;
            $debit_work_order_id[] = $purchase->work_order_id;
            $debit_work_order_site_detail_id[] = $purchase->work_order_site_id;
            $debit_narration[] = 'Got Discount on invoice '.$purchase->invoice_no;

            $debit_amounts[] = $purchase->payable_amount;
            $debit_account_id[] = $purchase->sub_ledger->ledger_id;
            $debit_partner_id[] = $purchase->sub_ledger_id;
            $debit_work_order_id[] = $purchase->work_order_id;
            $debit_work_order_site_detail_id[] = $purchase->work_order_site_id;
            $debit_narration[] = 'Voucher for invoice'.$purchase->invoice_no;

            $purchases_voucher = $this->journalRepositoryInterface->create([
                'type' => $type,
                'amount'=> $purchase->payable_amount,
                'date'=> $purchase->date,
                'account_type'=> "others",
                'concern_person'=> $purchase->created_by,
                'credit_account_id'=> $credit_account_id,
                'credit_sub_account_id'=> $credit_partner_id,
                'credit_work_order_id'=> $credit_work_order_id,
                'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                'credit_account_amount'=> $credit_amounts,
                'credit_narration'=> $credit_narration,
                'narration_voucher'=> 'Auto generated voucher for '.$purchase->invoice_no,
                'pay_or_rcv_type'=> "purchase",
                'referable_type'=> $referable_type,
                'referable_id'=> $referable_id,
                'is_invoiced'=> 1,
                'panel'=> 'purchase',
                'is_manual_entry'=> 0,
                'credit_period'=> $purchase->credit_period,
                'payment_account_id'=> 0,

                'debit_account_id'=> $debit_account_id,
                'debit_sub_account_id'=> $debit_partner_id,
                'debit_work_order_id'=> $debit_work_order_id,
                'debit_work_order_site_detail_id'=> $debit_work_order_site_detail_id,
                'debit_account_amount'=> $debit_amounts,
                'debit_narration'=> $debit_narration,
                'is_approve' => 1,
                'attachment' => null
            ]);

            if ($purchase->morphs->where('is_approve', 0)->count() > 0) {
                // Reset Arrays for new values entry
                $debit_amounts = [];
                $debit_account_id = [];
                $debit_partner_id = [];
                $debit_work_order_id = [];
                $debit_work_order_site_detail_id = [];
                $debit_narration = [];
                
                $credit_amounts = [];
                $credit_account_id = [];
                $credit_partner_id = [];
                $credit_work_order_id = [];
                $credit_work_order_site_detail_id = [];
                $credit_narration = [];

                $total_payment_rcv = 0;
                foreach ($purchase->morphs->where('is_approve', 0) as $key => $payment) {
                    $total_payment_rcv += $payment->amount;
                    $debit_amounts[] = $payment->amount;
                    $debit_account_id[] = $payment->ledger_id;
                    $debit_partner_id[] = 0;
                    $debit_work_order_id[] = $purchase->work_order_id;
                    $debit_work_order_site_detail_id[] = $purchase->work_order_site_id;
                    $debit_narration[] = $purchase->invoice_no;
                    $debit_bank_name[] = $payment->bank_name;
                    $debit_bank_ac_name[] = $payment->bank_account_name;
                    $debit_check_no[] = $payment->check_no;
                    $debit_check_mature_date[] = $payment->check_mature_date;
                    $payment->update(['is_approve' => 1]);
                }
                
                $credit_amounts[] = $total_payment_rcv;
                $credit_account_id[] = $purchase->sub_ledger->ledger_id;
                $credit_partner_id[] = $purchase->sub_ledger_id;
                $credit_work_order_id[] = $purchase->work_order_id;
                $credit_work_order_site_detail_id[] = $purchase->work_order_site_id;
                $credit_narration[] = 'Payment for '.$purchase->invoice_no;

                $recieve_voucher = $this->journalRepositoryInterface->create([
                    'type' => "pay",
                    'amount'=> $total_payment_rcv,
                    'date'=> $purchase->date,
                    'account_type'=> "cash_bank",
                    'concern_person'=> $purchase->created_by,
                    'credit_account_id'=> $credit_account_id,
                    'credit_sub_account_id'=> $credit_partner_id,
                    'credit_work_order_id'=> $credit_work_order_id,
                    'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                    'credit_account_amount'=> $credit_amounts,
                    'credit_narration'=> $credit_narration,
                    'narration_voucher'=> 'Payment for '.$purchase->invoice_no,
                    'pay_or_rcv_type'=> "pay",
                    'referable_type'=> $referable_type,
                    'referable_id'=> $referable_id,
                    'is_invoiced'=> 1,
                    'panel'=> 'purchase',
                    'is_manual_entry'=> 0,
                    'credit_period'=> $purchase->credit_period,
                    'payment_account_id'=> 0,

                    'debit_account_id'=> $debit_account_id,
                    'debit_sub_account_id'=> $debit_partner_id,
                    'debit_work_order_id'=> $debit_work_order_id,
                    'debit_work_order_site_detail_id'=> $debit_work_order_site_detail_id,
                    'debit_account_amount'=> $debit_amounts,
                    'debit_narration'=> $debit_narration,
                    'is_approve' => 1,
                    'attachment' => null
                ]);
                if ($purchase->morphs->where('is_approve', 1)->sum('amount') >= $purchase->payable_amount) {
                    $purchase->update(['payment_status' => 'Paid']);
                }
            }
            
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();dd($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
