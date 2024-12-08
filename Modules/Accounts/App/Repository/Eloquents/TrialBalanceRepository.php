<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Models\Ledger;

class TrialBalanceRepository
{
    public function getData()
    {
        $leadger_ids = Ledger::whereHas('ledger_balances')
                                ->with(['ledger_balances'])->select('id','name','code','type','ac_no')->get();

        return $leadger_ids;
    }
}
