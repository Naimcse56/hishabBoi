@if ($row->is_approve == 2)
<span class="badge bg-danger">{{$row->rejection_comment}}</span>
@endif