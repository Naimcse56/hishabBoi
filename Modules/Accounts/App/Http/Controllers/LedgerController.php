<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Interfaces\LedgerRepositoryInterface;
use Modules\Accounts\App\Http\Requests\CreateAccountRequest;
use Modules\Accounts\App\Http\Requests\UpdateAccountRequest;
use DataTables;

class LedgerController extends Controller
{
    private object $ledgerInterface;

    public function __construct(LedgerRepositoryInterface $ledgerInterface)
    {
        $this->ledgerInterface = $ledgerInterface;
    }

 public function general_setting()
    {
         return view('accounts::setting.create');
    }
    public function invoice()
    {
         return view('accounts::ledgers.invoice');
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
                    ->editColumn('type', function($row){
                        return $row->TypeName;
                    })
                    ->editColumn('name', function($row){
                        return $row->parent_id > 0 ? $row->parent->name.' -> '. $row->name : $row->name;
                    })
                    ->addColumn('status', function($row){
                        if ($row->is_active == 1) {
                            return '<span class="badge bg-success">Active</span>';
                        } else {
                            return '<span class="badge bg-danger">InActive</span>';
                        }
                    })
                    ->addColumn('amount', function($row){
                        return $row->BalanceAmount >= 0 ? number_format($row->BalanceAmount,2) : '('.number_format(abs($row->BalanceAmount),2).')';
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::ledgers.components.action', compact('row'));
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
            return view('accounts::ledgers.index', $data);
        }
        return view('accounts::ledgers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('accounts::ledgers.create_view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccountRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->ledgerInterface->create($request->validated());
            DB::commit();
            return redirect()->route('ledger.create')->with('success', $item->name.' Added Successfully');
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
            $data['ledger'] = $this->ledgerInterface->findById(decrypt($id));
            return view('accounts::ledgers.show', $data);
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
            $data['ledger'] = $this->ledgerInterface->findById(decrypt($id));
            return view('accounts::ledgers.edit_view', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $id = (int) decrypt($id);
            $item = $this->ledgerInterface->update($id, $request->validated());
            DB::commit();
            return redirect()->route('ledger.index')->with('success', $item->name.' Updated Successfully');
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
            $response = $this->ledgerInterface->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list()
    {
        $data['ChartOfAccountList'] = $this->ledgerInterface->parentNullAccountList();
        return view('accounts::ledgers.page_component.ledger_list', $data);
    }

    public function transactional_list_for_select_ajax(Request $request)
    {
        $data = $this->ledgerInterface->transactionalLeadgerForSelect($request->search, $request->type, $request->account_type, $request->view, $request->page);
        return response()->json($data);
    }

    public function code_checker(Request $request)
    {
        $isExist = $this->ledgerInterface->codeChecker($request->code,$request->parent_id,$request->purpose,$request->s_id);
        if ($request->parent_id) {
            return response()->json(['generated_code' => $isExist]);
        }
        if ($isExist && !$request->purpose) {
            return response()->json(['message' => "Code Already Existing!! Try Another !"]);
        }
        if ($isExist && $request->purpose) {
            $name = "";
            foreach ($isExist as $key => $ac) {
                $name .= $ac->name.'/ ';
            }
            if (count($isExist) > 0) {
                return response()->json(['message' => $name." Already Existing!!"]);
            }
        }
        return response()->json(['success_message' => "Code is valid"]);
    }
}
