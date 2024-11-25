@props([
    'id' => '',
    'value' => '',
    'column' => '12',
])
<div class="col-md-{{$column}} mt-3">
    <button id="{{ $id }}" {{$attributes->class(['btn btn-sm'])->merge(['type' => 'submit'])}}>{{ $value }}</button>
</div>
