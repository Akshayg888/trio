<?php  $this->load->view('layouts/header'); ?>
<div class="m-3">
    <div class="row">
        <div class="col-12 mb-3 mb-lg-5">
            <div class="overflow-hidden card table-nowrap table-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="col-md-9">
                    	<nav aria-label="breadcrumb">
						    <ol class="breadcrumb">
						        <?php echo $bredcrumbs; ?>
						    </ol>
						</nav>
					</div>
                </div>
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-cog"></i> <?php echo $pagetitle; ?> </h5> 
                </div>
                <?php  
			    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
					echo form_open_multipart('company/add/'.$id,$attributes);

					$name = set_value('name');
					$data_name = array(
							'name'		=> 'name',
							'id'		=> 'name',
							'value'		=> $name,
							'class'		=> 'form-control',
							'required' 	=> 'required',
							'placeholder' => 'Name'
					);

					$company_name = set_value('company_name');
					$data_company_name = array(
							'name'		=> 'company_name',
							'id'		=> 'company_name',
							'value'		=> $company_name,
							'class'		=> 'form-control',
							'required' 	=> 'required',
							'placeholder' => 'Company Name'
					);

					$designation = set_value('designation');
					$data_designation = array(
							'name'		=> 'designation',
							'id'		=> 'designation',
							'value'		=> $designation,
							'class'		=> 'form-control',
							'placeholder' => 'Designation'
					);

					$email_id = set_value('email_id');
					$data_email_id = array(
							'name'		=> 'email_id',
							'id'		=> 'email_id',
							'value'		=> $email_id,
							'class'		=> 'form-control',
							'required' 	=> 'required',
							'placeholder' => 'Email Id'
					);
		   		?>
      				<div class="form-body py-4 px-5">
      				<?php
      					if(validation_errors()){?>
				        	<div class="alert alert-danger display-hide" style="display: block;">
				            You have some form errors. Please check below. </div>
					<?php } ?>
					<?php if(isset($_SESSION['suc_msg'])){ ?> 
					 	<div style="display: block;" class="m-2 alert-<?php echo $_SESSION['msg-type']; ?>">
					  	<?php echo $_SESSION['suc_msg'];
							unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
					  	?>
						</div>
					<?php } ?>		
	                	<div class="row py-2">
	                		<div class="col-md-6">
								<div class="form-group">
              						<label class="control-label" for="name"> Name <span class="required text-danger" aria-required="true" > *</span> </label>
			  						<?php echo form_input($data_name) ?>
               						<span class="help-block help-block-error" for="name" style="color:#F30;"><?php echo form_error('name'); ?></span>
								</div>
	                		</div>
	                		<div class="col-md-6">
								<div class="form-group">
              						<label class="control-label" for="company_name"> Company Name <span class="required text-danger" aria-required="true" > *</span> </label>
			  						<?php echo form_input($data_company_name) ?>
               						<span class="help-block help-block-error" for="company_name" style="color:#F30;"><?php echo form_error('company_name'); ?></span>
								</div>
	                		</div>
	                	</div>
	                	<div class="row py-2">
	                		<div class="col-md-6">
								<div class="form-group">
              						<label class="control-label" for="designation"> Designation </label>
			  						<?php echo form_input($data_designation) ?>
               						<span class="help-block help-block-error" for="designation" style="color:#F30;"><?php echo form_error('designation'); ?></span>
								</div>
	                		</div>
	                		<div class="col-md-6">
								<div class="form-group">
              						<label class="control-label" for="email_id"> Email Id <span class="required text-danger" aria-required="true" > *</span> </label>
			  						<?php echo form_input($data_email_id) ?>
               						<span class="help-block help-block-error" for="email_id" style="color:#F30;"><?php echo form_error('email_id'); ?></span>
								</div>
	                		</div>
	                	</div>
	                </div>
					<div class="row py-2 px-5 bg-light border-top">
                        <div class="col-12 text-end">
                            <button class="btn btn-danger" name="submit" value="Submit" type="submit"> Submit <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                        </div>
                    </div>
				<?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php  $this->load->view('layouts/footer'); ?>