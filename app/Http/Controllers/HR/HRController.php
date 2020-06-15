<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Applicants;
use App\Requester;
use App\Requirements;
use App\Screening;

class HRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function index()
    {
        $applicants = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', '!=', 'REMOVED')->get();
        return response()->json(['applicants' => $applicants], 200);
    }

    public function showApplicant($app_id){
        
        $showApplicant = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')
        ->leftJoin('screening_section', 'screening_section.ss_app_id', 'applicants.app_id')
        ->leftJoin('requirements_section', 'requirements_section.rs_app_id', 'applicants.app_id')
        ->where('app_id', $app_id)->first();

        return response()->json(['showApplicant' => $showApplicant], 200);
    }   

    public function pendingApplicant(){
        $pending_app = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'PENDING')->get();
        $screening_app = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'SCREENING')->get();
        $requirements_app = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'REQUIREMENTS')->get();
        $fetch_request = Requester::where('fill_status', 'PENDING')->get();

        return response()->json(['pending_app' => $pending_app, 'fetch_request' => $fetch_request, 'screening_app' => $screening_app, 'requirements_app' => $requirements_app], 200);
    }

    public function saveScreening($ss_id){
        
        $get_id = Screening::where('ss_app_id', $ss_id)->first();

        if($get_id){
            $screen = [
                'ss_app_id' => request()->ss_app_id,
                'ss_date' => request()->ss_date,
                'ss_time' => request()->ss_time,
                'ss_interviewer' => $this->guard()->user()->name,
                'ss_pof' => request()->ss_pof,
            ];
            
            Screening::where('ss_app_id', $ss_id)->update($screen);
            
            if(count(array_filter($screen)) == count($screen)) {
                $ss_status = 1;
            } else {
                $ss_status = 0;
            }
            
            Screening::where('ss_app_id', $ss_id)->update([
                'ss_status' => $ss_status,
                'ss_status_date' => Carbon::now(),
            ]);

            if($ss_status == 1){
                Applicants::where('app_id', $ss_id)->update([
                    'app_status' => 'REQUIREMENTS',
                    'app_status_date' => Carbon::now(),
                ]);
            }
        }
    }

    public function insertScreening(Request $request){

        $insert_screening = Screening::insert([
            'ss_app_id' => $request->ss_app_id,
            'ss_date' => $request->ss_date,
            'ss_time' => $request->ss_time,
            'ss_interviewer' => $this->guard()->user()->name,
            'ss_pof' => $request->ss_pof,
            'ss_status' => 0,
            'ss_status_date' => Carbon::now(),
        ]);

        Applicants::where('app_id', $request->ss_app_id)->update([
            'app_status' => 'SCREENING',
            'app_status_date' => Carbon::now()
        ]);
        
        return response()->json(['insert_screening' =>  $insert_screening]);

    }

    public function insertRequirements(Request $request){

        $insert_requirements = Requirements::insert([
            'rs_app_id' => $request->rs_app_id,
            'rs_pic' => $request->rs_pic === true ? 1 : 0,
            'rs_resume' => $request->rs_resume === true ? 1 : 0,
            'rs_nso' => $request->rs_nso === true ? 1 : 0,
            'rs_clearance' => $request->rs_clearance === true ? 1 : 0,
            'rs_xray' => $request->rs_xray === true ? 1 : 0,
            'rs_hcard' => $request->rs_hcard === true ? 1 : 0,
            'rs_hepa' => $request->rs_hepa === true ? 1 : 0,
            'rs_drug' => $request->rs_drug === true ? 1 : 0,
            'rs_pregnancy' => $request->rs_pregnancy === true ? 1 : 0,
            'sss' => $request->sss,
            'philhealth' => $request->philhealth,
            'hdmf' => $request->hdmf,
            'tin' => $request->tin,
            'bank_account' => $request->bank_account,
            'req_status' => 0,
            'req_status_date' => Carbon::now(),
            'updated_name' => $this->guard()->user()->name,
            'updated_date' => Carbon::now(),
        ]);
        
        return response()->json(['insert_requirements' =>  $insert_requirements]);

    }

    public function saveRequirements($rs_id, Request $request){
        
        $get_id = Requirements::where('rs_app_id', $rs_id)->first();
        
        if($get_id){
            $req = [
                'rs_app_id' => $request->rs_app_id,
                'rs_pic' => $request->rs_pic === true || $request->rs_pic === 1 ? 1 : 0,
                'rs_resume' => $request->rs_resume === true ||  $request->rs_resume === 1 ? 1 : 0,
                'rs_nso' => $request->rs_nso === true || $request->rs_nso === 1 ? 1 : 0,
                'rs_clearance' => $request->rs_clearance === true || $request->rs_clearance === 1 ? 1 : 0,
                'rs_xray' => $request->rs_xray === true || $request->rs_xray === 1 ? 1 : 0,
                'rs_hcard' => $request->rs_hcard === true || $request->rs_hcard === 1 ? 1 : 0,
                'rs_hepa' => $request->rs_hepa === true || $request->rs_hepa === 1 ? 1 : 0,
                'rs_drug' => $request->rs_drug === true || $request->rs_drug === 1 ? 1 : 0,
                'sss' => $request->sss,
                'philhealth' => $request->philhealth,
                'hdmf' => $request->hdmf,
                'tin' => $request->tin,
                'bank_account' => $request->bank_account
            ];
            
            $requestReq = array_merge($req, ['rs_pregnancy' => $request->rs_pregnancy === true || $request->rs_pregnancy === 1 ? 1 : 0]);

            Requirements::where('rs_app_id', $rs_id)->update($requestReq);
            
            if(count(array_filter($req)) == count($req)) {
                $req_status = 1;
            } else {
                $req_status = 0;
            }
            
            
            Requirements::where('rs_app_id', $rs_id)->update([
                'req_status' =>  $req_status,
                'req_status_date' => Carbon::now(),
                'updated_name' => $this->guard()->user()->name,
                'updated_date' => Carbon::now()
            ]);
        }
    }

    public function remove($app_id){
        $remove = Applicants::where('app_id', $app_id)->update([
            'app_status' => 'REMOVED',
            'app_status_date' => Carbon::now()
        ]);

        return response()->json($remove);
    }

    public function pending(){
        $applicants = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'PENDING')->get();
        return response()->json(['applicants' => $applicants], 200);
    }

    public function screening(){
        $applicants = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'SCREENING')->get();
        return response()->json(['applicants' => $applicants], 200);
    }

    public function requirements(){
        $applicants = Applicants::leftJoin('requesters', 'requesters.id', 'applicants.app_apply')->where('app_status', 'REQUIREMENTS')->get();
        return response()->json(['applicants' => $applicants], 200);
    }

}
