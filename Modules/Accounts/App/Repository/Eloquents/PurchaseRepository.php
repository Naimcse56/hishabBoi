<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\Purchase;
use Modules\Accounts\App\Models\PurchaseDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class PurchaseRepository extends BaseRepository
{
    public function __construct(Purchase $model)
    {
        parent::__construct($model);
    }

    public function createData(array $data)
    {
        $purchase_order = $this->model::create([
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
            PurchaseDetail::create([
                'purchase_id' => $purchase_order->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['purchase_price_tax'][$key]),
                'per_price' => floatval($data['purchase_price'][$key]),
                'total_price' => floatval($data['total_purchase_price'][$key]),
            ]);
        }
        return $purchase_order;
    }

    public function updateData($id, array $data)
    {
        $purchase_order = $this->model::find($id);
        $purchase_order->update([
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
        $purchase_order->purchase_details()->delete();
        foreach ($data['qty'] as $key => $item) {
            PurchaseDetail::create([
                'purchase_id' => $purchase_order->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['purchase_price_tax'][$key]),
                'per_price' => floatval($data['purchase_price'][$key]),
                'total_price' => floatval($data['total_purchase_price'][$key]),
            ]);
        }
        return $purchase_order;
    }
}
