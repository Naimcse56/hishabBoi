<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Base\App\Repository\Eloquents\LanguageRepository;
use DataTables;

class LanguageController extends Controller
{
    private object $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->languageRepository->allDataTable();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){      
                        return view('base::languages.components.status', compact('row'));
                    })
                    ->addColumn('rtl', function($row){      
                        return view('base::languages.components.rtl_status', compact('row'));
                    })
                    ->addColumn('action', function($row){      
                        return view('base::languages.components.action', compact('row'));
                    })
                    ->rawColumns(['status','rtl','action'])
                    ->make(true);
        }
        return view('base::languages.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->merge([
                'status' => $request->status ? $request->status : 0,
                'rtl' => $request->rtl ? $request->rtl : 0,
            ]);
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required',
                'status' => 'required|in:0,1',
                'rtl' => 'required|in:0,1',
            ]);
            DB::beginTransaction();
            $item = $this->languageRepository->create($validated);
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
            $data['item'] = $this->languageRepository->findById(decrypt($id));
            return view('base::languages.edit', $data);
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
            $request->merge([
                'status' => $request->status ? $request->status : 0,
                'rtl' => $request->rtl ? $request->rtl : 0,
            ]);
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required',
                'status' => 'required|in:0,1',
                'rtl' => 'required|in:0,1',
            ]);
            DB::beginTransaction();
            $item = $this->languageRepository->update(decrypt($id),$validated);
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
            if ($request->id > 3) {
                $response = $this->languageRepository->deleteById($request->id);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function list_for_select(Request $request)
    {
        $data = $this->languageRepository->listForSelect($request->search);
        return response()->json($data);
    }
}
