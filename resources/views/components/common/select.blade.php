@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'column' => '12',
    'required' => false,
    'options' => [],
    'disableOptionText' => '',
])
<div class="col-md-{{$column}} mb-2">
    @if($label)
    <label for="{{ $name }}" class="form-label">{{$label}} <span class='text-danger'>{{$required ? "*" : ''}} </span></label>
    @endif
    <select class="form-select valid" id="{{ $name }}" name="{{$name}}" aria-invalid="false">
        <option selected="" value="" disabled>{{$disableOptionText}}</option>
        @foreach($options as $option)
            <option value="{{ gv($option, 'id') ?: '' }}" 
                    {{ gv($option, 'id') === null || gv($option, 'id') === '' ? 'disabled' : '' }} 
                    {{ old($name) == gv($option, 'id') ? '' : ($value == gv($option, 'id') ? 'selected' : '') }}>
                {{ gv($option, 'name') }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="valid-feedback">{{$message}}</div>
    @enderror
</div>
