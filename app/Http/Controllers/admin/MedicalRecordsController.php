<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\medicalrecords;

use App\Models\doctors;
use App\Models\patients;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
class MedicalRecordsController extends Controller
{
    public function index(Request $request){
        $MedicalRecords =medicalrecords::latest();
        if(!empty($request->get('keyworld'))){
           $MedicalRecords =$MedicalRecords->where('medicalrecords_code','like','%'.$request->get('keyworld').'%');
        }
       $MedicalRecords =$MedicalRecords->paginate(8);
        return view('admin.MedicalRecords.list',compact('MedicalRecords'));
    }
    public function create(){
        $data=[];
        $Doctors = doctors::orderBy('doctors_name','ASC')->get();
        $data['Doctors'] = $Doctors;
        $Patients = patients::orderBy('patients_name','ASC')->get();
        $data['Patients'] = $Patients;
        return view('admin.medicalrecords.create',$data);
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'medicalrecords_diagnosis'=>'required',
            'doctors'=>'required',
            'patients'=>'required',
            'status'=>'required',
            'medicalrecords_code'=>'required|unique:medicalrecords',
        ]);
            if($validatior->passes()){
                $MedicalRecords = new medicalrecords();
                $MedicalRecords->medicalrecords_code = $request->medicalrecords_code;
                $MedicalRecords->doctor_id = $request->doctors;
                $MedicalRecords->patient_id = $request->patients;      
                $MedicalRecords->medicalrecords_diagnosis = $request->medicalrecords_diagnosis;        
                $MedicalRecords->medicalrecords_treatment = $request->medicalrecords_treatment;        
                $MedicalRecords->medicalrecords_prescription = $request->medicalrecords_prescription;   
                $MedicalRecords->medicalrecords_date = $request->medicalrecords_date;     
                $MedicalRecords->status = $request->status;
                $MedicalRecords->save();
                
                // save image here
                if(!empty($request->image_id)){
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.',$tempImage->name);
                    $ext = last($extArray);


                    $newImageName = $MedicalRecords->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);


                    $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                     $img = Image::make($sPath);
                     $img->resize(450,600);
                     $img->save($dPath);

                    $MedicalRecords->image = $newImageName;
                    $MedicalRecords->save();
                }
                $request->session()-> flash('success','MedicalRecords added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'MedicalRecords added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($MedicalRecordsID,Request $request){
        $MedicalRecords = medicalrecords::find($MedicalRecordsID);
        
        if(empty($MedicalRecords)){
            $request->session()->flash('error','medicalrecords not found');
            return redirect()->route('medicalrecords.index');
        }
        $data=[];
        $Doctors = doctors::orderBy('doctors_name','ASC')->get();
        $data['Doctors'] = $Doctors;
        $Patients = patients::orderBy('patients_name','ASC')->get();
        $data['Patients'] = $Patients;
        return view('admin.medicalrecords.edit',compact('MedicalRecords'),$data);
    }
    public function update($MedicalRecordsID,Request $request){
        $MedicalRecords = medicalrecords::find($MedicalRecordsID);
        if(empty($MedicalRecords)){
            $request->session()->flash('error','medicalrecords not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'medicalrecords not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'medicalrecords_name'=>'required',
            'suppiler'=>'required',
            'status'=>'required',
            'medicalrecords_code'=>'required|unique:MedicalRecords,medicalrecords_code,'.$MedicalRecords->id.',id',
        ]);
            if($validatior->passes()){
                $MedicalRecords->medicalrecords_code = $request->medicalrecords_code;
                $MedicalRecords->doctor_id = $request->doctors;
                $MedicalRecords->patient_id = $request->patients;      
                $MedicalRecords->medicalrecords_diagnosis = $request->medicalrecords_diagnosis;        
                $MedicalRecords->medicalrecords_treatment = $request->medicalrecords_treatment;        
                $MedicalRecords->medicalrecords_prescription = $request->medicalrecords_prescription;   
                $MedicalRecords->medicalrecords_date = $request->medicalrecords_date;     
                $MedicalRecords->status = $request->status;
                $MedicalRecords->save();
            
                $request->session()-> flash('success','medicalrecords updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'medicalrecords updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($MedicalRecordsID,Request $request){
        $MedicalRecords = medicalrecords::find($MedicalRecordsID);

        if(empty($MedicalRecords)){
            $request->session()-> flash('error','medicalrecords not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'medicalrecords not found'
                ]);
            // return redirect()->route('category.index');
        }
        $MedicalRecords->delete();
        $request->session()-> flash('success','medicalrecords deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'medicalrecords deleted successfully'
        ]);
    }
}


