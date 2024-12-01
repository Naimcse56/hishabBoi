<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\WorkOrderSiteRepository;
use Modules\Accounts\App\Http\Requests\WorkOrderSitetRequest;
use DataTables;

class WorkOrderSiteController extends Controller
{
    private object $workOrderInterface;

    public function __construct(WorkOrderSiteRepository $workOrderInterface)
    {
        $this->workOrderInterface = $workOrderInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->workOrderInterface->allDataTable([],['*'],['work_order']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('est_budget', function($row){      
                        return currencySymbol($row->est_budget);
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::work_order_sites.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('accounts::work_order_sites.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts::work_order_sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkOrderSitetRequest $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->workOrderInterface->create($request->validated());
            DB::commit();
            return redirect()->route('work-order-sites.index')->with('success',' Added Successfully');
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
            $data['item'] = $this->workOrderInterface->findById(decrypt($id));
            return view('accounts::work_order_sites.show', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['item'] = $this->workOrderInterface->findById(decrypt($id));
            return view('accounts::work_order_sites.edit', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkOrderSitetRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $item = $this->workOrderInterface->update(decrypt($id), $request->validated());
            DB::commit();
            return redirect()->route('work-order-sites.index')->with('success',' Updated Successfully');
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
            $response = $this->workOrderInterface->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->workOrderInterface->workOrderSitesForSelect($request->search, $request->work_order_id, $request->page);
        return response()->json($data);
    }
}
