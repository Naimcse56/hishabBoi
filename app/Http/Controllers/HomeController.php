<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller
{
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
        $data['income_this_year'] = 0;
        $data['expense_this_year'] = 0;
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
        $income_ledgers = Ledger::where('is_active',1)
                        ->where('type',4)
                        ->whereHas('transactions')
                        ->get(['id','name','acc_type','type']);
        foreach ($income_ledgers as $income_ledger) {
            $data['income_this_year'] += $income_ledger->BalanceAmountBetweenDate($current_year->from_date, $date);
        }
        $expense_ledgers = Ledger::where('is_active',1)
                        ->where('type',3)
                        ->whereHas('transactions')
                        ->get(['id','name','acc_type','type']);
        foreach ($expense_ledgers as $expense_ledger) {
            $data['expense_this_year'] += $expense_ledger->BalanceAmountBetweenDate($current_year->from_date, $date);
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

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save the user
        return redirect()->route('profile_edit')->with('success', 'User updated successfully.');
    }
}
