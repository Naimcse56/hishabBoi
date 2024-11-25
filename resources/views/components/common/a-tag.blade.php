@props([
    'id' => '',
    'value' => '',
    'class' => '',
    'icon' => '',
    'column' => '12',
])

<div class="col-md-{{$column}} mt-3">
    <a href="{{ $url }}" class="btn btn-sm {{ $class }}">
        <i class="{{ $icon }}"></i>{{ $value }}
    </a>
</div>