<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\Sale;
use Modules\Accounts\App\Models\SaleDetail;
use Modules\Accounts\App\Models\Payment;
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
            'terms_condition' => $data['terms_condition'],
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
        if (!empty($data['credit_account_id']) && $data['credit_account_id'] > 0 && $data['payment_amount'] > 0) {
            Payment::create([
                'date' => $sale->date,
                'morphable_type' => get_class($sale),
                'morphable_id' => $sale->id,
                'amount' => $data['payment_amount'],
                'ledger_id' => $data['credit_account_id'],
                'bank_name' => $data['bank_name'],
                'bank_account_name' => $data['bank_account_name'],
                'check_no' => $data['check_no'],
                'check_mature_date' => Carbon::createFromFormat('d/m/Y', $data["check_mature_date"])->format('Y-m-d'),
                'mac_address' => exec('getmac'),
                'ip' => \Request::ip(),
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
            'terms_condition' => $data['terms_condition'],
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
        if ($sale->latestPaymentInfo("asc")) {
            $sale->latestPaymentInfo("asc")->delete();
        }
        if (!empty($data['credit_account_id']) && $data['credit_account_id'] > 0 && $data['payment_amount'] > 0) {
            Payment::create([
                'date' => $sale->date,
                'morphable_type' => get_class($sale),
                'morphable_id' => $sale->id,
                'amount' => $data['payment_amount'],
                'ledger_id' => $data['credit_account_id'],
                'bank_name' => $data['bank_name'],
                'bank_account_name' => $data['bank_account_name'],
                'check_no' => $data['check_no'],
                'check_mature_date' => Carbon::createFromFormat('d/m/Y', $data["check_mature_date"])->format('Y-m-d'),
                'mac_address' => exec('getmac'),
                'ip' => \Request::ip(),
            ]);
        }
        return $sale;
    }

    public function listForSelect($search, $filter_for = null)
    {
        $items = $this->model::query();
        if ($search != '') {
            $items = $items->whereLike(['invoice_no','phone'], $search);
        }
        if ($filter_for == "recieve") {
            $items = $items->where('payment_status','!=' , 'Paid');
        }
        $items = $items->paginate(10);
        $response = [];
        foreach($items as $item){
            if ($filter_for == "recieve") {
                $response[]  =[
                    'id'    => $item->id,
                    'text'  => $item->invoice_no." : ".currencySymbol($item->DueBill)
                ];
            } else {
                $response[]  =[
                    'id'    => $item->id,
                    'text'  => $item->invoice_no
                ];
            }
            
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }
}
