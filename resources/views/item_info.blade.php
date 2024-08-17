<!DOCTYPE html>
<html>
<head>
	<title>MicroMac Techno Valley Ltd</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.js')}}"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<table class="table table-sm table-striped table-bordered border-primary table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Item Name</th>
						<th scope="col">Model Name</th>
						<th scope="col">Brand Name</th>
						<th scope="col">Entry Date</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
				@php
				$index = 1;
				@endphp
				@foreach($items as $item)
				<tr>
					<td>{{ $index++ }}</td>
					<td>{{ $item->item_name }}</td>
					<td>{{ $item->model_name }}</td>
					<td>{{ $item->brand_name }}</td>
					<td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
					<td>
						<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editItem('{{$item->item_id}}');">Edit</a>
						<a href="{{url('item-delete/'.$item->item_id)}}" onclick="return confirm('Are You Sure to delete the selected item ?');" class="btn btn-primary btn-sm">Delete</a>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			</div>
		</div>
<!-- 	   <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#brand-modal">Add Brand</button> -->
	   <button class="btn btn-sm btn-primary" onclick="newItem();">Add Item</button>
	    <!-- Modal -->
	    <div class="modal fade" id="item-modal" data-bs-backdrop="static">
	      <div class="modal-dialog modal-dialog-scrollable modal-md">
	        <div class="modal-content">
	            <div class="modal-header">
	               <h5 class="modal-title" id="modal-title">Add Item</h5>
	               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <div class="modal-body">
	               <div class="container-fluid">
		               <form id='item-form'>
		                @csrf
							<div class="row">
								<div class="col-md-12">
								<label for="brand_id" class="form-label">Brand Name <span class="text-danger">*</span></label>
								<select class="form-control" id="brand_id" name="brand_id">
										<option value="">--Select Brand--</option>
									@foreach($brands as $brand)
										<option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
									@endforeach
								</select>
								<p id="error_brand" class="text-danger"></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="model_id" class="form-label">Model Name <span class="text-danger">*</span></label>
									<select class="form-control" id="model_id" name="model_id">
											<option value="">--Select Model--</option>
										@foreach($models as $model)
											<option value="{{$model->model_id}}">{{$model->model_name}}</option>
										@endforeach
									</select>
									<p id="error_model" class="text-danger"></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" id="item_id" name="item_id">
									<label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="item_name" name="item_name">
									<p id="error_item_name" class="text-danger"></p>
								</div>
							</div>
		                 <div class="row my-1">
		                    <div class="col-md-6">
		                      <input type="submit" id="submit" class="btn btn-primary btn-sm" value="Add" />
		                    </div>
		                  </div>
		               </form>                  
	               </div>
	            </div>
<!-- 	            <div class="modal-footer">
	               <button class="btn btn-primary btn-sm" data-bs-dismiss='modal'>Save</button>
	               <button class="btn btn-danger btn-sm" data-bs-dismiss='modal'>Close</button>
	            </div> -->
	        </div>
	      </div>
	    </div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#item-form').on('submit', function(e) {
			e.preventDefault(); 
		 	var formData = $(this).serialize(); 
		 	$.ajax({
		    	url: action_url, 
		    	type: 'post',
		    	data: formData,
		    	success: function(response){
		      		//console.log(response);
		    		if(response.errors){
		    			if(response.errors.brand_id){
		        			$('#error_brand').text(response.errors.brand_id[0]);
		        		}
		    			
		    			if(response.errors.model_id){
		        			$('#error_model').text(response.errors.model_id[0]);
		        		}

		    			if(response.errors.item_name){
		        			$('#error_item_name').text(response.errors.item_name[0]);
		        		}
		        	}
		        	else{
		        		alert(response.success);
		        		$('#item-modal').modal('hide');
						window.location.href = "item-info";
		        	}
		      }
		  	});
		});
	});
	
	let action_url = null;
	function newItem(){
	    $('#item-modal').modal('show');
	    $("#brand_id").val('');
	    $("#model_id").val('');
	    $("#item_name").val('');
	    $("#modal-title").text('Add Item');
	    $("#submit").val('Add');
	    action_url = 'item-add';
	}

	function editItem(item_id){
	 	$.ajax({
	    	url: 'get-single-item/'+item_id, 
	    	dataType:'json',
	    	success: function(response){
				$("#brand_id").val(response.brand_id);
				$("#model_id").val(response.model_id);
				$("#item_id").val(response.item_id);
				$("#item_name").val(response.item_name);
				$('#item-modal').modal('show');
				$("#modal-title").text('Edit Item');
				$("#submit").val('Update');
				action_url = 'item-update';
	      }
	  	});
	}
	</script>
</body>
</html>