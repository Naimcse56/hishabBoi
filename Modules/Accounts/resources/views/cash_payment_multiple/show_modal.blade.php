
<!-- Add Modal Item_Details -->
<div class="modal fade" id="detail_info_modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Details : {{$journal->TypeName}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0 pb-0">
                <div class="row mb-0">
                    <div class="text-center fw-semibold"> VOUCHER ({{ $journal->TypeDetails }}) </div>
                </div>
                
                <div class="row" style="margin-top: 0px;">
                   <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; border-bottom: 1px #666666 solid; padding-bottom: 5px;">
                      
                      <p class="mb-0">Date. :<span>{{ date('d-m-Y', strtotime($journal->date)) }}</span></p>
                      <p class="mb-0">Voucher No : <span>{{$journal->TypeName}}</span></p>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; padding-bottom: 5px;">
                        <p class="mb-0">Concern Person : <span>{{$journal->concern_person}}</span></p>
                    </div>
                </div>
                @if ($journal->is_approve == 2)
                  <div class="row">
                      <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; padding-bottom: 5px;">
                          <p class="mb-0 text-danger fw-semibold">Reject Note : <span>{{$journal->rejection_comment}}</span></p>
                      </div>
                  </div>
                @endif
                @if ($journal->narration)
                  <div class="row">
                      <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; padding-bottom: 10px;">
                          <p class="mb-0">Purpose : <span>{{$journal->narration}}</span></p>
                      </div>
                  </div>
                @endif
                <div class="row">   
                   @php
                       $total_debit = 0;
                       $total_credit = 0;
                   @endphp
                   <div class="col-md-12">
                       <div class="table table-responsive">
                           <table class="table table_modal table-bordered">
                               <thead>
                                   <tr>
                                       <th scope="col" width="30%">Ledger</th>
                                       <th scope="col">Party</th>
                                       <th scope="col" width="15%">Debit</th>
                                       <th scope="col" width="15%">Credit</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($journal->transactions as $item)
                                       @php
                                           if ($item->type == "Dr") {
                                               $total_debit += $item->amount;
                                           } else {
                                               $total_credit += $item->amount;
                                           }
                                       @endphp
                                       <tr>
                                           <td>{{ $item->ledger->name }} ({{ $item->ledger->code }})</a></td>
                                           <td>
                                               {{ $item->sub_ledger->name }}
                                               @if ($item->work_order_id)
                                                   <p class="mb-0 font-13">Work Order : {{ $item->work_order->order_name }}</p>
                                                   <p class="mb-0 font-13">Work Order No : {{ $item->work_order->order_no }}</p>
                                                   <p class="mb-0 font-13">Work Order Site : {{ $item->work_order_site_detail->site_name }}</p>
                                               @endif
                                               @if ($item->land_project_id)
                                                   <p class="mb-0 font-13">Land Project : {{ $item->land_project->order_name }}</p>
                                                   <p class="mb-0 font-13">Land Requisition No : {{ $item->land_project->requisition_no }}</p>
                                               @endif
                                               @if ($item->check_no || $item->bank_name || $item->bank_account_name)
                                                   <p class="mb-0 font-13">Bank Name : {{$item->bank_name}}</p>
                                                   <p class="mb-0 font-13">Bank Account Name : {{$item->bank_account_name}}</p>
                                                   <p class="mb-0 font-13">Cheque No : {{$item->check_no}}</p>
                                                   <p class="mb-0 font-13">Cheque Maturity Date : {{$item->check_mature_date}}</p>
                                               @endif
                                               @if ($item->narration && $journal->panel == "cash_payment_multiple")
                                                <p class="mb-0 font-13">Purpose : {{$item->narration}}</p>
                                               @endif
                                           </td>
                                           <td>
                                               {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                                           </td>
                                           <td>
                                               {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                                           </td>
                                       </tr>
                                   @endforeach
                                   <tr>
                                       <td colspan="2">Total Amount</td>
                                       <td class="nowrap" id="total_debit"> {{ number_format($total_debit, 2) }}</td>
                                       <td class="nowrap" id="total_credit"> {{ number_format($total_credit, 2) }}</td>
                                   </tr>
                                   <tr>
                                        <td>Taka In&nbsp;Words:&nbsp;</td>
                                        <td colspan="3">{{convert_number($journal->amount)}}          &nbsp;Only</td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                   </div>
                   <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; border-bottom: 1px #666666 solid; padding-bottom: 5px;">
                        <p class="mb-0">Creator :<span>{{$journal->creator->name}}</span></p>
                        @if ($journal->attachment)
                            <a href="{{asset($journal->attachment)}}" class="fw-semibold" download="{{str_replace(' ','-',$journal->TypeName.'-attachment')}}"><i class="bx bx-download"></i> Attachment <i class="bx bx-download"></i></a>
                        @endif
                        @if ($journal->updated_by != null)
                        <p class="mb-0">Updator :<span>{{$journal->updator->name}}</span></p>
                        @endif
                        <p class="mb-0">MAC Address :<span>{{ $journal->mac_address }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{route('multi-cash-payment.print',encrypt($journal->id))}}" class="btn btn-primary" target="_blank"><i class="bx bx-printer"></i> Print</a>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>