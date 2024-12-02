@if ($row->is_approve == 1)
<span class="badge bg-success">Checked</span>
@elseif ($row->is_approve == 2)
<span class="badge bg-danger">Reject</span>
@else
<span class="badge bg-warning">Pending</span>
@endif