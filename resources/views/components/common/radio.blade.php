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
    <div {{$attributes->class(['d-flex align-items-center gap-3 mb-4'])}}>
        @foreach($options as $key => $option)
            <div class="form-check form-check-success">
                <input class="form-check-input" type="radio" name="{{$name}}" value="{{gv($option, 'id')}}" id="flexRadioSuccess_{{$name}}_{{$key}}"
                                {{
                    old($name) !== null ? (old($name) == gv($option, 'id') ? 'checked' : '') :
                    ($value != '' ? ($value == gv($option, 'id', 0) ? 'checked' : '') :
                    (isset($option['checked']) && $option['checked'] == 1 ? 'checked' : ''))
                }}>
                <label class="form-check-label" for="flexRadioSuccess_{{$name}}_{{$key}}">
                    {{gv($option, 'name')}}
                </label>
            </div>
        @endforeach
    </div>
    @error($name)
        <div class="valid-feedback mb-4">{{$message}}</div>
    @enderror
</div>
