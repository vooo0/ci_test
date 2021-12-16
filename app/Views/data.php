<?= $this->extend("app") ?>

<?= $this->section("body") ?>

<nav class="navbar navbar-default navbar-static-top">
     <div class="container">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="#">TEST</a>
       </div>
       <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
           <li class="active"><a href="#">TEST</a></li>
         </ul>
       </div>
     </div>
</nav>
	
<div class="wrapper">
	
<div class="container">
					
	<div class="col-lg-12">
	
		<div class="panel panel-default">
            <div class="card mt-5">
                    <div class="panel-heading">
						<button data-toggle="modal" data-target="#addModal" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add barang</button>
                    </div>       
					
			<div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
								<th>name</th>
                                <th>kategori</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">	
							
                        </tbody>
                    </table>
                </div>
            </div>
			
            </div>

			<!-- Add Modal Start-->
			<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title" id="ModalLabel">Create New barang</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<form id="addbarang" class="form-horizontal">
					  <div class="form-group">
						<label class="control-label col-sm-2">name:</label>
						<div class="col-sm-10">
						  <input type="text" id="txt_name" class="form-control" placeholder="enter name">
						  <span id="error_name" class="text-danger"></span>
						</div>
					  </div>
					  <div class="form-group">
						<label class="control-label col-sm-2">kategori:</label>
						<div class="col-sm-10">
						  <input type="text" id="txt_kategori" class="form-control" placeholder="enter kategori">
						  <span id="error_kategori" class="text-danger"></span>
						</div>
					  </div>
					</form>		
				  </div>
				  <div class="modal-footer">
					<button type="button" id="btn_insert" class="btn btn-success">Insert</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- Add Modal End-->
			
			<!-- Update Modal Start-->
			<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title" id="ModalLabel">Update barang</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
				  
					<form id="updatebarang" class="form-horizontal">
					  <div class="form-group">
						<label class="control-label col-sm-2">name:</label>
						<div class="col-sm-10">
						  <input type="text" id="name_update" class="form-control" placeholder="enter name">
						  <span id="error_name_update" class="text-danger"></span>
						</div>
					  </div>
					  <div class="form-group">
						<label class="control-label col-sm-2">kategori:</label>
						<div class="col-sm-10">
						  <input type="text" id="kategori_update" class="form-control" placeholder="enter kategori">
						  <span id="error_kategori_update" class="text-danger"></span>
						</div>
					  </div>
					  
					  <input type="hidden" id="hidden_id">
					  
					</form>					
				  </div>
				  <div class="modal-footer">
					<button type="button" id="btn_update" class="btn btn-primary">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- Update Modal End-->
		
        </div>
			
	</div>
		
</div>
			
</div>

<?= $this->endSection() ?>

<?= $this->section("body") ?>

<script>

	$(document).ready(function(){
		
		displaybarang();
		
		$(document).on('click','#btn_insert',function(){
			
			var name = $('#txt_name').val();
			var kategori = $('#txt_kategori').val();
			
			if(name == ''){ 
				error_name = 'please enter name'; 
				$('#error_name').text(error_name);
			}
			else if(kategori == ''){ 
				error_kategori = 'please enter kategori'; 
				$('#error_kategori').text(error_kategori);
			}
			else{
				$.ajax({
					url:'<?= site_url('create-barang') ?>',
					method:'post',
					data:
						{
							barang_name:name,
							barang_kategori:kategori
						},
					success:function(response){
				
						$('#addModal').modal('hide');
						$('#addModal').find('input').val('');
						$('#error_name').text('');
						$('#error_kategori').text('');
						
						$('#tableData').html('');
						
						displaybarang();
						
						swal("Inserted", response.status, "success");
					}
				});
			}
			
		});
		
		$(document).on('click','#btn_edit', function(){
			
			var barang_id = $(this).attr('table-id');
			
			$.ajax({
				url:'<?= site_url('edit-barang') ?>/',
				method:'get',
				data:{sid:barang_id},
				success:function(response){
					$('#updateModal').modal('show');
					$('#name_update').val(response.row.name);
					$('#kategori_update').val(response.row.kategori);
					$('#hidden_id').val(response.row.barang_id);
				}
			});
			
		});
		
		$(document).on('click','#btn_update', function(){
			
			var name = $('#name_update').val();
			var kategori = $('#kategori_update').val();
			var hiddenId = $('#hidden_id').val();
			
			if(name == ''){ 
				error_name = 'please enter name'; 
				$('#error_name_update').text(error_name);
			}
			else if(kategori == ''){ 
				error_kategori = 'please enter kategori'; 
				$('#error_kategori_update').text(error_kategori);
			}
			else{
				$.ajax({
					url:'<?= site_url('update-barang') ?>',
					method:'post',
					data:
						{
							update_name:name,
							update_kategori:kategori,
							update_id:hiddenId
						 },
					success:function(response){
				
						$('#updateModal').modal('hide');
						$('#error_name_update').text('');
						$('#error_kategori_update').text('');
						
						$('#tableData').html('');
						
						displaybarang();
						
						swal("Updated", response.status, "success");
					}
				});
			}
			
		});
		
		$(document).on('click','#btn_delete', function(){
			
			var barang_id = $(this).attr('table-id');
			
			$.ajax({
				url:'<?= site_url('delete-barang') ?>/',
				method:'get',
				data:{delete_id:barang_id},
				success:function(response){
					
					swal("Deleted", response.status, "success");
					
					$('#tableData').html('');
					
					displaybarang();
				}
			});
			
		});
		
			
	});
	
	function displaybarang()
	{
		$.ajax({
			url:'<?= site_url('fetch-barang') ?>',
			method:'get',
			success:function(response){
				$.each(response.allbarangs,function(key, value){
					$('#tableData').append('<tr>\
						<td> '+value['barang_id']+' </td>\
						<td> '+value['name']+' </td>\
						<td> '+value['kategori']+' </td>\
						<td>\
							<a id="btn_edit" table-id='+value['barang_id']+' data-toggle="modal" data-target="#updateModal" class="btn btn-warning">Edit</a>\
						</td>\
						<td>\
							<a id="btn_delete" table-id='+value['barang_id']+' class="btn btn-danger">Delete</a>\
						</td>\
					</tr>');
				});
			}
			
		});
		
	}
	
</script>

<?= $this->endSection() ?>
