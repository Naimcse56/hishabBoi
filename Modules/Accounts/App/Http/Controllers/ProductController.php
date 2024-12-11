<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Repository\Eloquents\ProductRepository;
use Modules\Accounts\App\Http\Requests\ProductStoreRequest;
use Modules\Accounts\App\Http\Requests\ProductUpdateRequest;
use DataTables;
use App\Traits\FileUploadTrait;

class ProductController extends Controller
{
    use FileUploadTrait;
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
                    ->editColumn('selling_price', function($row){
                        return currencySymbol($row->selling_price);
                    })
                    ->editColumn('purchase_price', function($row){
                        return currencySymbol($row->purchase_price);
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::products.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('accounts::products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('accounts::products.create_view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            // Get the validated data except for the 'image' field
            $validatedData = $request->validated();
            
            // Handle the image file separately if it exists
            if ($request->hasFile('image')) {
                // Add the image path to the validated data
                $validatedData['image'] = $this->uploadFile($request->image, 'product-image');
            }
            $item = $this->productRepository->create($validatedData);
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
            $data['product'] = $this->productRepository->findById(decrypt($id));
            return view('accounts::products.edit_view', $data);
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
            $data['product'] = $this->productRepository->findById(decrypt($id));
            return view('accounts::products.show', $data);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, $id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            // Get the validated data except for the 'image' field
            $validatedData = $request->validated();
            
            // Handle the image file separately if it exists
            if ($request->hasFile('image')) {
                $product = $this->productRepository->findById(decrypt($id));
                // Add the image path to the validated data
                $this->deleteFile($product->image);
                $validatedData['image'] = $this->uploadFile($request->image, 'product-image');
            }
            $item = $this->productRepository->update(decrypt($id),$validatedData);
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
            $response = $this->productRepository->deleteById($request->id,'image');
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
