@extends('layouts.admin_app')
@section('title')
Company Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">User Permissions</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="#" method="GET" >
                            @csrf
                            <div class="row">                                
                                     <x-common.select :required="true" column=6 
                                     name="user_id"  label="User" placeholder="User" :value="'1'" :options="[
                                    ['id' => '1', 'name' => 'Monir'],
                                    
                                ]"></x-common.select>
                                 
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Search'" :icon="'fa fa-check'"></x-common.button>
                            </div>
                        </form>
                        @if($user_id)
 <div>
     
    <h4 class="mt-4">User Permissions List</h4></div>
   <form class="create_form permission" action="{{ route('store.permisssions') }}" method="POST"  >
                            @csrf
                            <input type="hidden" value="{{ $user_id }}"  name="user_id"/>
 <div class="row">
 
    @foreach ($permissions as $permission) 
        
         
     <div class="col-md-3">
         <div class="form-check">
  <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="{{ $permission->name }}"
  @foreach ($assigned_permissions as $assigned_permission) 
   @if($assigned_permission == $permission->name) checked @endif
  @endforeach
  >
  <label class="form-check-label" for="{{ $permission->name }}">
    {{ $permission->label }}
  </label>
</div>
    </div>
@endforeach

        <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
 
 </div>
                   </form>      
                   @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection