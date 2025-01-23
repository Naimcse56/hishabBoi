<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller
{
    use FileUploadTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['opening_cash'] = 0;
        $data['rcv_cash'] = 0;
        $data['pay_cash'] = 0;
        $data['closing_cash'] = 0;
        $data['opening_bank'] = 0;
        $data['rcv_bank'] = 0;
        $data['pay_bank'] = 0;
        $data['closing_bank'] = 0;
        $data['closing_payable'] = 0;
        $data['closing_recievable'] = 0;
        
        $payable_id = SubLedger::where('type','Vendor')->pluck('id');
        $recievable_id = SubLedger::where('type','Client')->pluck('id');
        $date = app('day_closing_info')->from_date;
        $current_year = app('current_fiscal_year');
        $ledgers = Ledger::where('is_active',1)
                        ->whereIn('acc_type',['cash','bank'])
                        ->orWhereIn('id',$payable_id)
                        ->orWhereIn('id',$recievable_id)
                        ->get(['id','name','acc_type','type']);
        foreach ($ledgers->where('acc_type','cash') as $key => $ledger) {
            $data['opening_cash'] += $ledger->BalanceAmountTillDate($date);
            $data['rcv_cash'] += $ledger->transactions()->where('date', $date)->where('type', 'Dr')->sum('amount');
            $data['pay_cash'] += $ledger->transactions()->where('date', $date)->where('type', 'Cr')->sum('amount');
            $data['closing_cash'] += $ledger->BalanceAmount;
        }
        foreach ($ledgers->where('acc_type','bank') as $ledger) {
            $data['opening_bank'] += $ledger->BalanceAmountTillDate($date);
            $data['rcv_bank'] += $ledger->transactions()->where('date', $date)->where('type', 'Dr')->sum('amount');
            $data['pay_bank'] += $ledger->transactions()->where('date', $date)->where('type', 'Cr')->sum('amount');
            $data['closing_bank'] += $ledger->BalanceAmount;
        }
        foreach ($ledgers->where('id',$payable_id) as $ledger) {
            $data['closing_payable'] += $ledger->BalanceAmount;
        }
        foreach ($ledgers->where('id',$recievable_id) as $ledger) {
            $data['closing_recievable'] += $ledger->BalanceAmount;
        }

        $startDate = Carbon::parse($current_year->from_date)->startOfMonth();
        $endDate = Carbon::now()->addMonths(12)->endOfMonth();
    
        $income_amounts = DB::table('transactions')
                            ->join('ledgers', 'transactions.ledger_id', '=', 'ledgers.id')
                            ->where('ledgers.type', 4)
                            ->whereBetween('transactions.date', [$startDate, $endDate])
                            ->select(
                                DB::raw('DATE_FORMAT(transactions.date, "%Y-%m") as month'),
                                DB::raw('SUM(CASE WHEN transactions.type = "Cr" THEN transactions.amount ELSE 0 END) - SUM(CASE WHEN transactions.type = "Dr" THEN transactions.amount ELSE 0 END) as income')
                            )
                            ->groupBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))
                            ->orderBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))
                            ->get();
                    
        $expense_amounts =  DB::table('transactions')
                                ->join('ledgers', 'transactions.ledger_id', '=', 'ledgers.id')
                                ->where('ledgers.type', 3)  // Only expense ledgers
                                ->whereBetween('transactions.date', [$startDate, $endDate])  // Date range: last 12 months
                                ->select(
                                    DB::raw('DATE_FORMAT(transactions.date, "%Y-%m") as month'),
                                    DB::raw('SUM(CASE WHEN transactions.type = "Dr" THEN transactions.amount ELSE 0 END) - SUM(CASE WHEN transactions.type = "Cr" THEN transactions.amount ELSE 0 END) as expense')
                                )
                                ->groupBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))  // Group by year-month
                                ->orderBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))  // Order by date
                                ->get();
    
        $asset_amounts = DB::table('transactions')
                            ->join('ledgers', 'transactions.ledger_id', '=', 'ledgers.id')
                            ->where('ledgers.type', 2)
                            ->whereBetween('transactions.date', [$startDate, $endDate])
                            ->select(
                                DB::raw('DATE_FORMAT(transactions.date, "%Y-%m") as month'),
                                DB::raw('SUM(CASE WHEN transactions.type = "Cr" THEN transactions.amount ELSE 0 END) - SUM(CASE WHEN transactions.type = "Dr" THEN transactions.amount ELSE 0 END) as asset')
                            )
                            ->groupBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))
                            ->orderBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))
                            ->get();
                    
        $liability_amounts =  DB::table('transactions')
                                ->join('ledgers', 'transactions.ledger_id', '=', 'ledgers.id')
                                ->where('ledgers.type', 1)  // Only expense ledgers
                                ->whereBetween('transactions.date', [$startDate, $endDate])  // Date range: last 12 months
                                ->select(
                                    DB::raw('DATE_FORMAT(transactions.date, "%Y-%m") as month'),
                                    DB::raw('SUM(CASE WHEN transactions.type = "Dr" THEN transactions.amount ELSE 0 END) - SUM(CASE WHEN transactions.type = "Cr" THEN transactions.amount ELSE 0 END) as liability')
                                )
                                ->groupBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))  // Group by year-month
                                ->orderBy(DB::raw('DATE_FORMAT(transactions.date, "%Y-%m")'))  // Order by date
                                ->get();
        $data['income_expense_array'] = array();
        $data['asset_liability_array'] = array();
        $data['income_chart_array'] = [];
        $data['expense_chart_array'] = [];
        foreach ($income_amounts as $key => $income_amount) {
            $new_detail_data['month'] = $income_amount->month;
            $new_detail_data['income'] = $income_amount->income;
            $new_detail_data['expense'] = $expense_amounts[$key]->expense;
            array_push($data['income_expense_array'], $new_detail_data);
            $data['income_chart_array'][] = [$income_amount->month, $income_amount->income];
            $data['expense_chart_array'][] = [$expense_amounts[$key]->month, $expense_amounts[$key]->expense];
        }
        foreach ($asset_amounts as $key => $asset_amount) {
            $new_data['month'] = $asset_amount->month;
            $new_data['asset'] = $asset_amount->asset;
            $new_data['liability'] = $liability_amounts[$key]->liability;
            array_push($data['asset_liability_array'], $new_data);
        }
        
        return view('home', $data);
    }

    public function profile_edit()
    {
        return view('backend.profiles.profile');
    }

    public function profile_update(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ];

        // Check if password is present
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed'; // Add confirmation rule
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Update user name and username
        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->hasFile('image')) {
            $user->avatar = $this->uploadFile($request->image, 'user-profile-image');
        }
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save the user
        return redirect()->route('profile_edit')->with('success', 'User updated successfully.');
    }
}
