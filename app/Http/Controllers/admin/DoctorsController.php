<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorsController extends Controller
{

    public function index(Request $request){
        $Doctors = doctors::latest();
        // if(!empty($request->get('keyworld'))){
        //     $Doctors = $Doctors->where('doctors_code','like','%'.$request->get('keyworld').'%');
        // }
        $Doctors = $Doctors->paginate(10);
        return view('admin.Doctors.list',compact('Doctors'));
    }
    public function create(){
        return view('admin.Doctors.create');

    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'doctors_name'=>'required',
            'doctors_code'=>'required|unique:Doctors',
        ]);
            if($validatior->passes()){
                $Doctors = new doctors();
                $Doctors->doctors_code = $request->doctors_code;
                $Doctors->doctors_name = $request->doctors_name;        
                $Doctors->specialization = $request->specialization;
                $Doctors->department = $request->department;
                $Doctors->status = $request->status;
                $Doctors->save();

                $request->session()-> flash('success','Doctors added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Unit added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($DoctorsID,Request $request){
        $Doctors = doctors::find($DoctorsID);
        if(empty($Doctors)){
            return redirect()->route('doctors.index');
        }

        return view('admin.Doctors.edit',compact('Doctors'));
    }
    public function update($DoctorsID,Request $request){
        $Doctors = doctors::find($DoctorsID);
        if(empty($Doctors)){
            $request->session()->flash('error','Doctors not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'Doctors not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'doctors_name'=>'required',
            'doctors_code'=>'required|unique:Doctors,doctors_code,'.$Doctors->id.',id',
        ]);
            if($validatior->passes()){
                $Doctors->doctors_code = $request->doctors_code;
                $Doctors->doctors_name = $request->doctors_name;        
                $Doctors->specialization = $request->specialization;
                $Doctors->department = $request->department;
                $Doctors->status = $request->status;
                $Doctors->save();

                $request->session()-> flash('success','Doctors updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Doctors updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($DoctorsID,Request $request){
        $Doctors = doctors::find($DoctorsID);

        if(empty($Doctors)){
            $request->session()-> flash('error','Doctors not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'Doctors not found'
                ]);
            // return redirect()->route('Doctors.index');
        }
        $Doctors->delete();
        $request->session()-> flash('success','Doctors deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'Doctors deleted successfully'
        ]);
    }
}
