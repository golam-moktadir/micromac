<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
	public function index(){
        //$items = Item::orderBy('created_at', 'desc')->get();
        $items = DB::table('items')
        			->join('brands', 'brands.brand_id', '=', 'items.brand_id')
        			->join('models', 'models.model_id', '=', 'items.model_id')
        			->select('items.*', 'models.model_name', 'brands.brand_name')
        			->orderBy('items.created_at', 'desc')->get();
        //dd($items);
        $models = DB::table('models')->get();
        $brands = Brand::all();
        return view('item_info', [ 'items' => $items, 'models' => $models, 'brands' => $brands]);
    }

    public function addItem(Request $request){

		$validator = Validator::make($request->all(), [
			'item_name' => 'required|string|max:150|unique:items',
			'brand_id' => 'required|integer',
			'model_id' => 'required|integer'
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

        $item = new Item();
        $item->item_name  = $request->item_name;
        $item->brand_id = $request->brand_id;
        $item->model_id = $request->model_id;
        $item->save();
      	return response()->json(['success' => 'Item has been added successfully']);
    }

    public function getSingleItem($item_id){
    	$item = Item::where('item_id', $item_id)->first();
    	echo json_encode($item);
    }

    public function updateItem(Request $request){
		
		$validator = Validator::make($request->all(), [
			'item_name' => [
							'required', 
							'string', 
							'max:150',
							Rule::unique('items')->ignore($request->item_id, 'item_id')
						],
			'brand_id' => [
							'required', 
							'integer'
						],
			'model_id' => [
							'required', 
							'integer'
						]
		]);

      	if($validator->fails()){
        	return response()->json(['errors' => $validator->errors()]);
      	}

        Item::where('item_id', $request->item_id)
                ->update([
                	'brand_id' => $request->brand_id,
                	'model_id' => $request->model_id,
                	'item_name' => $request->item_name
                ]);
      	return response()->json(['success' => 'Item has been updated successfully']);
    }

    public function deleteItem($item_id){
        Item::where('item_id', $item_id)->delete();
        return redirect('item-info')->with('success', 'Delete successful !');
    }
}
