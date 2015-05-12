<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scrapers2 extends CI_Controller {

	private $url = '';
	private $contents = '';
	private $contents_end_start = '';
	private $split_data;

	public function __construct()
	{
		$this->url = "http://www.lazada.com.ph/catalog/?q=nike+rosherun";
		$this->contents = file_get_contents($this->url);
	}

	public function index()
	{	
		$this->destroy();

		header('content-type: text/plain');

		$this->contents_end_start = $this->end_start('<ul', '</ul>'); 
		$this->contents_end_start = preg_replace('/\s+/', ' ', $this->contents_end_start); 

		$this->split_data = $this->split_data('<li>');		

		for($ix = 1; $ix < count($this->split_data); $ix++){
			//echo $ix;
			$tmp = $this->split_data[$ix];

			//print $tmp . "\n\n";
			$getName = $this->getName($tmp); 

			$r[] = array(
				'name' => $getName, 
			);
		}

		echo $json_string = json_encode($r, JSON_PRETTY_PRINT);

		//echo json_encode($r);
		
	}


	public function getName($name){
		$tmp = preg_match_all('/<a class="product-name".*?> (.*?)<\/a>/', $name, $patterns);
		/*$result = array();
		array_push($result, $patterns[1]);
		array_push($result, count($patterns[1]));*/
		//return $result;
		return $patterns[1][0];
	}


	public function split_data($split_data){
		//$records = preg_split($split_data, $this->contents_end_start);
		$records = explode( $split_data , $this->contents_end_start );
		//print count($records);
		//print_r($records);
		return $records;
	}

	public function end_start($start, $end){
		$first_step = explode( $start , $this->contents );
		//print_r($first_step);
		$second_step = explode($end , $first_step[7] );
		return $second_step[0];
	}

	public function destroy(){
		if(isset($_SESSION)){
			session_destroy();
		}

		$host = explode('.', $_SERVER['HTTP_HOST']);

		while ($host) {
		    $domain = '.' . implode('.', $host);

		    foreach ($_COOKIE as $name => $value) {
		        setcookie($name, '', 1, '/', $domain);
		    }

		    array_shift($host);
		}
	}
}


//echo $this->contents;
		/*
		header('content-type: text/plain');
		//echo $contents;

		$records = preg_split('/<ul/', $this->contents);

		print count($records) . "\n";
		//print_r($records);
		echo$records[7];

/*
		$first_step = explode( '<div class="content-wrapper">' , $contents );
		$second_step = explode("</div>" , $first_step[1] );

		echo $second_step[0];

		/*

		print count($records) . "\n";
		print_r($records);
		/*
		if($contents === false)
			print 'FALSE';
		print_r(htmlentities($contents));
		*/


		//$contents = strip_tags();

		//echo $contents;

		//$this->getDiv();



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */