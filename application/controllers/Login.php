<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 *  
		Code by : Yousaf Hassan
		Email : usafhassan@gmail.com
	 */
	 
	function __construct()
    {
        parent::__construct();
		if($this->session->userdata('admin_logged_in')){
			redirect('home');
			exit();
		}
    }
	 
	public function index()
	{
		$this->load->view('login');
	}
	
	public function validate()
	{
		$this->form_validation->set_rules('email','Email','trim|required|xss_clean');
		$this->form_validation->set_rules('password','Password','trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
		
		if( $this->form_validation->run()==false )
		{
			echo validation_errors();
		}
		else
		{
			$email = $this->input->post('email');
			$pass = hash("SHA256", $this->input->post('password') . $this->config->item('encryption_key') );
			$validated = $this->Common_Model->get_single_row(TBL_ADMIN,array('admin_email'=>$email,'admin_password'=>$pass));
			if($validated){
				$sess_array = array(
						'admin_id' => $validated->admin_id,
						'admin_name' => $validated->admin_fname .' '.$validated->admin_lname,
						'admin_fname' => $validated->admin_fname,
						'admin_lname' => $validated->admin_lname,
						'admin_email' => $email,
						'admin_sign' => $validated->admin_sign,
						'region_id' => $validated->region_id,
						'admin_logged_in' => true
				);
				$this->session->set_userdata($sess_array);
			echo '1';
			}else echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>Invalid username or password.</p></div>';
		}
		
	}
}