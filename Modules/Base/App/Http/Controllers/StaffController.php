<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Base\App\Repository\Eloquents\StaffRepository;
use Modules\Accounts\App\Models\SubLedgerType;
use DataTables;

class StaffController extends Controller
{
    private object $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->staffRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('base::staffs.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('base::staffs.index');
    }

    public function create()
    {
        $data['sub_ledger_types'] = SubLedgerType::select('id','name as name')->get();
        return view('base::staffs.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->staffRepository->create($request->except('_token'));
            DB::commit();
            return redirect()->route('staffs.create')->with('success', $item->staff_id.' Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $data['staff'] = $this->staffRepository->findById(decrypt($id));
            $data['sub_ledger_types'] = SubLedgerType::select('id','name as name')->get();
            return view('base::staffs.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $data['staff'] = $this->staffRepository->findById(decrypt($id));
            return view('base::staffs.show', $data);
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
            DB::beginTransaction();
            $item = $this->staffRepository->update(decrypt($id),$request->except('_token'));
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
            $response = $this->staffRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->staffRepository->listForSelect($request->search);
        return response()->json($data);
    }
}
