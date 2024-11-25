@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'column' => '12',
    'required' => false
])
@php
    if(@$value){
        $dateRange = $value;
        $dates = explode('to', $dateRange);
        $startDate = $dates[0];
        $endDate = $dates[1];
    }else{
        $startDate = '';
        $endDate = '';
    }
@endphp
<div class="col-md-{{$column}} mb-2">
    @if($label)
        <label class="form-label">{{$label}} <span class='text-danger'>{{$required ? "*" : ''}} </span></label>
    @endif
    <div class="row">
        <div class="col-md-6">
            <input name="{{ $name ? $name.'_from' : 'from' }}" placeholder="{{$placeholder}}" {{$attributes->class(['form-control datepicker flatpickr-input'])->merge(['type' => 'text'])}} value="{{ @$startDate }}" readonly="readonly">
            @error($name ? $name.'_from' : 'from')
                <div class="valid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <input name="{{ $name ? $name.'_to' : 'to' }}" placeholder="{{$placeholder}}" {{$attributes->class(['form-control datepicker flatpickr-input'])->merge(['type' => 'text'])}} value="{{ @$endDate }}" readonly="readonly">
            @error($name ? $name.'_to' : 'to')
                <div class="valid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
</div>
