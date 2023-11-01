<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\unit;


class UnitController extends Controller
{
    public function index(Request $request){
        $Unit = unit::latest();
        if(!empty($request->get('keyworld'))){
            $Unit = $Unit->where('unit_code','like','%'.$request->get('keyworld').'%');
        }
        $Unit = $Unit->paginate(10);
        return view('admin.Units.list',compact('Unit'));
    }
    public function create(){
        return view('admin.Units.create');
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'name'=>'required',
            'unit_code'=>'required|unique:Unit',
        ]);
            if($validatior->passes()){
                $Unit = new unit();
                $Unit->unit_code = $request->unit_code;
                $Unit->name = $request->name;        
                $Unit->status = $request->status;
                $Unit->save();

                $request->session()-> flash('success','Unit added successfully');
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
    public function edit($UnitID,Request $request){
        $Unit = unit::find($UnitID);
        if(empty($Unit)){
            return redirect()->route('unit.index');
        }

        return view('admin.Units.edit',compact('Unit'));
    }
    public function update($UnitID,Request $request){
        $Unit = unit::find($UnitID);
        if(empty($Unit)){
            $request->session()->flash('error','unit not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'unit not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'name'=>'required',
            'unit_code'=>'required|unique:unit,unit_code,'.$Unit->id.',id',
        ]);
            if($validatior->passes()){
                $Unit->unit_code = $request->unit_code;
                $Unit->name = $request->name;        
                $Unit->status = $request->status;
                $Unit->save();

                $request->session()-> flash('success','Unit updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Unit updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($UnitID,Request $request){
        $Unit = unit::find($UnitID);

        if(empty($Unit)){
            $request->session()-> flash('error','unit not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'unit not found'
                ]);
            // return redirect()->route('unit.index');
        }
        $Unit->delete();
        $request->session()-> flash('success','Unit deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'Unit deleted successfully'
        ]);
    }
}
