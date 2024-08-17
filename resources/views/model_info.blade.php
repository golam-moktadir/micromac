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
				@foreach($models as $model)
				<tr>
					<td>{{ $index++ }}</td>
					<td>{{ $model->model_name }}</td>
					<td>{{ $model->brand_name }}</td>
					<td>{{ date('d/m/Y', strtotime($model->created_at)) }}</td>
					<td>
						<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editModel('{{$model->model_id}}');">Edit</a>
						<a href="{{url('model-delete/'.$model->model_id)}}" onclick="return confirm('Are You Sure to delete the selected model ?');" class="btn btn-primary btn-sm">Delete</a>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			</div>
		</div>
<!-- 	   <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#brand-modal">Add Brand</button> -->
	   <button class="btn btn-sm btn-primary" onclick="newModel();">Add Model</button>
	    <!-- Modal -->
	    <div class="modal fade" id="model-modal" data-bs-backdrop="static">
	      <div class="modal-dialog modal-dialog-scrollable modal-md">
	        <div class="modal-content">
	            <div class="modal-header">
	               <h5 class="modal-title" id="modal-title">Add Model</h5>
	               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <div class="modal-body">
	               <div class="container-fluid">
		               <form id='model-form'>
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
									<input type="hidden" id="model_id" name="model_id">
									<label for="model_name" class="form-label">Model Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="model_name" name="model_name">
									<p id="error_model_name" class="text-danger"></p>
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
		$('#model-form').on('submit', function(e) {
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
		    			if(response.errors.model_name){
		        			$('#error_model_name').text(response.errors.model_name[0]);
		        		}
		        	}
		        	else{
		        		alert(response.success);
		        		$('#model-modal').modal('hide');
						window.location.href = "model-info";
		        	}
		      }
		  	});
		});
	});
	
	let action_url = null;
	function newModel(){
	    $('#model-modal').modal('show');
	    $("#brand_id").val('');
	    $("#model_name").val('');
	    $("#modal-title").text('Add Model');
	    $("#submit").val('Add');
	    action_url = 'model-add';
	}

	function editModel(model_id){
	 	$.ajax({
	    	url: 'get-single-model/'+model_id, 
	    	dataType:'json',
	    	success: function(response){
				$("#brand_id").val(response.brand_id);
				$("#model_id").val(response.model_id);
				$("#model_name").val(response.model_name);
				$('#model-modal').modal('show');
				$("#modal-title").text('Edit Brand');
				$("#submit").val('Update');
				action_url = 'model-update';
	      }
	  	});
	}
	</script>
</body>
</html>