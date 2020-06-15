<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Applicants;
use App\Requester;

class ApplicantController extends Controller
{
    public function location(){
        $location = Requester::select('branch_location')->where('approval_status', 'APPROVED')->where('fill_status', 'PENDING')->get();
        return response()->json(['location' => $location]);
    }

    public function position($branch_location){

        $position = Requester::select('id', 'requesting')->where('approval_status', 'APPROVED')->where('fill_status', 'PENDING')->where('branch_location', 'LIKE', '%'.$branch_location.'%')->get();

        return response()->json(['position' => $position]);
    }

    public function validator(array $data){
        return Validator::make($data, [
            'app_src1' => ['required', 'string', 'max:255'],
            'app_firstname' => ['required', 'string', 'max:255'],
            'app_lastname' => ['required', 'string', 'max:255'],
            'app_phone' => ['required', 'string',],
            'app_email' => ['required', 'string', 'email'],
            'app_gender' => ['required'],
            'app_p_address' => ['required'],
        ]);
    }

    public function create(array $data){

        return Applicants::create([
            'app_date' => Carbon::now(),
            'app_apply' => $data['app_apply'],
            'app_location' => $data['app_location'],
            'app_src1' => $data['app_src1'],
            'app_src2' => $data['app_src2'],
            'app_firstname' => $data['app_firstname'],
            'app_middlename' => $data['app_middlename'],
            'app_lastname' => $data['app_lastname'],
            'app_phone' => $data['app_phone'],
            'app_birthdate' =>  Carbon::parse($data['app_birthdate'])->format('Y-m-d'),
            'app_email' => $data['app_email'],
            'app_gender' => $data['app_gender'],
            'app_marital_status' => $data['app_marital_status'],
            'app_education' => $data['app_education'],
            'app_course' => $data['app_course'],
            'app_year_graduated' => $data['app_year_graduated'],
            'app_p_address' => $data['app_p_address'],
            'app_h_address' => $data['app_h_address'],
            'app_person' => $data['app_person'],
            'app_person_phone' => $data['app_person_phone'],
            'app_person_address' => $data['app_person_address'],
            'app_relationship' => $data['app_relationship'],
            'app_status' => 'PENDING'
        ]);
    }

    public function store(Request $request){

        $this->validator($request->all())->validate();
        $id = $this->create($request->all())->id;

    }
}
