<?php

require('./vendor/autoload.php');

use Faker\Factory;


class FakeThis{
	private $options = [];
	private $name = 'faker';


	function __construct($args){
		$this->setOptions($args);
	}

	function generate(){

		$locale = $this->getOption('locale', Factory::DEFAULT_LOCALE);
		$seed   = $this->getOption('seed');
		$format = $this->getOption('format', 'json');
		$count  = $this->getOption('count', 1);
		$type   = $this->getArguments();


		$args = '';
		if(!empty($type)){
			$args 	= array_slice($type, 1);
			$type   = $type[0];
		} else{
			$type = 'text';
			$args = [100];
		}

		$data = [];
		$faker = Factory::create($locale);
		if ($seed) {
			$faker->seed($seed);
		}
		for ($i = 0; $i < $count; $i++) {
			$tmp = $faker->format($type, $args);
			if(is_array($tmp)) $tmp = implode(' ', $tmp);
			$data[] = $tmp;
		}

		//var_dump($data);die;

		$output = implode(' ', $data);

		return $this->outputJson($output);
	}

	private function getOption($name, $default=false){
		if(array_key_exists($name, $this->options))
			return $this->options[$name];
		return $default; 
	}

	private function getArguments(){
		$args = [];

		foreach ($this->options as $key => $val) {
		  if (is_int($key)) {
		    $args[]=$this->options[$key];
		  }
		}
		return $args; 
	}

	private function setOptions( $args ){
		$this->options = $this->parse($args);
	}

	private function parse( $my_arg = null ){
    	$cmd_args = array();
       	$skip = array();


       	$my_arg = trim(str_replace($this->name, '', $my_arg));
       	

		$new_argv = explode(' ', $my_arg);

		//var_dump($new_argv);die;
		foreach ( $new_argv as $idx => $arg ) {
		   if ( in_array( $idx, $skip ) ) {
		       continue;
		   }

		   $arg = preg_replace( '#\s*\=\s*#si', '=', $arg );
		   $arg = preg_replace( '#(--+[\w-]+)\s+[^=]#si', '${1}=', $arg );

		   if (substr($arg, 0, 2) == '--') {
		       $eqPos = strpos($arg, '=');

		       if ($eqPos === false) {
		           $key = trim($arg, '- ');
		           $val = isset($cmd_args[$key]);

		           // We handle case: --user-id 123 -> this is a long option with a value passed.
		           // the actual value comes as the next element from the array.
		           // We check if the next element from the array is not an option.
		           if ( isset( $new_argv[ $idx + 1 ] ) && ! preg_match('#^-#si', $new_argv[ $idx + 1 ] ) ) {
		               $cmd_args[$key] = trim( $new_argv[ $idx + 1 ] );
		               $skip[] = $idx;
		               $skip[] = $idx + 1;
		               continue;
		           }

		           $cmd_args[$key] = $val;
		       } else {
		           $key = substr($arg, 2, $eqPos - 2);
		           $cmd_args[$key] = substr($arg, $eqPos + 1);
		       }
		   } else if (substr($arg, 0, 1) == '-') {
		       if (substr($arg, 2, 1) == '=') {
		           $key = substr($arg, 1, 1);
		           $cmd_args[$key] = substr($arg, 3);
		       } else {
		           $chars = str_split(substr($arg, 1));

		           foreach ($chars as $char) {
		               $key = $char;
		               $cmd_args[$key] = isset($cmd_args[$key]) ? $cmd_args[$key] : true;
		           }
		       }
		   } else {
		       $cmd_args[] = $arg;
		   }
		}

		return $cmd_args;

	}

	private function error($message){
		return $this->outputJson('',1,$message);
	}

	private function outputJson($data, $code=0, $msg='success'){
		return json_encode(["data"=>$data, "code"=>$code, "msg"=>$msg], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}

$user_data = array_key_exists('user_data', $_REQUEST)?$_REQUEST['user_data']:'text';
$faker = new FakeThis($user_data);

 header("Access-Control-Allow-Origin: *");
echo $faker->generate();