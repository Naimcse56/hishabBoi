<?php

namespace Modules\Base\App\Repository\Eloquents;

use Modules\Base\App\Models\Staff;
use Modules\Accounts\App\Models\SubLedger;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
class StaffRepository
{
    use FileUploadTrait;
    public function allDataTable()
    {
        return Staff::with(['user:id,name,email','designation:id,name','department:id,name'])->orderBy('id','desc');
    }

    public function create(array $data)
    {
        if (!empty($data['cv'])) {
            $cv = $this->uploadFile($data['cv'], 'staff-cv');
        } else {
            $cv = null;
        }
        if (!empty($data['nid'])) {
            $nid = $this->uploadFile($data['nid'], 'staff-nid');
        } else {
            $nid = null;
        }
        $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'username' => str_replace(' ','-',strtolower($data['name'])).date('dhis'),
                        'is_active' => ($data['is_active'] == "Yes") ? 1 : 0,
                        'email_verified_at' => now()
                    ]);
        $staff = Staff::create([
                        'user_id' => $user->id,
                        'department_id' => $data['department_id'],
                        'designation_id' => $data['designation_id'],
                        'staff_id' => $data['staff_id'],
                        'phone' => $data['phone'],
                        'alternate_phone' => $data['alternate_phone'],
                        'present_address' => $data['present_address'],
                        'permanant_address' => $data['permanant_address'],
                        'date_of_birth' => Carbon::createFromFormat('d/m/Y', $data["date_of_birth"])->format('Y-m-d'),
                        'joining_date' => Carbon::createFromFormat('d/m/Y', $data["joining_date"])->format('Y-m-d'),
                        'employement_status' => $data['employement_status'],
                        'remarks' => $data['remarks'],
                        'nid' => $nid,
                        'cv' => $cv,
                    ]);
        $sub_ledger = SubLedger::create([
                        'sub_ledger_type_id' => $data['sub_ledger_type_id'],
                        'morphable_type' => get_class($staff),
                        'morphable_id' => $staff->id,
                        'ledger_id' => $data['ledger_id'],
                        'type' => "Staff",
                        'code' => $data['staff_id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'bank_name' => $data['bank_name'],
                        'bank_ac_name' => $data['bank_ac_name'],
                        'ac_no' => $data['ac_no'],
                        'routing_no' => $data['routing_no'],
                        'swift_code' => $data['swift_code'],
                        'branch_code' => $data['branch_code'],
                        'is_active' => ($data['is_active'] == "Yes") ? 1 : 0,
                    ]);
        return $staff;
    }

    public function findById($id)
    {
        return Staff::find($id);
    }

    public function update($id, array $data)
    {
        $staff = $this->findById($id);
        if (!empty($data['cv'])) {
            $cv = $this->uploadFile($data['cv'], 'staff-cv');
        } else {
            $cv = $staff->cv;
        }
        if (!empty($data['nid'])) {
            $nid = $this->uploadFile($data['nid'], 'staff-nid');
        } else {
            $nid = $staff->nid;
        }
        $staff->user->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'is_active' => ($data['is_active'] == "Yes") ? 1 : 0,
                    ]);
        if (!empty($data['password']) && $data['password']) {
            $staff->user->update([
                'password' => Hash::make($data['password']),
            ]);
        }
        $staff->update([
                'department_id' => $data['department_id'],
                'designation_id' => $data['designation_id'],
                'staff_id' => $data['staff_id'],
                'phone' => $data['phone'],
                'alternate_phone' => $data['alternate_phone'],
                'present_address' => $data['present_address'],
                'permanant_address' => $data['permanant_address'],
                'date_of_birth' => Carbon::createFromFormat('d/m/Y', $data["date_of_birth"])->format('Y-m-d'),
                'joining_date' => Carbon::createFromFormat('d/m/Y', $data["joining_date"])->format('Y-m-d'),
                'employement_status' => $data['employement_status'],
                'remarks' => $data['remarks'],
                'nid' => $nid,
                'cv' => $cv,
            ]);
        $staff->morph->update([
                        'sub_ledger_type_id' => $data['sub_ledger_type_id'],
                        'ledger_id' => $data['ledger_id'],
                        'type' => "Staff",
                        'code' => $data['staff_id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'bank_name' => $data['bank_name'],
                        'bank_ac_name' => $data['bank_ac_name'],
                        'ac_no' => $data['ac_no'],
                        'routing_no' => $data['routing_no'],
                        'swift_code' => $data['swift_code'],
                        'branch_code' => $data['branch_code'],
                        'is_active' => ($data['is_active'] == "Yes") ? 1 : 0,
                    ]);
        return $staff;
    }

    public function listForSelect($search)
    {
        $items = Staff::query();
        if ($search != '') {
            $items = $items->whereLike(['users.name','staff_id'], $search);
        }
        $items = $items->with(['user'])->paginate(10);
        $response = [];
        foreach($items as $item){
            $response[] = [
                'id'    => $item->user_id,
                'text'  => $item->user->name
            ];
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }
}
