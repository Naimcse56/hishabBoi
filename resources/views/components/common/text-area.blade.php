@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'column' => '12',
    'required' => false
])
<div class="col-md-{{$column}} mb-2">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{$label}} <span class='text-danger'>{{$required ? "*" : ''}} </span></label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" rows="3" {{$attributes->class(['form-control'])}}>{{old($name) ? old($name) : $value }}</textarea>
    @error($name)
        <div class="valid-feedback">{{$message}}</div>
    @enderror
</div>
