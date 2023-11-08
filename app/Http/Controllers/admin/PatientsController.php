<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\patients;


class PatientsController extends Controller
{
    public function index(Request $request){
        $Patients = patients::latest();
        if(!empty($request->get('keyworld'))){
            $Patients = $Patients->where('patients_code','like','%'.$request->get('keyworld').'%');
        }
        $Patients = $Patients->paginate(10);
        return view('admin.Patients.list',compact('Patients'));
    }
    public function create(){
        return view('admin.Patients.create');
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'patients_name'=>'required',
            'patients_code'=>'required|unique:Patients',
        ]);
            if($validatior->passes()){
                $Patients = new patients();
                $Patients->patients_code = $request->patients_code;
                $Patients->patients_name = $request->patients_name;        
                $Patients->phone_number = $request->phone_number;        
                $Patients->patients_address = $request->patients_address;        
                $Patients->email = $request->email;        
                $Patients->gender = $request->gender;
                $Patients->status = $request->status;
                $Patients->save();

                $request->session()-> flash('success','Patients added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Patientst added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
    }
    public function edit($PatientsID,Request $request){
        $Patients = patients::find($PatientsID);
        if(empty($Patients)){
            return redirect()->route('Patients.index');
        }

        return view('admin.Patients.edit',compact('Patients'));
    }
    public function update($PatientsID,Request $request){
        $Patients = patients::find($PatientsID);
        if(empty($Patients)){
            $request->session()->flash('error','Patients not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'Patients not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'patients_name'=>'required',
            'patients_code'=>'required|unique:patients,patients_code,'.$Patients->id.',id',
        ]);
            if($validatior->passes()){
               $Patients->patients_code = $request->patients_code;
                $Patients->patients_name = $request->patients_name;        
                $Patients->phone_number = $request->phone_number;        
                $Patients->patients_address = $request->patients_address;        
                $Patients->email = $request->email;        
                $Patients->gender = $request->gender;
                $Patients->status = $request->status;
                $Patients->save();

                $request->session()-> flash('success','Patients updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Patients updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($PatientsID,Request $request){
        $Patients = patients::find($PatientsID);

        if(empty($Patients)){
            $request->session()-> flash('error','Patients not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'Patients not found'
                ]);
            // return redirect()->route('Patients.index');
        }
        $Patients->delete();
        $request->session()-> flash('success','Patients deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'Patients deleted successfully'
        ]);
    }
}
