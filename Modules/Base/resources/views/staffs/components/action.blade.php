<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('staffs.show',encrypt($row->id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
    <a href="{{route('staffs.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
</div>