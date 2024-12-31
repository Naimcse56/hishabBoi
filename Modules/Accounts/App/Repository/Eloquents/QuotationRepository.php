<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use App\Repository\Eloquents\BaseRepository;
use Modules\Accounts\App\Models\Quotation;
use Modules\Accounts\App\Models\QuotationDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class QuotationRepository extends BaseRepository
{
    public function __construct(Quotation $model)
    {
        parent::__construct($model);
    }

    public function createData(array $data)
    {
        $quotation = $this->model::create([
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
            'terms_condition' => $data['terms_condition'],
        ]);
        foreach ($data['qty'] as $key => $item) {
            QuotationDetail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['sale_price_tax'][$key]),
                'per_price' => floatval($data['sale_price'][$key]),
                'total_price' => floatval($data['total_sale_price'][$key]),
            ]);
        }
        return $quotation;
    }

    public function updateData($id, array $data)
    {
        $quotation = $this->model::find($id);
        $quotation->update([
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
            'terms_condition' => $data['terms_condition'],
        ]);
        $quotation->quotation_details()->delete();
        foreach ($data['qty'] as $key => $item) {
            QuotationDetail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $data['product_id'][$key],
                'quantity' => $data['qty'][$key],
                'tax' => floatval($data['sale_price_tax'][$key]),
                'per_price' => floatval($data['sale_price'][$key]),
                'total_price' => floatval($data['total_sale_price'][$key]),
            ]);
        }
        return $quotation;
    }

    public function invoiceNo()
    {
        $invoice = $this->model::orderBy('id','desc')->first();
        $invoice_id = $invoice ? $invoice->id+1 : 1;
        return 'QTN#'.date('Y').sprintf('%05d', $invoice_id);
    }

    public function statusApproval($id, $status)
    {
        $quotation = $this->findById($id);
        $quotation->update(['is_approved' => $status]);
        return $quotation;
    }

    public function listForSelect($search, $filter_for = null)
    {
        $items = $this->model::query();
        if ($search != '') {
            $items = $items->whereLike(['invoice_no','phone'], $search);
        }
        $items = $items->where('is_approved','Approved')->paginate(10);
        $response = [];
        foreach($items as $item){
            if ($filter_for == "recieve") {
                $response[]  =[
                    'id'    => $item->id,
                    'text'  => $item->invoice_no
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
