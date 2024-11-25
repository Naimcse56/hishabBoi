<?php

namespace Modules\Accounts\App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SubLedgerRepositoryInterface
{
    // Method Declare here
    public function listForDataTable($type);
    
    public function create(array $data);

    public function findById(int $id);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function transactionalLeadgerForSelect($search, $type, $branch_id, $page);
}
