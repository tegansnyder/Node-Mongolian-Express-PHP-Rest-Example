<?php 

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
	case 'POST':
		rest_post($request, $_POST);  
	break;
	case 'GET':
		rest_get($request);  
	break;
}


function rest_get($request) {
	
	$request = implode("/", $request);

	echo file_get_contents('http://localhost:3000/' . $request);
	
}

function rest_post($request, $_POST) {

	$params = $_POST;
	unset($params['submit']);

	$request = implode("/", $request);
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, "http://localhost:3000/" . $request);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 50);
	//curl_setopt($curl_handle, CURLOPT_USERPWD, "username:password");
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $params);

	$buffer = curl_exec($curl_handle);
	$error = curl_error($curl_handle);
	curl_close($curl_handle);

}
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mongodb node.js mongolian expressjs</title>
</head>

<body>

<h1>List All Address</h1>

<p>Try visting test.php/addresses</p>


<h1>Add a address</h1>

<form id="form1" name="form1" method="post" action="test.php/address">
  <p>
    <label for="address">address</label>
    <input type="text" name="address" id="address" />
  </p>
  <p>
    <label for="city">city</label>
    <input type="text" name="city" id="city" />
  </p>
  <p>
    <label for="state">state</label>
    <input type="text" name="state" id="state" />
  </p>
  <p>
    <input type="submit" name="submit" id="submit" value="Submit" />
  </p>
</form>
</body>
</html>

