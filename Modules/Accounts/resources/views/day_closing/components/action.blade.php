<div class="btn-group" role="group" aria-label="Basic example">
    @if ($row->is_closed == 1)
        <button type="button" class="btn btn-sm btn-success" id="basicAlert">
            <i class="bx bx-stopwatch"></i>Already Closeed
        </button>
    @endif
    <a href="{{route('accountings.day_closing_check',encrypt($row->id))}}" class="btn btn-sm btn-danger"><i class="fa fa-clock"></i></a>
</div>