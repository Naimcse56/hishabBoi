<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\QuotationRepository;
use Modules\Accounts\App\Repository\Eloquents\SaleRepository;
use DataTables;

class QuotationController extends Controller
{
    private object $quotationRepository;

    public function __construct(SaleRepository $saleRepository, QuotationRepository $quotationRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->quotationRepository = $quotationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->quotationRepository->allDataTable([],['*'],['sub_ledger:id,name']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('date', function($row){
                        return showDateFormat($row->date);
                    })
                    ->editColumn('payable_amount', function($row){
                        return currencySymbol($row->payable_amount);
                    })
                    ->addColumn('is_approved', function($row){      
                        return view('accounts::quotations.components.is_active', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::quotations.components.action', compact('row'));
                    })
                    ->rawColumns(['is_approved','action'])
                    ->make(true);
        }
        return view('accounts::quotations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['invoice_no'] = $this->quotationRepository->invoiceNo();
        return view('accounts::quotations.create_view',$data);
    }

    public function convert_to_sale($id)
    {
        $data['quotation'] = $this->quotationRepository->findById(decrypt($id));
        $data['invoice_no'] = $this->saleRepository->invoiceNo();
        return view('accounts::quotations.convert_to_sale',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->quotationRepository->createData($request->except('_token'));
            DB::commit();
            return redirect()->route('quotations.show',encrypt($item->id))->with('success', $item->invoice_no.' Added Successfully');
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
            $data['quotation'] = $this->quotationRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','quotation_details']);
            return view('accounts::quotations.show', $data);
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
            $data['quotation'] = $this->quotationRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','quotation_details']);
            return view('accounts::quotations.print', $data);
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
            $data['quotation'] = $this->quotationRepository->findById(decrypt($id),['*'],['sub_ledger:id,name','quotation_details']);
            if ($data['quotation']->is_approved != "Approved") {
                return view('accounts::quotations.edit_view', $data);
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
            $item = $this->quotationRepository->updateData($id, $request->except('_token'));
            DB::commit();
            return redirect()->route('quotations.index')->with('success', $item->invoice_no.' Updated Successfully');
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
            $response = $this->quotationRepository->deleteById($request->id,null,['quotation_details']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->quotationRepository->listForSelect($request->search,$request->filter_for);
        return response()->json($data);
    }

    public function approve_status(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->quotationRepository->statusApproval($request->id,"Approved");            
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();dd($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
