<?php
class all_m extends CI_Model {
	
	function __construct()

    {

       parent::__construct();

    }

            

	function ndate($cdt)
	{
			$newDate = date_create($cdt);
		return $newDate->format('M d Y g:i a');
	}
	
	function cook_cookie($name, $value)
	{
		$usrcookie = array(
			'name'   => $name,
			'value'  => $value,
			'expire' => '86500'
			);
						
					$this->input->set_cookie($usrcookie);
	}
	
	function addDate($y=0,$m=0,$d=0)
	{
		$tomorrow = mktime(0,0,0,date("m") + $m,date("d") + $d,date("Y") + $y);
		return date("Y/m/d", $tomorrow);
	}
	function AddToDate($date,$y=0,$m=0,$d=0)
	{	
		
		$mdy = explode('-',$date);
		$this->firephp->error($mdy);
		if (strlen($mdy[2])==4)
		{
			$tomorrow = mktime(0,0,0,$mdy[0] + $m,$mdy[1] + $d,$mdy[2] + $y);
			return date("m/d/Y", $tomorrow);
		}
		else
		{
			//$this->firephp->error($mdy);
			$tomorrow = mktime(0,0,0,$mdy[1] + $m,$mdy[2] + $d,$mdy[0] + $y);
			return date("Y-m-d", $tomorrow);
		}
			
	}

	public function MemberPage($data)
	{
		$user = $this->db->where($data)->from('members')->get()->result();
		if (count($user) != 0) //if the query retuns something
		{
			$data['user'] = $user[0];
			$this->all_m->cook_cookie('email',$user[0]->email);
			$pos = $this->load->database('pos', TRUE);
			$membership = $this->check_membership($user[0]); //gets memebership id number.
			$data['membership'] = $membership;
			
			if ($membership != FALSE)
			{// when they have a membership
				$data['membership'] = $membership;
				$pos = $this->load->database('pos', TRUE);
				$m = $pos->where('unique_id',$membership)->from('pancake_invoices')->get()->result(); //matches unique_id with of invoice to varify membership
				$c = $pos->where('email', $user[0]->email)->from('pancake_clients')->get()->result(); //check for full membership
				if (count($m) != 0) // find the match 
				{
					$m = $m[0];
					$data['pos'] = $m;

				// check to see if they are a full member (all paperwork is turned in)
				if ($c[0]->is_member == 1)
				{
					$train = $pos->where('vendor_stock_number','training')->from('pancake_inventory')->get()->result();
					$data['train'] = $train;
					$ann = $this->db->where('id','1')->from('announcement')->get()->result();
					$data['announcement'] = $ann[0];
					$this->load->view('member/payedmemberfull', $data);
				} else {
					$this->load->view('member/payedmember',$data);
				}
					
					return TRUE;
				} else {// when they don't have a membership numer but had an old number
					//$data['membership'] = $membership;
										$orn = $pos->where('vendor_stock_number','orientation')->from('pancake_inventory')->get()->result();
					$month = $pos->where('vendor_stock_number','monthly')->from('pancake_inventory')->get()->result();
					$train = $pos->where('vendor_stock_number','train')->from('pancake_inventory')->get()->result();
					$data['orn'] = $orn;	
					$data['month']= $month;
					$data['train'] = $train;
					$this->load->view('member/home',$data);
					return TRUE;

					
				}
				
			} else { // when they don't have a membership numer
									//$data['membership'] = $membership;
				$orn = $pos->where('vendor_stock_number','orientation')->from('pancake_inventory')->get()->result();
				$month = $pos->where('vendor_stock_number','monthly')->from('pancake_inventory')->get()->result();
				$train = $pos->where('vendor_stock_number','train')->from('pancake_inventory')->get()->result();
				$data['orn'] = $orn;	
				$data['month']= $month;
				$data['train'] = $train;
				$this->load->view('member/home',$data);
				return TRUE;
			}
		} else {
			//echo "FALSE";
			return FALSE;
		}
	}

	public function check_membership($user){
		if ($user->id_membership != "0")
		{
			
			return $user->id_membership;
		} else {
			return FALSE;
		}
	}
	
	public function emailAlert($to,$subject,$message)
	{	
		
		if (empty($to));
		{
			$to = 'bluyet@gmail.com';
			$message = 'this is a test';
		}
		$this->load->library('email');
		$config['smtp_host'] = 'smtp.luyet.info';
		$config['smtp_user'] = 'brent@luyet.info';
		$config['smtp_pass'] = 'burnyouho';
		$config['smtp_port'] = '25';
		$config['mailtype'] = 'html';
		$config['charset']  = 'iso-8859-1';
		$config['newline']  = "\r\n";
		$config['wordwrap'] = TRUE;
		$config['protocol'] = 'sendmail';
		$this->email->initialize($config);
		$this->email->from('brent@luyet.info', 'Brent Luyet');
		$this->email->to($to);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
		//echo $this->email->print_debugger();	
		
	}
	
