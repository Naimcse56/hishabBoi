<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\ProductRepository;
use DataTables;

class ProductController extends Controller
{
    private object $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->productRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('accounts::products.components.action', compact('row'));
                    })
                    ->rawColumns(['action','is_active'])
                    ->make(true);
        }
        return view('accounts::products.index');
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
            $item = $this->productRepository->create($validated);
            DB::commit();
            return redirect()->route('products.create')->with('success', $item->name.' Added Successfully');
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
            $data['item'] = $this->productRepository->findById(decrypt($id));
            return view('accounts::products.edit', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data['item'] = $this->productRepository->findById(decrypt($id));
            return view('accounts::products.show', $data);
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
            $item = $this->productRepository->update(decrypt($id),$validated);
            DB::commit();
            return redirect()->route('products.index')->with('success', $item->name.' Updated Successfully');
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
            $response = $this->productRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select_ajax(Request $request)
    {
        $data = $this->productRepository->listForSelect($request->search,$request->status,$request->is_selling,$request->is_purchase,$request->type);
        return response()->json($data);
    }
}
