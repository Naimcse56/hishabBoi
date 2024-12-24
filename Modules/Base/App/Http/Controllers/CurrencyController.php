<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Base\App\Repository\Eloquents\CurrencyRepository;
use DataTables;

class CurrencyController extends Controller
{
    private object $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->currencyRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){      
                        return view('base::currencies.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('base::currencies.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'symbol' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->currencyRepository->create($validated);
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
            $data['item'] = $this->currencyRepository->findById(decrypt($id));
            return view('base::currencies.edit', $data);
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
            'code' => 'required|string',
            'symbol' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            $item = $this->currencyRepository->update(decrypt($id),$validated);
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
            $response = $this->currencyRepository->deleteById($request->id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->currencyRepository->listForSelect($request->search);
        return response()->json($data);
    }
}
