<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\ProductUnitRepository;
use DataTables;

class ProductUnitController extends Controller
{
    private object $productUnitRepository;

    public function __construct(ProductUnitRepository $productUnitRepository)
    {
        $this->productUnitRepository = $productUnitRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->productUnitRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('accounts::product_units.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active'])
                    ->make(true);
        }
        return view('accounts::product_units.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $item = $this->productUnitRepository->create($validated);
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
            $data['item'] = $this->productUnitRepository->findById(decrypt($id));
            return view('accounts::product_units.edit', $data);
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
            'name' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->productUnitRepository->update(decrypt($id),$validated);
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
            $response = $this->productUnitRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->productUnitRepository->listForSelect($request->search);
        return response()->json($data);
    }
}
