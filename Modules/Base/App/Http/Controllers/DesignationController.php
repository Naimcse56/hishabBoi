<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Base\App\Repository\Eloquents\DesignationRepository;
use DataTables;

class DesignationController extends Controller
{
    private object $designationRepository;

    public function __construct(DesignationRepository $designationRepository)
    {
        $this->designationRepository = $designationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->designationRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('base::designation.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('base::designation.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->designationRepository->create($validated);
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
            $data['item'] = $this->designationRepository->findById(decrypt($id));
            return view('base::designation.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->designationRepository->update(decrypt($id),$validated);
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
            $response = $this->designationRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->designationRepository->listForSelect($request->search);
        return response()->json($data);
    }
}
