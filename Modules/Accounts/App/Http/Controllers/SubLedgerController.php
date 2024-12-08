<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Interfaces\SubLedgerRepositoryInterface;
use Modules\Accounts\App\Http\Requests\CreateSubAccountRequest;
use Modules\Accounts\App\Http\Requests\UpdateSubAccountRequest;
use Modules\Accounts\App\Models\SubLedgerType;
use DataTables;

class SubLedgerController extends Controller
{
    private object $subLedgerInterface;

    public function __construct(SubLedgerRepositoryInterface $subLedgerInterface)
    {
        $this->subLedgerInterface = $subLedgerInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->subLedgerInterface->allDataTable([],['*'],['sub_ledger_type']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('balance', function($row){
                        return currencySymbol($row->BalanceAmount);
                    })
                    ->editColumn('email', function($row){
                        return '<a href="mailto:'.$row->email.'">'.$row->email.'</a>';
                    })
                    ->addColumn('is_active', function($row){      
                        return view('accounts::sub_ledgers.components.is_active', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::sub_ledgers.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active','nid','email','trade_licence'])
                    ->make(true);
        }
        return view('accounts::sub_ledgers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['sub_ledger_types'] = SubLedgerType::select('id','name as name')->get();
        return view('accounts::sub_ledgers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSubAccountRequest $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->subLedgerInterface->create($request->validated());
            DB::commit();
            return redirect()->route('sub-ledger.index')->with('success', $request->name.' Added Successfully');
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
            $data['ledger'] = $this->subLedgerInterface->findById(decrypt($id));
            return view('accounts::sub_ledgers.show', $data);
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
            $data['item'] = $this->subLedgerInterface->findById(decrypt($id));
            $data['sub_ledger_types'] = SubLedgerType::select('id','name as name')->get();
            return view('accounts::sub_ledgers.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubAccountRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->subLedgerInterface->update(decrypt($id), $request->validated());
            DB::commit();
            return redirect()->route('sub-ledger.index')->with('success', $request->name.' Updated Successfully');
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
            $response = $this->subLedgerInterface->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function transactional_list_for_select_ajax(Request $request)
    {
        $data = $this->subLedgerInterface->transactionalLeadgerForSelect($request->search,$request->type,$request->page);
        return response()->json($data);
    }
}
