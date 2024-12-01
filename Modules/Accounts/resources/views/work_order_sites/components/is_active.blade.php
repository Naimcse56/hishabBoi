@if($row->is_active == 1)
    <span class="badge bg-success">Active</span>
@else
    <span class="badge bg-danger">InActive</span>
@endif