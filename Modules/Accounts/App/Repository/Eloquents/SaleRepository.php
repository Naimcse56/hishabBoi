<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\Sale;
use Modules\Accounts\App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class SaleRepository extends BaseRepository
{
    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }

    public function createData(array $data)
    {
        $sale = $this->model::create([
            'sub_ledger_id' => $data['sub_ledger_id'],
            'date' => Carbon::createFromFormat('d/m/Y', $data["date"])->format('Y-m-d'),
            'invoice_no' => $data['invoice_no'],
            'ref_no' => $data['ref_no'],
            'phone' => $data['phone'],
            'total_amount' => $data['total_amount'],
            'payable_amount' => $data['net_amount'],
            'discount_percentage' => $data['discount_amount'],
            'discount_amount' => $data['total_amount'] * $data['discount_amount'] / 100,
            'note' => $data['note'],
            'credit_period' => $data['credit_period'],
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
            'note' => $data['note'],
        ]);
        foreach ($data['qty'] as $key => $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['sale_price_tax'][$key]),
                'per_price' => floatval($data['sale_price'][$key]),
                'total_price' => floatval($data['total_sale_price'][$key]),
            ]);
        }
        return $sale;
    }

    public function updateData($id, array $data)
    {
        $sale = $this->model::find($id);
        $sale->update([
            'sub_ledger_id' => $data['sub_ledger_id'],
            'date' => Carbon::createFromFormat('d/m/Y', $data["date"])->format('Y-m-d'),
            'invoice_no' => $data['invoice_no'],
            'ref_no' => $data['ref_no'],
            'phone' => $data['phone'],
            'total_amount' => $data['total_amount'],
            'payable_amount' => $data['net_amount'],
            'discount_percentage' => $data['discount_amount'],
            'discount_amount' => $data['total_amount'] * $data['discount_amount'] / 100,
            'note' => $data['note'],
            'credit_period' => $data['credit_period'],
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
            'note' => $data['note'],
        ]);
        $sale->sale_details()->delete();
        foreach ($data['qty'] as $key => $item) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['sale_price_tax'][$key]),
                'per_price' => floatval($data['sale_price'][$key]),
                'total_price' => floatval($data['total_sale_price'][$key]),
            ]);
        }
        return $sale;
    }
}
