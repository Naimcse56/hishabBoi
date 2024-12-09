<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\Voucher;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use Artisan;

class AccountsPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function day_closing_list(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->employee || auth()->id() == 1) {
                $data = DayCloseFiscalYear::with(['creator'])->orderByDesc('id');
            } else {
                abort(404);
            }
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('to_date', function($row){      
                        return $row->to_date ? $row->to_date : "Currently Open";
                    })
                    ->addColumn('action', function($row){      
                        return view('accounts::day_closing.components.action', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('accounts::day_closing.index');
    }
    public function day_closing_check($id)
    {
        $data['ledgers'] = Ledger::whereHas('transactions')->get(['id','name','ac_no']);
        $data['row'] = DayCloseFiscalYear::find(decrypt($id));
        return view('accounts::day_closing.closing', $data);
    }
    public function day_closing_confirm(Request $request)
    {
        try {
            $currentDay = DayCloseFiscalYear::find($request->id);
            $unapproved_voucher = Voucher::where('date',$currentDay->from_date)->where('is_approve', 0)->count();
            if ($unapproved_voucher == 0 && $currentDay->is_closed != 1) {
                DB::beginTransaction();
                $currentDay->update([
                    'to_date' => Carbon::parse($currentDay->from_date)->format('Y-m-d'),
                    'is_closed' => 1,
                    'closed_by' => auth()->user()->id,
                ]);
                DayCloseFiscalYear::create([
                    'from_date'=>Carbon::parse($currentDay->from_date)->addDays(1)->format('Y-m-d'),
                    'fiscal_year_id' => $currentDay->fiscal_year_id
                ]);
                DB::commit();
            
                return response()->json(['success' => true,'message' => 'Closed Successfully and A new Day has been Started for :'.Carbon::now()->addDays(1)->format('Y-m-d')]);
            } else {
                return response()->json(['success' => true,'message' => 'Total '.$unapproved_voucher .' Vouchers are pending for approval. So Day Cannot be Closed now.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function day_closing_current_date(Request $request)
    {
        $day = DayCloseFiscalYear::orderByDesc('id')->first();
        return response()->json(['date' => Carbon::parse($day->from_date)->format('m/d/Y')]);
    }
}
