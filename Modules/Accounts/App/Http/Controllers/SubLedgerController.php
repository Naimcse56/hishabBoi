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
use Brian2694\Toastr\Facades\Toastr;
use DataTables;

class SubLedgerController extends Controller
{
    private object $ledgerInterface;

    public function __construct(SubLedgerRepositoryInterface $ledgerInterface)
    {
        $this->ledgerInterface = $ledgerInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ledgerInterface->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('balance', function($row){
                        return currencySymbol($row->BalanceAmount);
                    })
                    ->editColumn('email', function($row){
                        return '<a href="mailto:'.$row->email.'">'.$row->email.'</a>';
                    })
                    ->editColumn('nid', function($row){
                        if ($row->nid) {
                            return '<a href="'.asset($row->nid).'" download="'.str_replace(' ','-',$row->name.'-nid').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->editColumn('trade_licence', function($row){
                        if ($row->trade_licence) {
                            return '<a href="'.asset($row->trade_licence).'" download="'.str_replace(' ','-',$row->name.'-trade-license').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('type', function($row){
                        $type = 'Supplier / Vendor;';
                        return $type;
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
    
    public function customer_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ledgerInterface->listForDataTable('customer');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('balance', function($row){
                        return currencySymbol($row->BalanceAmount);
                    })
                    ->editColumn('email', function($row){
                        return '<a href="mailto:'.$row->email.'">'.$row->email.'</a>';
                    })
                    ->editColumn('nid', function($row){
                        if ($row->nid) {
                            return '<a href="'.asset($row->nid).'" download="'.str_replace(' ','-',$row->name.'-nid').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->editColumn('trade_licence', function($row){
                        if ($row->trade_licence) {
                            return '<a href="'.asset($row->trade_licence).'" download="'.str_replace(' ','-',$row->name.'-trade-license').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('type', function($row){
                        $type = 'Client';
                        return $type;
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
    
    public function member_index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ledgerInterface->listForDataTable('member');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('balance', function($row){
                        return currencySymbol($row->BalanceAmount);
                    })
                    ->editColumn('email', function($row){
                        return '<a href="mailto:'.$row->email.'">'.$row->email.'</a>';
                    })
                    ->editColumn('nid', function($row){
                        if ($row->nid) {
                            return '<a href="'.asset($row->nid).'" download="'.str_replace(' ','-',$row->name.'-nid').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->editColumn('trade_licence', function($row){
                        if ($row->trade_licence) {
                            return '<a href="'.asset($row->trade_licence).'" download="'.str_replace(' ','-',$row->name.'-trade-license').'">Download</a>';
                        } else {
                            return 'N/A';
                        }
                    })
                    ->addColumn('type', function($row){
                        $type = 'Member';
                        return $type;
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
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "name" => "required",
                "code" => "nullable",
                // "code" => ['required', 'max:50', 'unique:sub_ledgers'],
                'type' => 'required|array|min:1',
                "type.*" => "string|in:Customer,Supplier,Member,LandOwner",
                "is_active" => "required|in:0,1",
                'nid' => 'nullable|mimes:jpg,jpeg,png|max:1024',
                'trade_licence' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            ]);
            dd($validated);
            DB::beginTransaction();
            $item = $this->ledgerInterface->create($request->except("_token"));
            DB::commit();
            if ($request->ajax()) {
                return response()->json(["message" => 'Added Successfully'], 200);
            }
            Toastr::success($request->name.' Added Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data['ledger'] = $this->ledgerInterface->findById(decrypt($id));
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
            $data['item'] = $this->ledgerInterface->findById(decrypt($id));
            return view('accounts::sub_ledgers.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required",
                "code" => "nullable",
                'type' => 'required|array|min:1',
                "type.*" => "string|in:Customer,Supplier,Member,LandOwner",
                "is_active" => "required|in:0,1",
                'nid' => 'nullable|mimes:jpg,jpeg,png|max:1024',
                'trade_licence' => 'nullable|mimes:jpg,jpeg,png|max:1024',
            ]);
            dd($validated);
            DB::beginTransaction();
            $item = $this->ledgerInterface->update($request->except("_token"),decrypt($id));
            DB::commit();
            Toastr::success('Updated Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $response = $this->ledgerInterface->delete($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function transactional_list_for_select_ajax(Request $request)
    {
        $data = $this->ledgerInterface->transactionalLeadgerForSelect($request->search,$request->type, $request->branch_id,$request->page);
        return response()->json($data);
    }
}
