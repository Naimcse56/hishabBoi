<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Models\Ledger;

class TrialBalanceRepository
{
    public function getData($branch_id)
    {
        $leadger_ids = Ledger::whereIn('branch_id',[0, $branch_id])
                                ->whereHas('ledger_balances')
                                ->with(['ledger_balances'])->select('id','name','code','type','ac_no')->get();

        return $leadger_ids;
    }
}
