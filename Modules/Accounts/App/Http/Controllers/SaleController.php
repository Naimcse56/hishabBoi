<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\SaleRepository;
use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use DataTables;

class SaleController extends Controller
{
    private object $saleRepository;

    public function __construct(SaleRepository $saleRepository,JournalRepositoryInterface $journalRepositoryInterface)
    {
        $this->saleRepository = $saleRepository;
        $this->journalRepositoryInterface = $journalRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->saleRepository->allDataTable([],['*'],['sub_ledger:id,name']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('date', function($row){
                        return showDateFormat($row->date);
                    })
                    ->editColumn('payable_amount', function($row){
                        return currencySymbol($row->payable_amount);
                    })
                    ->addColumn('is_approved', function($row){      
                        return view('accounts::sales.components.is_active', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::sales.components.action', compact('row'));
                    })
                    ->rawColumns(['is_approved','action'])
                    ->make(true);
        }
        return view('accounts::sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['invoice_no'] = $this->saleRepository->invoiceNo();
        return view('accounts::sales.create_view', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->saleRepository->createData($request->except('_token'));
            DB::commit();
            return redirect()->route('sales.show',encrypt($item->id))->with('success', $item->invoice_no.' Added Successfully');
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
            $data['sale'] = $this->saleRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','sale_details']);
            return view('accounts::sales.show', $data);
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
            $data['sale'] = $this->saleRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','sale_details']);
            return view('accounts::sales.print', $data);
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
            $data['sale'] = $this->saleRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','sale_details']);
            return view('accounts::sales.edit_view', $data);
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
            $item = $this->saleRepository->updateData($id, $request->except('_token'));
            DB::commit();
            return redirect()->route('sales.index')->with('success', $item->invoice_no.' Updated Successfully');
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
            $response = $this->saleRepository->deleteById($request->id,null,['sale_details','morphs','refers']);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->saleRepository->listForSelect($request->search,$request->filter_for);
        return response()->json($data);
    }

    public function approve_status(Request $request)
    {
        try {
            DB::beginTransaction();
            $sale = $this->saleRepository->statusApproval($request->id,"Approved");
            $referable_type = get_class($sale);
            $referable_id = $request->id;
            $type = "sales";
            foreach ($sale->sale_details as $i => $sold_product) {
                $credit_amounts[] = $sold_product->total_price;
                $credit_account_id[] = $sold_product->product->selling_ledger_id;
                $credit_partner_id[] = 0;
                $credit_work_order_id[] = $sale->work_order_id;
                $credit_work_order_site_detail_id[] = $sale->work_order_site_id;
                $credit_narration[] = $sale->invoice_no;
            }
            $debit_amounts[] = $sale->payable_amount;
            $debit_account_id[] = $sale->sub_ledger->ledger_id;
            $debit_partner_id[] = $sale->sub_ledger_id;
            $debit_work_order_id[] = $sale->work_order_id;
            $debit_work_order_site_detail_id[] = $sale->work_order_site_id;
            $debit_narration[] = $sale->invoice_no;

            $sales_voucher = $this->journalRepositoryInterface->create([
                'type' => $type,
                'amount'=> $sale->payable_amount,
                'date'=> $sale->date,
                'account_type'=> "others",
                'concern_person'=> $sale->created_by,
                'credit_account_id'=> $credit_account_id,
                'credit_sub_account_id'=> $credit_partner_id,
                'credit_work_order_id'=> $credit_work_order_id,
                'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                'credit_account_amount'=> $credit_amounts,
                'credit_narration'=> $credit_narration,
                'narration_voucher'=> 'Auto generated voucher for '.$sale->invoice_no,
                'pay_or_rcv_type'=> "sales",
                'referable_type'=> $referable_type,
                'referable_id'=> $referable_id,
                'is_invoiced'=> 1,
                'panel'=> 'sales',
                'is_manual_entry'=> 0,
                'credit_period'=> $sale->credit_period,
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
            foreach ($sale->morphs->where('is_approve', 0) as $key => $payment) {
                $total_payment_rcv += $payment->amount;
                $debit_amounts[] = $payment->amount;
                $debit_account_id[] = $payment->ledger_id;
                $debit_partner_id[] = 0;
                $debit_work_order_id[] = $sale->work_order_id;
                $debit_work_order_site_detail_id[] = $sale->work_order_site_id;
                $debit_narration[] = $sale->invoice_no;
                $debit_bank_name[] = $payment->bank_name;
                $debit_bank_ac_name[] = $payment->bank_account_name;
                $debit_check_no[] = $payment->check_no;
                $debit_check_mature_date[] = $payment->check_mature_date;
            }
            
            $credit_amounts[] = $sale->payable_amount;
            $credit_account_id[] = $sale->sub_ledger->ledger_id;
            $credit_partner_id[] = $sale->sub_ledger_id;
            $credit_work_order_id[] = $sale->work_order_id;
            $credit_work_order_site_detail_id[] = $sale->work_order_site_id;
            $credit_narration[] = 'Payment Received for '.$sale->invoice_no;

            $recieve_voucher = $this->journalRepositoryInterface->create([
                'type' => "rcv",
                'amount'=> $total_payment_rcv,
                'date'=> $sale->date,
                'account_type'=> "cash_bank",
                'concern_person'=> $sale->created_by,
                'credit_account_id'=> $credit_account_id,
                'credit_sub_account_id'=> $credit_partner_id,
                'credit_work_order_id'=> $credit_work_order_id,
                'credit_work_order_site_detail_id'=> $credit_work_order_site_detail_id,
                'credit_account_amount'=> $credit_amounts,
                'credit_narration'=> $credit_narration,
                'narration_voucher'=> 'Payment Received for '.$sale->invoice_no,
                'pay_or_rcv_type'=> "rcv",
                'referable_type'=> $referable_type,
                'referable_id'=> $referable_id,
                'is_invoiced'=> 1,
                'panel'=> 'sales',
                'is_manual_entry'=> 0,
                'credit_period'=> $sale->credit_period,
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
            dd($sale->refers);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();dd($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
