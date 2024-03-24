<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends CI_Controller {
	function __construct(){
		parent::__construct();
	  	$this->load->model('common_model');

	}
	//data table listing 
	public function index() {
		$data['menutitle'] = 'Company';
		$data['pagetitle'] = 'Manage Company';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Company</li></ul>';
			// echo "<pre>";print_r($data);die();
		$this->load->view('company/company_manage',$data);
	}

	// add and edit company details
	public function add($id = '') {
		$data['menutitle'] = 'Company';
		$data['pagetitle'] = 'Add Company';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'">Home</a> <i class="fa fa-angle-right"></i> </li><li> <a href="'.base_url().'company">Manage Company</a></li><li><i class="fa fa-angle-right"></i> Add Company</li></ul>';
		$tableName = 'company';
		$condition = ['id' => $id, 'status' => 'Active'];
		$order = 'id desc';

		$company_detail = $this->common_model->getData($tableName, $condition,$order);
		$data['company_detail'] = $company_detail;
		
		$data['id'] = $id;
		//echo "<pre>"; print_r($data);die();

		if (trim($this->input->post('submit')) =='' && $id =='') {
			$this->load->view('company/add_company',$data);
		} elseif(trim($this->input->post('submit')) =='' && $id > 0){
			$data['pagetitle'] = 'Edit Company';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'">Home</a> <i class="fa fa-angle-right"></i> </li><li> <a href="'.base_url().'company">Manage Company</a></li><li><i class="fa fa-angle-right"></i> Edit Company</li></ul>';
			$this->load->view('company/edit_company',$data);
		} elseif (trim($this->input->post('submit')) =='Submit') {
		
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
			$this->form_validation->set_rules('designation', 'Designation', 'trim');
			if ($id =='') {
				$this->form_validation->set_rules('email_id', 'Email Id', 'trim|valid_email|required|is_unique[company.email_id]');
			}else{
				$this->form_validation->set_rules('email_id', 'Email Id', 'trim|valid_email|required');
			}
						
			if ($this->form_validation->run($this) == FALSE){
				$company_detail['name'] = trim($this->input->post('name'));
				$company_detail['company_name'] = trim($this->input->post('company_name'));
				$company_detail['designation'] = trim($this->input->post('designation'));				
				$company_detail['email_id'] = trim($this->input->post('email_id'));				
				$data['company_detail'] = $company_detail;
				if ($id =='') {
					$this->load->view('company/add_company',$data);
				}else{
					$this->load->view('company/edit_company',$data);
				}
			}else{
				$data_insert['name'] = trim($this->input->post('name'));
				$data_insert['company_name'] = trim($this->input->post('company_name'));
				$data_insert['designation'] = trim($this->input->post('designation'));
				$data_insert['email_id'] = trim($this->input->post('email_id'));
				$data_insert['status'] = 'Active';
				// echo "<pre>"; print_r($data_insert);die();
				if ($id =='') {
					$returnId = $this->common_model->addData('company', $data_insert, $id);
					if($returnId > 0){
						$arr_msg = array('suc_msg'=>'Company added successfully!!!','msg-type'=>'success');
					}else{
						$arr_msg = array('suc_msg'=>'Failed to add company', 'msg-type'=>'danger');
					}
				}else{
					$condition = ['id' => $id];
					$returnId = $this->common_model->updateData('company', $condition, $data_insert);
					if($returnId > 0){
						$arr_msg = array('suc_msg'=>'Company details update successfully!!!','msg-type'=>'success');
					}else{
						$arr_msg = array('suc_msg'=>'Failed to update Company', 'msg-type'=>'danger');
					}
				}
				$this->session->set_userdata($arr_msg);
				redirect('company');
			}
		}
	}

	// Delete a perticular company by id
	public function close() {
		$id = $this->input->post('id');
		if ($id > 0) {
			$data_insert = array();
			$data_insert['status'] = 'In-Active';
			$condition = ['id' => $id];
			$returnId = $this->common_model->updateData('company', $condition, $data_insert);
			echo $returnId;
		}else {
			echo 0;
		}
	}

	// Delete All selected company in bulk
	public function bulk_close() {
		$selected_id = $this->input->post('selected_id');
		if (sizeof($selected_id) > 0) {
			foreach ($selected_id as $key => $value) {
				$data_insert = array();
				$data_insert['status'] = 'In-Active';
				$condition = ['id' => $value];
				$returnId = $this->common_model->updateData('company', $condition, $data_insert);
			}
			$arr_msg = array('suc_msg'=>'Delete all selected company successfully', 'msg-type'=>'success');
		}else{
			$arr_msg = array('suc_msg'=>'Failed to delete selected company', 'msg-type'=>'danger');
		}
		$this->session->set_userdata($arr_msg);
		redirect('company');
	}
	// get data for listing 
	public function getAllData(){
		$tableName = 'company';
		$condition = ['status' => 'Active'];
		$order = 'id desc';
		$companyList = $this->common_model->getData($tableName, $condition,$order,);
		$data['companyList'] = $companyList;

        echo json_encode($data);
	}
}
