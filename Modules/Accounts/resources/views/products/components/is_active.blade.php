@if($row->is_active == "Yes")
    <span class="badge bg-success">Active</span>
@else
    <span class="badge bg-danger">In-Active</span>
@endif