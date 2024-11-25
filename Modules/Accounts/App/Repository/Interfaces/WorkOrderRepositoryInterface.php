<?php

namespace Modules\Accounts\App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface WorkOrderRepositoryInterface
{
    // Method Declare here
    public function listForDataTable();
    
    public function create(array $data);

    public function findById(int $id);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function workOrderForSelect($search, $branch_id, $sub_ledger_id, $page);
}
