<?php

namespace App\Http\Controllers\Requester;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Requester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class RequestingController extends Controller
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
        $requesting = Requester::where('user_id', $this->guard()->user()->id)->get();
        return response()->json(['requesting' => $requesting]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'requesting' => 'required',
            'num_request' => ['required', 'numeric'],
            'branch_location' => 'required',
            'branch_position' => 'required',
            'work_exp' => 'required',
            'type_request' => 'required',
            'type_employment' => 'required',
            'salary_rate' => ['required', 'numeric'],
            'company' => 'required',
            'urgent' => 'required'

        ]);
    }

    protected function create(array $data)
    {
        return Requester::create([

            'date' => Carbon::now(),
            'user_id' => $this->guard()->user()->id,
            'requester' => $this->guard()->user()->name,
            'requesting' => $data['requesting'],
            'branch_location' => $data['branch_location'],
            'branch_position' => $data['branch_position'],
            'work_exp' => $data['work_exp'],
            'num_request' => $data['num_request'],
            'type_request' => $data['type_request'],
            'type_employment' => $data['type_employment'],
            'salary_rate' => $data['salary_rate'],
            'company' => $data['company'],
            'urgent' => $data['urgent'],
            'approval_status' => "PENDING"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validator($request->all())->validate();
        $this->create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_request = Requester::findOrFail($id);
        return response()->json(['edit_request' => $edit_request]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
       $this->validator($request->all())->validate();
       $request = Requester::find($id)->update([

        'requesting' => $request->requesting,
        'branch_location' => $request->branch_location,
        'branch_position' => $request->branch_position,
        'work_exp' => $request->work_exp,
        'num_request' => $request->num_request,
        'type_request' => $request->type_request,
        'type_employment' => $request->type_employment,
        'salary_rate' => $request->salary_rate,
        'company' => $request->company,
        'urgent' => $request->urgent
           
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = Requester::findOrFail($id)->delete();
    }

    public function fetchRequest(){
        $fetch_request = Requester::where('fill_status', 'PENDING')->get();
        return response()->json(['fetch_request' => $fetch_request]);
    }
}
