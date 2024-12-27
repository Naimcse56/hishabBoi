@if($row->is_approved == "Approved")
    <span class="badge bg-success">Approved</span>
@elseif($row->is_approved == "Rejected")
    <span class="badge bg-warning">Rejected</span>
@else
    <span class="badge bg-danger">Pending</span>
@endif