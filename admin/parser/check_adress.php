<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/_webProject/core/init.php';
	$name=sanitize($_POST['full_name']);
	$email=sanitize($_POST['email']);
	$street=sanitize($_POST['street']);
	$street2=sanitize($_POST['street2']);
	$city=sanitize($_POST['city']);
	$state=sanitize($_POST['state']);
	$zip_code=sanitize($_POST['zip_code']);
	$country=sanitize($_POST['country']);

	$errors=array();
	$required=array(
		'full_name'=>'Numele intreg',
		'email'=>'Email',
		'street'=>'Adresa',
		'city'=>'Oras',
		'state'=>'Judet',
		'zip_code'=>'ZIP Code',
		'country'=> 'Tara'
	);

	//verificam daca sunt completate toate necesare

	foreach($required as $f=>$d)
	{
		if(empty($_POST[$f]) || $_POST[$f]=='')
		{
			$errors[]=$d.' trebuie completat.';
		}			
	}  


	if(!empty($errors)){
		echo display_errors($errors);
	}else
	{
		$pass='passed';
		echo sanitize($pass);
	}




 ?>