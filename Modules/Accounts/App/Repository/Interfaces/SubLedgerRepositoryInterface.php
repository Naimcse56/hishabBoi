<?php

namespace Modules\Accounts\App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repository\Interfaces\BaseRepositoryInterface;

interface SubLedgerRepositoryInterface extends BaseRepositoryInterface
{
    public function transactionalLeadgerForSelect($search, $type, $branch_id, $page);
}
