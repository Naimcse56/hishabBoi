@extends('layouts.admin_app')
@section('title')
Email Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Email Settings</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('env_settings_update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="types[]" value="MAIL_MAILER">
                                <input type="hidden" name="types[]" value="MAIL_HOST">
                                <input type="hidden" name="types[]" value="MAIL_PORT">
                                <input type="hidden" name="types[]" value="MAIL_USERNAME">
                                <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                                <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                                <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                                <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                                <x-common.select :required="true" column=6 name="MAIL_MAILER" class="MAIL_MAILER" label="MAIL DRIVER" placeholder="MAIL DRIVER" :value="env('MAIL_MAILER')" :options="[
                                    ['id' => 'sendmail', 'name' => 'Sendmail'],
                                    ['id' => 'smtp', 'name' => 'SMTP']
                                ]"></x-common.select>
                                <x-common.input :required="true" column=6 id="MAIL_HOST" name="MAIL_HOST" label="MAIL HOST" placeholder="MAIL HOST" :value="env('MAIL_HOST')"></x-common.input>
                                <x-common.input :required="true" column=6 id="MAIL_PORT" name="MAIL_PORT" label="MAIL PORT" placeholder="MAIL PORT" :value="env('MAIL_PORT')"></x-common.input>
                                <x-common.input :required="true" column=6 id="MAIL_USERNAME" name="MAIL_USERNAME" label="MAIL USERNAME" placeholder="MAIL USERNAME" :value="env('MAIL_USERNAME')"></x-common.input>
                                <x-common.input :required="true" column=6 id="MAIL_PASSWORD" name="MAIL_PASSWORD" label="MAIL PASSWORD" placeholder="MAIL PASSWORD" :value="env('MAIL_PASSWORD')"></x-common.input>
                                <x-common.select :required="true" column=6 name="MAIL_ENCRYPTION" class="MAIL_ENCRYPTION" label="MAIL ENCRYPTION" placeholder="MAIL ENCRYPTION" :value="env('MAIL_ENCRYPTION')" :options="[
                                    ['id' => 'tls', 'name' => 'TLS'],
                                    ['id' => 'ssl', 'name' => 'SSL']
                                ]"></x-common.select>
                                <x-common.input :required="true" column=6 id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" label="MAIL FROM ADDRESS" placeholder="MAIL FROM ADDRESS" :value="env('MAIL_FROM_ADDRESS')"></x-common.input>
                                <x-common.input :required="true" column=6 id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" label="MAIL FROM NAME" placeholder="MAIL FROM NAME" :value="env('MAIL_FROM_NAME')"></x-common.input>
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('test_mail_send')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-common.input :required="true" column=6 id="email" name="email" label="Email To" placeholder="Email To" :value="old('email')"></x-common.input>
                                <x-common.input :required="true" column=12 id="message" name="message" label="Mail Body" placeholder="Mail Body" :value="old('message')"></x-common.input>
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Send Mail'" :icon="'fa fa-envelope'"></x-common.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection