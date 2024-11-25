<?php

namespace Modules\Accounts\App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Interfaces\BaseRepositoryInterface;

interface LedgerRepositoryInterface extends BaseRepositoryInterface
{
    // Method Declare here

    public function parentNullAccountList($relational_data = [], $selected_data = ['*']);

    public function transactionalLeadgerForSelect($search, $type, $branch_id, $account_type, $view, $page);

    public function codeChecker($code,$parent_id,$purpose, $id);
}