	public function isloggedin()
	{
		$loggedin = "";
		$loggedin = $this->session->userdata('name');
		
		if(empty($loggedin))
		{
			$data['error']="";
			header("location: http://www.medtrio.com/home/index");
			redirect(site_url('/home/'));
			}
		$security = $this->session->userdata('security');
		$exclude = array('store','users');
		if($security == "0")
		{
			for($i=0;$i <= count($exclude) - 1; $i++)
			{
				if(strpos($_SERVER['REQUEST_URI'],$exclude[$i])> 0)
				{
					redirect(site_url('/home/'));
				}
			}
		}
	}
	
	
	
	public function get_stores()
	{
		$data = $this->db->query("select idstore, name from store ")->result(); 
		return $data;
	}
	
	public function sendmail($to,$subject,$message)
	{
		$this->load->library('email');

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp-relay.sendinblue.com',
				'smtp_port' => 587,
				'smtp_user' => 'brent@trinitydoors.us', // change it to yours
				'smtp_pass' => 'vI8daN2KZX40WQGm', // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$config1 = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'bluyet@gmail.com', // change it to yours
				'smtp_pass' => 'qjff dujr ccsr lswt', // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$config2 = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp-relay.sendinblue.com',
				'smtp_port' => 587,
				'smtp_user' => 'brent@medtrio.com', // change it to yours
				'smtp_pass' => 'f6vnXzc579jJA4MR', // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('brent@trinitydoors.com'); // change it to yours
			$this->email->to($to);// change it to yours
			
			$this->email->subject($subject);
			$this->email->message($message);
		    if($this->email->send())
		    {
				return "Email sent.";
		    }
		    else
		    {
				show_error($this->email->print_debugger());
				return "error";
		    }
		
		
	
		
	}

	public function isclockedin()
	{
		
		$data['erorr'] = "";
		$iduser = $this->session->userdata('iduser');
		$idstore = $this->session->userdata('idstore');
		$date = date("m/d/Y h:i:s");
		$date1 = date("m/d/Y");
		$tomorrow = date('m/d/Y h:i:s',strtotime($date . "+1 days"));
		$isloggedin = "";
		
		$userdata = $this->db->query("select idtimeclock, idusers, DATE_FORMAT(`timein`, '%m/%d/%Y %h:%i:%s') as timein, timeout, hours from LuyetComputer.timeclock where idusers = $iduser and DATE_FORMAT(`timein`, '%m/%d/%Y %h:%i:%s') between '$date1' and '$tomorrow'")->result(); 
		if (empty($userdata))
		{
			//clock in
			$isloggedin = false;
		}
		else
		{
			
			foreach($userdata as $row)
			{
					$timein = $row->timein;  //get the last timein
					$idtimeclock = $row->idtimeclock;
					$clockedout = $row->timeout;//check for last timeout
			}
			
			if (empty($clockedout)) //if not clocked out
			{
				$isloggedin = true;
			}
			
		}
		return $isloggedin;
	}

	function resizepic($images, $percent="0", $width1="0", $height1="0")
    {
    	// The file
	
		$filename = $images;
		$new_height=0;
		$new_width=0;
			list($width, $height) = getimagesize($filename);
			$width = $width;
			$height = $height;
		if($percent!=0)
		{
			$percent = .2;
		// Content type
		//header('Content-Type: image/jpeg');

		// Get new dimensions
			
			$new_width = $width * $percent;
			$new_height = $height * $percent;
		}
		else
		{
			$new_width = $width1;
			$new_height = $height1;
		}
		

		

		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// Output
		imagejpeg($image_p, $filename, 100);
		//print_r($test);
		
    }
	function fix_string($value)
	{
		$search = array(chr(13),chr(10),'"',"'");
		$replace = array('','',' inch.','`');
		for ($i=0; count($search) - 1 >= $i; $i++)
		{
			$value = str_replace($search[$i],$replace[$i],$value); 
		}
		return $value;
	}

	function imgrotate($folder,$name)
	{
		// File and rotation
		$path = "/ext1/newm/images/" . $folder . "/";
		$filename = $path . $name. ".jpg"; 
		$degrees = 90;
		
		// Content type
		//header('Content-type: image/jpeg');
		
		// Load
		$source = imagecreatefromjpeg($filename);
		
		// Rotate
		$rotate = imagerotate($source, $degrees, 0);
		
		// Output
		imagejpeg($rotate,$filename,100);
		$rand = rand(10,99);
		copy($filename,$path . $name . $rand . ".jpg");
		echo "<img src=\"/images/" . $folder . "/" . $name . $rand . ".jpg\" width=\"200px\">";
		
		// Free the memory
		imagedestroy($source);
		imagedestroy($rotate);
		unlink($filename);
		return $name . $rand;
	}
	
	
	public function gettable($SoftwareOrHardward = "ChangeRequest")
	{
		$table = $SoftwareOrHardward;
		if(isset($_COOKIE['table']) == true) 
		{
			$table = $_COOKIE['table'];
		} else
		{
			$this->all_m->cook_cookie('table','ChangeRequest');
		}
		return $table;
	}

	public function randomPassword($num=8) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $num; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function get_invoice_number()
	{
		$pos = $this->load->database('pos', TRUE);
		$inv_num = $pos->from('pancake_invoices')->order_by('id','desc')->limit(1)->get()->result();
		return $inv_num[0]->invoice_number + 1;
				
	}

}
