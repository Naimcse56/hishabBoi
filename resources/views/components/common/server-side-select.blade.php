@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'column' => '12',
    'required' => false,
    'options' => [],
    'disableOptionText' => '',
])
<div class="col-md-{{$column}} mb-2">
    @if($label)
    <label for="{{ $name }}" class="form-label">{{$label}} <span class='text-danger'>{{$required ? "*" : ''}} </span></label>
    @endif
    <select {{$attributes->class(['form-control'])}} id="{{ $name }}" name="{{$name}}" aria-invalid="false">
        <option selected="" value="" disabled>{{$disableOptionText}}</option>
    </select>
    @error($name)
        <div class="valid-feedback">{{$message}}</div>
    @enderror
</div>
