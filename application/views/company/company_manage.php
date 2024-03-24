<?php  $this->load->view('layouts/header'); ?>
<div class="m-3">
    <div class="row">
        <div class="col-12 mb-3 mb-lg-5">
            <div class="overflow-hidden card table-nowrap table-card">
            	<?php  
			    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
					echo form_open_multipart('company/bulk_close/',$attributes);
				?>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-9">
                    	<nav aria-label="breadcrumb">
						    <ol class="breadcrumb">
						        <?php echo $bredcrumbs; ?>
						    </ol>
						</nav>
					</div>
                    <div class="col-md-3 text-end">
                    	<a href="<?php echo base_url();?>company/add" class="btn btn-success" title="Edit Company"  alt="Edit Company"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</a>

                        <!-- <button class="btn btn-danger" name="submit" value="Submit" type="submit" id="deleteButton"><i class="fa fa-trash" aria-hidden="true"></i> Delete </button> -->
                        <button class="btn btn-danger" name="submit" value="Submit" type="submit" id="deleteButton" disabled> <i class="fa fa-trash" aria-hidden="true"></i> Delete </button>

                    </div>
                </div>
                <div class="table-responsive">
                	<div class="">
	                	<?php
	                		if(validation_errors()){?>
					        	<div class="alert alert-danger display-hide" style="display: block;">
					            	You have some form errors. Please check below. </div>
						<?php } ?>
					</div>
					<div class="p-3">
						<table class="table mb-0" id="records">
	                        <thead>
		                        <tr>
		                            <th><input type="checkbox" name="selected_id[]" id="selectall"></th>
		                            <th>Name</th>
		                            <th>Company Name</th>
		                            <th>Designation</th>
		                            <th>Email ID</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                    <tbody id="data-table">

		                    </tbody >
	                    </table>
	                </div>
                </div>
				<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="close_company" tabindex="-1" role="basic" aria-hidden="true">
  	<div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	            <h4 class="modal-title">Cancel Order</h4>
	        </div>
	        <div class="modal-body">
				Are you sure to delete this order?
	        </div>
	        <div class="modal-footer">
	            <button type="button" class="btn btn-success default" id="yes">Yes</button>
	        	<button type="button" class="btn btn-light default" id="no" data-dismiss="modal">No</button>
	        </div>
	    </div>
   	</div>
</div>



<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
 
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>


<script type="text/javascript">
	function close_company(id) {
	$('#close_company').modal('show');
	$('#close_company #yes').click(function(){	
		var url = '<?php echo base_url(); ?>company/close';
		$.post(url, {
			id:id,
		},function(responseText){
			if(responseText == 1){				  
				location.href = '<?php echo base_url(); ?>company';
			}else {
			  	alert('Something went wrong with you');
			}
		});
	});
	$('#close_company #no').click(function(){
		$('#close_company').modal('hide');
	});
}
jQuery.noConflict();
jQuery(document).ready(function($) {
	function fetch() {
		$.ajax({
			url: "<?php echo base_url('company/getAllData');?>",
			type : "GET",
			dataType: "json",
			success: function(data){
					// console.log(data.companyList);

				$('#records').DataTable({
					"jQueryUI": true,
					"data" : data.companyList,
					"responsive" :true,
					"order": false,
					"columnDefs": [
			            { "orderable": false, "targets": "_all" },
			        ],
					"dom": 
					    "<'row'<'col-sm-12 col-md-3'f><'col-sm-12 col-md-4'p><'col-sm-12 col-md-2'B><'col-sm-12 col-md-2'l><'col-sm-12 col-md-1 resetall'>>" +
					    "<'row'<'col-sm-12'tr>>" +
					    "<'row'<'col-sm-12 col-md-12'i>>",
					    initComplete: function () {
					        $('.resetall').html('<button class="btn btn-sm btn-light">Reset Filters</button>'<?php 
					        	?>);
					    },
				    "buttons": [{
				    	extend: 'excel',
						title: 'Company List',
				    }],
					"columns": [
						{ "render": function ( data, type, row, meta ) {
					      var b = `
					      	<input type="checkbox" name="selected_id[]" value="${row.id}"/>
					      `;
					      return b;
					    } },
				        { "data": 'name' },
				        { "data": 'company_name' },
				        { "data": 'designation' },
				        { "data": 'email_id' },
				        { "render": function ( data, type, row, meta ) {
					      var a = `
					      	<a href="company/add/${row.id}" id="edit" class="btn btn-light" >Edit</a>
					      	<a href="javascript:void(0)" onclick="close_company(${row.id})"  id="delete" class="btn btn-danger" >Delete</a>
					      `;
					      return a;
					    } },
				    ],
				});
			}
		});
	}
	fetch();

    $("#selectall").change(function() {
        if (this.checked) {
            $("input[name='selected_id[]']").prop('checked', true);
        } else {
            $("input[name='selected_id[]']").prop('checked', false);
        }
    });
    function updateDeleteButtonState() {
        var checkedCheckboxes = $("input[name='selected_id[]']:checked");
        var deleteButton = $("#deleteButton");

        if (checkedCheckboxes.length > 0) {
            deleteButton.prop('disabled', false);
        } else {
            deleteButton.prop('disabled', true);
        }
    }
    
    $(document).on('change', "input[name='selected_id[]']", function() {
        updateDeleteButtonState();
    });
    updateDeleteButtonState();
});

</script>


<?php  $this->load->view('layouts/footer'); ?>