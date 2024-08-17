<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Model;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ModelController extends Controller
{
	public function index(){
        //$models = Model::orderBy('created_at', 'asc')->get();
        $models = DB::table('models')
        			->join('brands', 'brands.brand_id', '=', 'models.brand_id')
        			->select('models.*', 'brands.brand_name')
        			->orderBy('created_at', 'asc')->get();
        $brands = Brand::all();
        return view('model_info', ['models' => $models, 'brands' => $brands]);
    }

    public function addModel(Request $request){

		$validator = Validator::make($request->all(), [
			'model_name' => 'required|string|max:100|unique:models',
			'brand_id' => 'required|integer'
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

		DB::table('models')->insert([
		    'model_name' => $request->model_name,
		    'brand_id' => $request->brand_id,
		    'created_at' => date('Y-m-d H:i:s')
		]);
      	return response()->json(['success' => 'Model has been added successfully']);
    }

    public function getSingleModel($model_id){
		$model = DB::table('models')->where('model_id', $model_id)->first();
    	echo json_encode($model);
    }

    public function updateModel(Request $request){
		
		$validator = Validator::make($request->all(), [
			'model_name' => [
							'required', 
							'string', 
							'max:100',
							Rule::unique('models')->ignore($request->model_id, 'model_id')
						],
			'brand_id' => [
							'required', 
							'integer'
						]
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

		DB::table('models')
              ->where('model_id', $request->model_id)
              ->update([
              			'model_name' => $request->model_name, 
              			'brand_id'   => $request->brand_id,
              			'updated_at' => date('Y-m-d H:i:s')
              		]);
      	return response()->json(['success' => 'Model has been updated successfully']);
    }

    public function deleteModel($model_id){
		DB::table('models')->where('model_id', '=', $model_id)->delete();
        return redirect('model-info')->with('success', 'Delete successful !');
    }
}
