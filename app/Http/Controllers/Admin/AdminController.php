<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Requester;

class AdminController extends Controller
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
        $admin_request = Requester::all();
        return response()->json(['admin_request' => $admin_request], 200);
    }

    public function ribshack(){

        $ribshack = Requester::where('approval_status', 'PENDING')->where('company', 'RIBSHACK')->get();
        return response()->json(['ribshack' => $ribshack], 200);

    }

    public function delcom(){

        $delcom = Requester::where('approval_status', 'PENDING')->where('company', 'DELCOM')->get();
        return response()->json(['delcom' => $delcom], 200);
        
    }

    public function ramx(){

        $ramx = Requester::where('approval_status', 'PENDING')->where('company', 'RAMX')->get();
        return response()->json(['ramx' => $ramx], 200);
        
    }

    public function approve($id){
        Requester::find($id)->update([
            'approver_name' => $this->guard()->user()->name,
            'approval_status' => 'APPROVED',
            'approval_date' => Carbon::now(),
            'fill_status' => 'PENDING'
        ]);
    }

    public function disapprove($id){
        Requester::find($id)->update([
            'approver_name' => $this->guard()->user()->name,
            'approval_status' => 'DISAPPROVED',
            'approval_date' => Carbon::now(),
            'fill_status' => 'DISAPPROVED'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = Requester::findOrFail($id);
        return response()->json(['request' => $request ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
