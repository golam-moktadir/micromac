<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
	public function index(){
        $brands = Brand::orderBy('created_at', 'desc')->get();
        return view('brand_info', ['brands' => $brands]);
    }

    public function addBrand(Request $request){

		$validator = Validator::make($request->all(), [
			'brand_name' => 'required|string|max:50|unique:brands'
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

        $brand = new Brand();
        $brand->brand_name  = $request->brand_name;
        $brand->save();
      	return response()->json(['success' => 'Brand has been added successfully']);
    }

    public function getSingleBrand($brand_id){
    	$brand = Brand::where('brand_id', $brand_id)->first();
    	echo json_encode($brand);
    }

    public function updateBrand(Request $request){
		
		$validator = Validator::make($request->all(), [
			'brand_name' => [
							'required', 
							'string', 
							'max:50',
							Rule::unique('brands')->ignore($request->brand_id, 'brand_id')
						]
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

        Brand::where('brand_id', $request->brand_id)
                ->update(['brand_name' => $request->brand_name]);
      	return response()->json(['success' => 'Brand has been updated successfully']);
    }

    public function deleteBrand($brand_id){
        Brand::where('brand_id', $brand_id)->delete();
        return redirect('brand-info')->with('success', 'Delete successful !');
    }
}
