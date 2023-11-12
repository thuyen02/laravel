<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\products;
use App\Models\suppiler;
use App\Models\unit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('front.dashboard.index');
    }
    public function product(Request $request ){
      
            $Products =products::latest();
            if(!empty($request->get('keyworld'))){
               $Products =$Products->where('product_code','like','%'.$request->get('keyworld').'%');
            }
           $Products =$Products->paginate(5);
            return view('front.products.show',compact('Products'));
       
}

public function suppiler(Request $request){
    $Suppiler =suppiler::latest();
    if(!empty($request->get('keyworld'))){
       $Suppiler =$Suppiler->where('suppiler_code','like','%'.$request->get('keyworld').'%');
    }
   $Suppiler =$Suppiler->paginate(10);
    return view('front.suppliers.index',compact('Suppiler'));
}
public function category(Request $request){
    $Category =category::latest();
    if(!empty($request->get('keyworld'))){
       $Category =$Category->where('category_code','like','%'.$request->get('keyworld').'%');
    }
   $Category =$Category->paginate(8);
    return view('front.categories.index',compact('Category'));
}


public function  unit(Request $request){
    $Unit = unit::latest();
    if(!empty($request->get('keyworld'))){
        $Unit = $Unit->where('unit_code','like','%'.$request->get('keyworld').'%');
    }
    $Unit = $Unit->paginate(10);
    return view('front.units.index',compact('Unit'));
}
}