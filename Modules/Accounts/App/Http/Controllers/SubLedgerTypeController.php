<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Models\SubLedgerType;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Repository\Eloquents\SubLedgerTypeRepository;
use DataTables;
use Carbon\Carbon;

class SubLedgerTypeController extends Controller
{
    private object $subledgertypeRepository;

    public function __construct(SubLedgerTypeRepository $subledgertypeRepository)
    {
        $this->subledgertypeRepository = $subledgertypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->subledgertypeRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('accounts::subledger_type.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active'])
                    ->make(true);
        }
        return view('accounts::subledger_type.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_for' => $request->is_for ? $request->is_for : 0,
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'is_for' => 'nullable|in:0,1,2',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->subledgertypeRepository->create($validated);
            DB::commit();
            if ($request->ajax()) {
                return response()->json(["message" => 'Added Successfully'], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['item'] = $this->subledgertypeRepository->findById(decrypt($id));
            return view('accounts::subledger_type.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->merge([
            'is_for' => $request->is_for ? $request->is_for : 0,
        ]);
        $validated = $request->validate([
            'name' => 'required',
            'is_for' => 'nullable|in:0,1,2',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->subledgertypeRepository->update(decrypt($id),$validated);
            DB::commit();
            return redirect()->back()->with('success', $item->name.' Updated Successfully');
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
            $response = $this->subledgertypeRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->subledgertypeRepository->businessUnitForSelect($request->search,$request->is_for);
        return response()->json($data);
    }
}
