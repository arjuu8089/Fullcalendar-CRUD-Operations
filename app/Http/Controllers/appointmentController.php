<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Response;
use App\appointments;
use Calendar;
use DB;

class appointmentController extends Controller
{
    public function appointments()
    {
        return view('addappointment');
    }
    public function index()
    {
        if(request()->ajax()) 
        {
 
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            $data = appointments::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','name','title','email_id','start', 'end']);
            
            return Response::json($data);
        }
        return view('home');
    }
    public function create(Request $request)
    {
        //validation
        $validatedData = $request->validate([
            'name' => 'required',
            'email_id' => 'required',
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        $str_date=date("Y-m-d H:i:s", strtotime(request('start_date')));
        $end_date=date("Y-m-d H:i:s", strtotime(request('end_date')));

        $insertArr = [ 'name' => $request->name,
                        'email_id' => $request->email_id,
                        'title' => $request->title,
                       'start' => $str_date,
                       'end' => $end_date
                    ];
        
        $event=false;
        //To check 5 Appointments
        $str_dt=date("Y-m-d", strtotime(request('start_date')));
        $data = appointments::whereDate('start', 'LIKE',"%{$str_dt}%")->get(['name']);
        
        if(count($data) >=5){
            $msg='Maximum Appointments is Achieved';
            $request->session()->flash('warning', $msg);
            return view('home');
        }else{
            $msg='Successfully Added';
            $event = appointments::insert($insertArr); 
            $request->session()->flash('warning', $msg);
        }

        if($event){
            return redirect('appointment');
        }
    }
    public function destroy(Request $request)
    {
        
        $event=json_decode($request->getContent(), true);
        $id=$event['0']['id'];
        $event = appointments::where('id',$id)->delete();
         
        return Response::json($event);
    }
}
