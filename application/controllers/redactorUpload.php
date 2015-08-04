<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RedactorUpload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('ion_auth');
				
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			
			redirect('/login');
		
		}		
				
	}
	
	/*
		processes file uploads from the redactor editor
	*/
	
	public function upFile()
	{
	
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('file')) {
			
			$error = array('error' => $this->upload->display_errors());
		
			print_r($error);
		
		} else {
			
			$fileData = $this->upload->data();
			
			$subfolder = parse_url(base_url(), PHP_URL_PATH);	
			$subfolder = rtrim($subfolder, "/");
			
			$array = array(
			    'filelink' => $subfolder.'/uploads/'.$fileData['file_name'],
			    'filename' => $fileData['file_name']
			);
			
			echo stripslashes(json_encode($array));
				
		}
	
	}
	
	
	/*
		processes imageuploads from the redactor editor
	*/
	
	public function upImage()
	{
	
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('file')) {
			
			$error = array('error' => $this->upload->display_errors());
		
			print_r($error);
		
		} else {
			
			$fileData = $this->upload->data();
			
			$subfolder = parse_url(base_url(), PHP_URL_PATH);	
			$subfolder = rtrim($subfolder, "/");
			
			$array = array(
			    'filelink' => $subfolder.'/uploads/'.$fileData['file_name'],
			    'filename' => $fileData['file_name']
			);
			
			echo stripslashes(json_encode($array));
				
		}
	
	}
	
}

/* End of file redactorUpload.php */
/* Location: ./application/controllers/redactorUpload.php */