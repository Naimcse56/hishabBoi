<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\PurchaseRepository;
use DataTables;

class PurchaseController extends Controller
{
    private object $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
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
        return view('accounts::purchases.create_view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->purchaseRepository->createData($request->except('_token'));
            DB::commit();
            return redirect()->route('purchases.print',encrypt($item->id))->with('success', $item->invoice_no.' Added Successfully');
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
            return view('accounts::purchases.edit_view', $data);
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
            $response = $this->purchaseRepository->deleteById($request->id,null,['purchase_details']);
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
}
