<?php

namespace Modules\Accounts\App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface JournalRepositoryInterface
{
    // Method Declare here
    public function listForDataTable($type, $panel);

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function findById(int $id);
}
