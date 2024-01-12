<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	
	public function index()
	{
       	$this->home_m->home(); 
	}

	public function login(){	
		$this->home_m->login();
	}

	public function estimate()
	{
		$this->home_m->estimate();
	}

	public function client(){
		$this->load->view('objects/clientform');
	}

	public function contact(){
		$this->home_m->contact();
	}

	public function send_all()
	{
		$data = $_POST;
		//print_r($data);
		if ($data['name'] == "" or $data['email'] == "" or $data['message'] == "")
		{
			echo "<span style='color:red;'>Please fill do not leave anything blank.</span>";
		} else {
			$this->db->insert("contact",$data);
			$result = $this->all_m->sendmail("brent@trinitydoors.us","Contact Us From TrinityDoors Website",$data['message']);
			//$result = mail("brent@medtrio.com","Contact Us From TrinityDoors Website",$data['message']);
			echo "$result Someone will contact you soon!";
		}

	}

	public function add_item()
	{
		$data = $_POST;
		//print_r($data);
		$param = $data;
		
		$getID = $this->db->query('select id from email_estimate order by id desc limit 1')->result();
		unset($param['QTY']);
		unset($param['pHeight']);
		unset($param['pWidth']);
		//$param['id_estimate'] = $getID[0]->id + 1;
		$this->db->insert('estimate_items',$param);
		$this->load->view('objects/estimate_item',$data);
	}

	public function get_estimate()
	{
		$data['estimate'] = $this->db->get('email_estimate')->result();
		$this->load->view('home/header');
        $this->load->view('home/get_estimate',$data);
        $this->load->view('home/footer');
	
	}
	
	public function single_estimate($id)
	{
		$data['estimate'] = $this->db->where('id',$id)->get('email_estimate')->result();
		$this->load->view('home/header');
        $this->load->view('home/get_estimate',$data);
        $this->load->view('home/footer');
	
	}

	public function  email_estimate()
	{
		$data = $_POST;
		//print_r($data);
		$to="all@trinitydoors.us";
		//$to="bluyet@gmail.com";
		//$to="brent@medtrio.com";
		$subject="Customer Estimate";
		$message="
		A customer has filled out our Estimation program.<br>
		$data[firstName] <br>
		$data[lastName], <br>
		$data[company] $data[phone],<br>
		$data[email]<br><br>

		Estimate:<br>
		$data[big_estimate]
		<br><br>
		Total: $data[gt]
		";
		$param['firstName'] = $data['firstName'];
		$param['lastName'] = $data['lastName'];
		$param['company'] = $data['company'];
		$param['phone'] = $data['phone'];
		$param['email'] = $data['email'];
		$param['estimate'] = $data['big_estimate'];
		$param['total'] = $data['gt'];
		$param['address'] = $data['address'];
		$getID = $this->db->query('select id from email_estimate order by id desc limit 1')->result();
		$this->db->set('id_estimate',$getID[0]->id + 1)->where('id_estimate',$data['id_estimate'])->update('estimate_items');
		$this->db->insert('email_estimate',$param);
		//$client = $this->home_m->getREST('client');
		//print_r($client);
		//print_r($message);
		$this->all_m->sendmail($to,$subject,$message);
		$this->home_m->thankyou();
	}

	public function delete_estimate($id)
	{
		$data['estimate'] = $this->db->where('id',$id)->delete('email_estimate');
		$this->get_estimate();
	}


	//public function postREST()
	//{
	//	echo $this->home_m->getREST(inv);	
	//}

		public function chat($q){
			$g = $this->home_m->chat_gpt($q);
			print_r($g);
		}

}