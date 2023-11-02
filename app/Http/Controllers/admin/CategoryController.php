<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;

use App\Models\suppiler;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
class CategoryController extends Controller
{
    public function index(Request $request){
        $Category =category::latest();
        if(!empty($request->get('keyworld'))){
           $Category =$Category->where('category_code','like','%'.$request->get('keyworld').'%');
        }
       $Category =$Category->paginate(8);
        return view('admin.category.list',compact('Category'));
    }
    public function create(){
        $Suppiler = suppiler::orderBy('suppiler_name','ASC')->get();
        $data['Suppiler'] = $Suppiler;
        return view('admin.category.create',$data);
    }
    public function store(Request $request){
        $validatior= Validator::make($request->all(),[
            'category_name'=>'required',
            'suppiler'=>'required',
            'status'=>'required',
            'category_code'=>'required|unique:Category',
        ]);
            if($validatior->passes()){
                $Category = new category();
                $Category->category_code = $request->category_code;
                $Category->category_name = $request->category_name;        
                $Category->suppiler_id = $request->suppiler;
                $Category->status = $request->status;
                $Category->save();
                
                // save image here
                if(!empty($request->image_id)){
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.',$tempImage->name);
                    $ext = last($extArray);


                    $newImageName = $Category->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);


                    $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                     $img = Image::make($sPath);
                     $img->resize(450,600);
                     $img->save($dPath);

                    $Category->image = $newImageName;
                    $Category->save();
                }
                $request->session()-> flash('success','Category added successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'Category added successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function edit($CategoryID,Request $request){
        $Category = Category::find($CategoryID);
        
        if(empty($Category)){
            $request->session()->flash('error','category not found');
            return redirect()->route('category.index');
        }
        $Suppiler = suppiler::orderBy('suppiler_name','ASC')->get();
        $data['Suppiler'] = $Suppiler;
      
        return view('admin.category.edit',compact('Category'),$data);
    }
    public function update($CategoryID,Request $request){
        $Category = category::find($CategoryID);
        if(empty($Category)){
            $request->session()->flash('error','category not found');
            return response()->json([
                'status' => false,
                'notfound'=>true,
                'message' => 'category not found'
            ]);
        }
        $validatior= Validator::make($request->all(),[
            'category_name'=>'required',
            'suppiler'=>'required',
            'status'=>'required',
            'category_code'=>'required|unique:Category,category_code,'.$Category->id.',id',
        ]);
            if($validatior->passes()){
                $Category->category_code = $request->category_code;
                $Category->category_name = $request->category_name;        
                $Category->suppiler_id = $request->suppiler;
                $Category->status = $request->status;
                $Category->save();
            
                $request->session()-> flash('success','category updated successfully');
                return response()->json([
                    'status'=>true,
                    'message'=>'category updated successfully'
                ]);
            }else{
                return response()->json([
                    'status' =>true,
                    'errors' =>$validatior->errors()
                ]);
            }
      
    }
    public function destroy($CategoryID,Request $request){
        $Category = category::find($CategoryID);

        if(empty($Category)){
            $request->session()-> flash('error','category not found');
                return response()->json([
                    'status'=>true,
                    'message'=>'category not found'
                ]);
            // return redirect()->route('category.index');
        }
        $Category->delete();
        $request->session()-> flash('success','category deleted successfully');
       return response()->json([
            'status' =>true,
            'message' =>'category deleted successfully'
        ]);
    }
}


