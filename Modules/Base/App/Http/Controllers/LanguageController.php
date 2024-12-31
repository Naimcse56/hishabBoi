<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
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

    public function translate_view($id)
    {
        try {
            $language = $this->languageRepository->findById($id);
            session()->put('locale', $language->code);
            $lang = 'default';
            $files   = glob(resource_path('lang/' . $lang . '/*.php'));

            $modules = \Module::all();
            foreach ($modules as $module) {
                if ($module->isEnabled()) {
                    $file = glob(module_path($module->getName()) . '/Resources/lang/'.$lang.'/*.php');
                    if ($file) {
                        $files[$module->getLowerName()] = $file;
                    };
                }
            }
            return view('base::languages.translate_file_choose', [
                "files" => $files, 'language' => $language
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function get_translate_file($file_name,$language_id)
    {
        try{
            $language = $this->languageRepository->findById($language_id);

            $languages = Lang::get($file_name);

            $check_module = explode('::', $file_name);

            if (count($check_module) > 1) {
               $translatable_file_name = $check_module[1].'.php';
               $folder = module_path(ucfirst($check_module[0])).'/Resources/lang/'.$language->code.'/';
               $default_folder = module_path(ucfirst($check_module[0])).'/Resources/lang/default/';
            } else{
                $translatable_file_name = $file_name.'.php';
                $folder = resource_path('lang/' . $language->code.'/');
                $default_folder = resource_path('lang/default/');
            }


            $file = $folder . $translatable_file_name;
            $default_file = $default_folder .$translatable_file_name;

            if(file_exists($file))
            {
                $languages = include  "{$file}";

                return view('base::languages.translate_view', [
                    "languages" => $languages,
                    "language" => $language,
                    "translatable_file_name" => $file_name
                ]);
            }


            if (!file_exists($folder)) {
                mkdir($folder);
            }

            if (!file_exists($file)) {
                copy($default_file, $file);
            }

            return view('base::languages.translate_view', [
                "languages" => $languages,
                "language" => $language,
                "translatable_file_name" => $file_name
            ]);
        }catch (\Exception $e) {
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $validate_rules = [
            'id' => 'required',
            'translatable_file_name' => 'required',
            'key' => 'required',
        ];

        try{
            $language = $this->languageRepository->findById($request->id);

            $file_name = $request->translatable_file_name;

            $check_module = explode('::', $file_name);

            if (count($check_module) > 1) {
               $translatable_file_name = $check_module[1].'.php';
               $folder = module_path(ucfirst($check_module[0])).'/Resources/lang/'.$language->code.'/';
            } else{
                $translatable_file_name = $request->translatable_file_name.'.php';
                $folder = resource_path('lang/' . $language->code.'/');
            }

            $file = $folder . $translatable_file_name;

            if (!file_exists($folder)) {
                mkdir($folder);
            }
            if (file_exists($file)) {
                file_put_contents($file, '');
            }

            file_put_contents($file, '<?php return ' . var_export($request->key, true) . ';');
            return back()->with('success', ' Added Successfully');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
