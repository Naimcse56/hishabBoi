@extends('layouts.admin_app')
@section('title')
General Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">General Settings</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('base_settings_update.configurations')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-common.server-side-select :required="true" column=6 name="system_currency_id" id="system_currency_id" class="system_currency_id" disableOptionText="Select One" label="System Currency" :options="[
                                    ['id' => app('general_setting')['system_currency_id'].'-'.app('general_setting')['system_currency_symbol'], 'name' => app('general_setting')['system_currency_symbol']]
                                ]" :value="app('general_setting')['system_currency_id'].'-'.app('general_setting')['system_currency_symbol']"></x-common.server-side-select>
                                <x-common.select :required="true" column=6 name="date_format" class="date_format" label="Date Format" placeholder="Date Format" :value="'d/m/Y'" :options="[
                                    ['id' => 'jS M, Y', 'name' => '17th May, 2019'],
                                    ['id' => 'Y-m-d', 'name' => '2019-05-17'],
                                    ['id' => 'Y-d-m', 'name' => '2019-05-19'],
                                    ['id' => 'Y/m/d', 'name' => '2019/05/17'],
                                    ['id' => 'd/m/Y', 'name' => '17/05/2019']
                                ]"></x-common.select>
                                <input type="hidden" name="types[]" value="APP_TIMEZONE">
                                <x-common.select :required="true" column=6 name="APP_TIMEZONE" class="APP_TIMEZONE" label="Time Zone" placeholder="APP_TIMEZONE" :value="env('APP_TIMEZONE')" :options="[
                                    ['id' => 'Pacific/Midway' , 'name' => '(GMT-11:00) Midway Island'],
                                    ['id' => 'US/Samoa' , 'name' => '(GMT-11:00) Samoa'],
                                    ['id' => 'US/Hawaii' , 'name' => '(GMT-10:00) Hawaii'],
                                    ['id' => 'US/Alaska' , 'name' => '(GMT-09:00) Alaska'],
                                    ['id' => 'US/Pacific' , 'name' => '(GMT-08:00) Pacific Time (US &amp; Canada)'],
                                    ['id' => 'America/Tijuana' , 'name' => '(GMT-08:00) Tijuana'],
                                    ['id' => 'US/Arizona' , 'name' => '(GMT-07:00) Arizona'],
                                    ['id' => 'US/Mountain' , 'name' => '(GMT-07:00) Mountain Time (US &amp; Canada)'],
                                    ['id' => 'America/Chihuahua' , 'name' => '(GMT-07:00) Chihuahua'],
                                    ['id' => 'America/Mazatlan' , 'name' => '(GMT-07:00) Mazatlan'],
                                    ['id' => 'America/Mexico_City' , 'name' => '(GMT-06:00) Mexico City'],
                                    ['id' => 'America/Monterrey' , 'name' => '(GMT-06:00) Monterrey'],
                                    ['id' => 'Canada/Saskatchewan' , 'name' => '(GMT-06:00) Saskatchewan'],
                                    ['id' => 'US/Central' , 'name' => '(GMT-06:00) Central Time (US &amp; Canada)'],
                                    ['id' => 'US/Eastern' , 'name' => '(GMT-05:00) Eastern Time (US &amp; Canada)'],
                                    ['id' => 'US/East-Indiana' , 'name' => '(GMT-05:00) Indiana (East)'],
                                    ['id' => 'America/Bogota' , 'name' => '(GMT-05:00) Bogota'],
                                    ['id' => 'America/Lima' , 'name' => '(GMT-05:00) Lima'],
                                    ['id' => 'America/Caracas' , 'name' => '(GMT-04:30) Caracas'],
                                    ['id' => 'Canada/Atlantic' , 'name' => '(GMT-04:00) Atlantic Time (Canada)'],
                                    ['id' => 'America/La_Paz' , 'name' => '(GMT-04:00) La Paz'],
                                    ['id' => 'America/Santiago' , 'name' => '(GMT-04:00) Santiago'],
                                    ['id' => 'Canada/Newfoundland' , 'name' => '(GMT-03:30) Newfoundland'],
                                    ['id' => 'America/Buenos_Aires' , 'name' => '(GMT-03:00) Buenos Aires'],
                                    ['id' => 'America/Godthab' , 'name' => '(GMT-03:00) Greenland'],
                                    ['id' => 'Atlantic/Stanley' , 'name' => '(GMT-02:00) Stanley'],
                                    ['id' => 'Atlantic/Azores' , 'name' => '(GMT-01:00) Azores'],
                                    ['id' => 'Atlantic/Cape_Verde' , 'name' => '(GMT-01:00) Cape Verde Is.'],
                                    ['id' => 'Africa/Casablanca' , 'name' => '(GMT) Casablanca'],
                                    ['id' => 'Europe/Dublin' , 'name' => '(GMT) Dublin'],
                                    ['id' => 'Europe/Lisbon' , 'name' => '(GMT) Lisbon'],
                                    ['id' => 'Europe/London' , 'name' => '(GMT) London'],
                                    ['id' => 'Africa/Monrovia' , 'name' => '(GMT) Monrovia'],
                                    ['id' => 'Europe/Amsterdam' , 'name' => '(GMT+01:00) Amsterdam'],
                                    ['id' => 'Europe/Belgrade' , 'name' => '(GMT+01:00) Belgrade'],
                                    ['id' => 'Europe/Berlin' , 'name' => '(GMT+01:00) Berlin'],
                                    ['id' => 'Europe/Bratislava' , 'name' => '(GMT+01:00) Bratislava'],
                                    ['id' => 'Europe/Brussels' , 'name' => '(GMT+01:00) Brussels'],
                                    ['id' => 'Europe/Budapest' , 'name' => '(GMT+01:00) Budapest'],
                                    ['id' => 'Europe/Copenhagen' , 'name' => '(GMT+01:00) Copenhagen'],
                                    ['id' => 'Europe/Ljubljana' , 'name' => '(GMT+01:00) Ljubljana'],
                                    ['id' => 'Europe/Madrid' , 'name' => '(GMT+01:00) Madrid'],
                                    ['id' => 'Europe/Paris' , 'name' => '(GMT+01:00) Paris'],
                                    ['id' => 'Europe/Prague' , 'name' => '(GMT+01:00) Prague'],
                                    ['id' => 'Europe/Rome' , 'name' => '(GMT+01:00) Rome'],
                                    ['id' => 'Europe/Sarajevo' , 'name' => '(GMT+01:00) Sarajevo'],
                                    ['id' => 'Europe/Skopje' , 'name' => '(GMT+01:00) Skopje'],
                                    ['id' => 'Europe/Stockholm' , 'name' => '(GMT+01:00) Stockholm'],
                                    ['id' => 'Europe/Vienna' , 'name' => '(GMT+01:00) Vienna'],
                                    ['id' => 'Europe/Warsaw' , 'name' => '(GMT+01:00) Warsaw'],
                                    ['id' => 'Europe/Zagreb' , 'name' => '(GMT+01:00) Zagreb'],
                                    ['id' => 'Europe/Athens' , 'name' => '(GMT+02:00) Athens'],
                                    ['id' => 'Europe/Bucharest' , 'name' => '(GMT+02:00) Bucharest'],
                                    ['id' => 'Africa/Cairo' , 'name' => '(GMT+02:00) Cairo'],
                                    ['id' => 'Africa/Harare' , 'name' => '(GMT+02:00) Harare'],
                                    ['id' => 'Europe/Helsinki' , 'name' => '(GMT+02:00) Helsinki'],
                                    ['id' => 'Asia/Jerusalem' , 'name' => '(GMT+02:00) Jerusalem'],
                                    ['id' => 'Europe/Kiev' , 'name' => '(GMT+02:00) Kyiv'],
                                    ['id' => 'Europe/Minsk' , 'name' => '(GMT+02:00) Minsk'],
                                    ['id' => 'Europe/Riga' , 'name' => '(GMT+02:00) Riga'],
                                    ['id' => 'Europe/Sofia' , 'name' => '(GMT+02:00) Sofia'],
                                    ['id' => 'Europe/Tallinn' , 'name' => '(GMT+02:00) Tallinn'],
                                    ['id' => 'Europe/Vilnius' , 'name' => '(GMT+02:00) Vilnius'],
                                    ['id' => 'Europe/Istanbul' , 'name' => '(GMT+03:00) Istanbul'],
                                    ['id' => 'Asia/Baghdad' , 'name' => '(GMT+03:00) Baghdad'],
                                    ['id' => 'Asia/Kuwait' , 'name' => '(GMT+03:00) Kuwait'],
                                    ['id' => 'Africa/Nairobi' , 'name' => '(GMT+03:00) Nairobi'],
                                    ['id' => 'Asia/Riyadh' , 'name' => '(GMT+03:00) Riyadh'],
                                    ['id' => 'Asia/Tehran' , 'name' => '(GMT+03:30) Tehran'],
                                    ['id' => 'Europe/Moscow' , 'name' => '(GMT+04:00) Moscow'],
                                    ['id' => 'Asia/Baku' , 'name' => '(GMT+04:00) Baku'],
                                    ['id' => 'Europe/Volgograd' , 'name' => '(GMT+04:00) Volgograd'],
                                    ['id' => 'Asia/Muscat' , 'name' => '(GMT+04:00) Muscat'],
                                    ['id' => 'Asia/Tbilisi' , 'name' => '(GMT+04:00) Tbilisi'],
                                    ['id' => 'Asia/Yerevan' , 'name' => '(GMT+04:00) Yerevan'],
                                    ['id' => 'Asia/Kabul' , 'name' => '(GMT+04:30) Kabul'],
                                    ['id' => 'Asia/Karachi' , 'name' => '(GMT+05:00) Karachi'],
                                    ['id' => 'Asia/Tashkent' , 'name' => '(GMT+05:00) Tashkent'],
                                    ['id' => 'Asia/Kolkata' , 'name' => '(GMT+05:30) Kolkata'],
                                    ['id' => 'Asia/Kathmandu' , 'name' => '(GMT+05:45) Kathmandu'],
                                    ['id' => 'Asia/Yekaterinburg' , 'name' => '(GMT+06:00) Ekaterinburg'],
                                    ['id' => 'Asia/Almaty' , 'name' => '(GMT+06:00) Almaty'],
                                    ['id' => 'Asia/Dhaka' , 'name' => '(GMT+06:00) Dhaka'],
                                    ['id' => 'Asia/Novosibirsk' , 'name' => '(GMT+07:00) Novosibirsk'],
                                    ['id' => 'Asia/Bangkok' , 'name' => '(GMT+07:00) Bangkok'],
                                    ['id' => 'Asia/Ho_Chi_Minh' , 'name' => '(GMT+07.00) Ho Chi Minh'],
                                    ['id' => 'Asia/Jakarta' , 'name' => '(GMT+07:00) Jakarta'],
                                    ['id' => 'Asia/Krasnoyarsk' , 'name' => '(GMT+08:00) Krasnoyarsk'],
                                    ['id' => 'Asia/Chongqing' , 'name' => '(GMT+08:00) Chongqing'],
                                    ['id' => 'Asia/Hong_Kong' , 'name' => '(GMT+08:00) Hong Kong'],
                                    ['id' => 'Asia/Kuala_Lumpur' , 'name' => '(GMT+08:00) Kuala Lumpur'],
                                    ['id' => 'Australia/Perth' , 'name' => '(GMT+08:00) Perth'],
                                    ['id' => 'Asia/Singapore' , 'name' => '(GMT+08:00) Singapore'],
                                    ['id' => 'Asia/Taipei' , 'name' => '(GMT+08:00) Taipei'],
                                    ['id' => 'Asia/Ulaanbaatar' , 'name' => '(GMT+08:00) Ulaan Bataar'],
                                    ['id' => 'Asia/Urumqi' , 'name' => '(GMT+08:00) Urumqi'],
                                    ['id' => 'Asia/Irkutsk' , 'name' => '(GMT+09:00) Irkutsk'],
                                    ['id' => 'Asia/Seoul' , 'name' => '(GMT+09:00) Seoul'],
                                    ['id' => 'Asia/Tokyo' , 'name' => '(GMT+09:00) Tokyo'],
                                    ['id' => 'Australia/Adelaide' , 'name' => '(GMT+09:30) Adelaide'],
                                    ['id' => 'Australia/Darwin' , 'name' => '(GMT+09:30) Darwin'],
                                    ['id' => 'Asia/Yakutsk' , 'name' => '(GMT+10:00) Yakutsk'],
                                    ['id' => 'Australia/Brisbane' , 'name' => '(GMT+10:00) Brisbane'],
                                    ['id' => 'Australia/Canberra' , 'name' => '(GMT+10:00) Canberra'],
                                    ['id' => 'Pacific/Guam' , 'name' => '(GMT+10:00) Guam'],
                                    ['id' => 'Australia/Hobart' , 'name' => '(GMT+10:00) Hobart'],
                                    ['id' => 'Australia/Melbourne' , 'name' => '(GMT+10:00) Melbourne'],
                                    ['id' => 'Pacific/Port_Moresby' , 'name' => '(GMT+10:00) Port Moresby'],
                                    ['id' => 'Australia/Sydney' , 'name' => '(GMT+10:00) Sydney'],
                                    ['id' => 'Asia/Vladivostok' , 'name' => '(GMT+11:00) Vladivostok'],
                                    ['id' => 'Asia/Magadan' , 'name' => '(GMT+12:00) Magadan'],
                                    ['id' => 'Pacific/Auckland' , 'name' => '(GMT+12:00) Auckland'],
                                    ['id' => 'Pacific/Fiji' , 'name' => '(GMT+12:00) Fiji']
                                ]"></x-common.select>                               
                                <x-common.server-side-select :required="true" column=6 name="system_language" id="system_language" class="system_language" disableOptionText="Select One" label="System Language" :options="[
                                    ['id' => app('general_setting')['system_language'], 'name' => app('general_setting')['system_language']]
                                ]" :value="app('general_setting')['system_language']"></x-common.server-side-select>
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;
            
            $(".system_currency_id").select2({
                ajax: {
                    url: '{{route('currencies.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            $(".system_language").select2({
                ajax: {
                    url: '{{route('language.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

        })(jQuery);
    </script>
@endpush