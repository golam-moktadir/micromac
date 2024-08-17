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
			<table id="brand-table" class="table table-sm table-striped table-bordered border-primary table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Brand Name</th>
						<th scope="col">Entry Date</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
				@php
				$index = 1;
				@endphp
				@foreach($brands as $brand)
				<tr>
					<td>{{ $index++ }}</td>
					<td>{{ $brand->brand_name }}</td>
					<td>{{ date('d/m/Y', strtotime($brand->created_at)) }}</td>
					<td>
						<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editBrand('{{$brand->brand_id}}');">Edit</a>
						<a href="{{url('brand-delete/'.$brand->brand_id)}}" onclick="return confirm('Are You Sure to delete the selected brand ?');" class="btn btn-primary btn-sm">Delete</a>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
			</div>
		</div>
<!-- 	   <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#brand-modal">Add Brand</button> -->
	   <button class="btn btn-sm btn-primary" onclick="newBrand();">Add Brand</button>
	    <!-- Modal -->
	    <div class="modal fade" id="brand-modal" data-bs-backdrop="static">
	      <div class="modal-dialog modal-dialog-scrollable modal-md">
	        <div class="modal-content">
	            <div class="modal-header">
	               <h5 class="modal-title" id="modal-title">Add Brand</h5>
	               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <div class="modal-body">
	               <div class="container-fluid">
		               <form id='brand-form'>
		                @csrf
							<div class="row">
								<div class="col-md-12">
								<label for="brand_name" class="form-label">Brand Name <span class="text-danger">*</span></label>
								<input type="hidden" id="brand_id" name="brand_id">
								<input type="text" class="form-control" id="brand_name" name="brand_name">
								<p id="error_brand_name" class="text-danger"></p>
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
		$('#brand-form').on('submit', function(e) {
			e.preventDefault(); 
		 	var formData = $(this).serialize(); 
		 	$.ajax({
		    	url: action_url, 
		    	type: 'post',
		    	data: formData,
		    	success: function(response){
		      		//console.log(response);
		    		if(response.errors){
		        		$('#error_brand_name').text(response.errors.brand_name[0]);
		        	}
		        	else{
		        		alert(response.success);
		        		$('#brand-modal').modal('hide');
						window.location.href = "brand-info";
		        	}
		      	}
		  	});
		});

		// $('#brand-table tr').click(function(){
		//     let brand_id = $(this).find('td:first').text();
		//     let brand_name = $(this).find('td:eq(2)').text();
		//     $("#brand_id").val(brand_id);
		//     $("#brand_name").val(brand_name);
		//     $('#brand-modal').modal('show');
		//     $("#modal-title").text('Edit Brand');
		//     $("#submit").val('Update');
		//     action_url = 'brand-update';
		// });
	});
	
	let action_url = null;
	function newBrand(){
	    $('#brand-modal').modal('show');
	    $("#brand_name").val('');
	    $("#modal-title").text('Add Brand');
	    $("#submit").val('Add');
	    action_url = 'brand-add';
	}

	function editBrand(brand_id){
	 	$.ajax({
	    	url: 'get-single-brand/'+brand_id, 
	    	dataType:'json',
	    	success: function(response){
			    $("#brand_id").val(response.brand_id);
			    $("#brand_name").val(response.brand_name);
			    $('#brand-modal').modal('show');
			    $("#modal-title").text('Edit Brand');
			    $("#submit").val('Update');
			    action_url = 'brand-update';
	      	}
	  	});
	}
	</script>
</body>
</html>