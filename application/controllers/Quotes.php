<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler();
	}
    public function index()
    {
		if (!isset($this->session->userdata['logged_in'])) {
            echo 'Please log in first';
        }
        else {
			$this->load->helper(array('form', 'url'));
			$logged_in = $this->session->userdata('logged_in');
			$all_quotes = $this->Quote->get_quotes_except_fav($logged_in['log_id']);
			$fav_quotes = $this->Quote->get_quotes_by_user_id($logged_in['log_id']);
	        $this->load->view('quotes', array('logged_in' => $logged_in,
											  'all_quotes' => $all_quotes,
										  	  'fav_quotes' => $fav_quotes));
        }
    }
	public function show_user($user_id)
	{
		if (!isset($this->session->userdata['logged_in'])) {
            echo 'Please log in first';
        }
        else {
		$quotes = $this->Quote->all_quotes_of_user_id($user_id);
		$this->load->view('users', array('quotes' => $quotes));
		}
	}
	public function add()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
        $this->form_validation->set_rules('author', 'Quoted By:', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('text', 'Message:', 'trim|required|min_length[10]');
		if ($this->form_validation->run() == FALSE)
        {
			$this->index();
        }
        else
        {
			$text = $this->input->post('text');
			$author = $this->input->post('author');
			$maker = $this->session->userdata('logged_in');
			$quote = array('text' => $text,
						  'author' => $author,
					  	  'maker' => $maker['alias'],
					  	  'users_id' => $maker['log_id']);
			$this->Quote->add_quote($quote);
			redirect('quotes');
        }
	}
	public function add_to_fav($quote_id)
	{
		$logged_in = $this->session->userdata('logged_in');
		$join = array('user_id' => $logged_in['log_id'],
	 				  'quote_id' => $quote_id);
		$this->Quote->add_item_to_fav($join);
		redirect('quotes');
	}
	public function remove_fav($quote_id)
	{
		$logged_in = $this->session->userdata('logged_in');
		$join = array('user_id' => $logged_in['log_id'],
					  'quote_id' => $quote_id);
	    $this->Quote->remove_fav_list($join);
	  	redirect('quotes');
	}
}
