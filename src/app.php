<?php 
//    session_start();
	$app->get('/', function () {
	//require('../src/Views/LoginForm.html');
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'LoginForm.html');
	   // echo "Forward Unto Dawn";
	});

//	$app->get('/hello/:name', function ($name) {
//		echo "Hello, $name";
//	});
        
  $app->get('/profile', function () {
      require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'Profile.php');
	});


//	$app->post('/auth', function () use ($app){
//
//            $SQLAuth = new \Common\Authentication\SQLiteAuth($_POST['username'], $_POST['password']);
//                    //$postData->username, $postData->password);
//            if($SQLAuth->authenticate()===1)
//            {
//
//                //echo "Authentication Successful"; 
//                echo $app->response()->setStatus(200);
//                echo $app->response()->getStatus();
////                $_SESSION["username"]==$_POST['username'];
////                $_SESSION["password"]==$_POST['password'];
//                
//            }
//            if($SQLAuth->authenticate()!==1)
//            {
//                
//                echo $app->response()->setStatus(401);
//                echo $app->response()->getStatus();
//                //header("Status:401");
////                http_response_code(401);
//                //echo "Authentication Failed";
////
////                return var_dump(http_response_code());
//            }
//            //echo "got here";
//            
//            //echo "instantiate controller here and pass the request object to it... ";
//		
//	});
        
  $app->get('/genAuth', function ()
  {
      require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'genAuth.php');   
  });
  $app->post('/api',function () use($app){
     //echo 'api endpoint'; 
      //$data = $app->request->getBody();
      $user = $app->request->params('username');
      $pass = $app->request->params('password');
      $auth = $app->request->params('authKey');
     $SQLAuth = new \Common\Authentication\SQLiteAuth($user,$pass);
     if($SQLAuth->authenticateA($auth)!==1)
     {  
          $app->response()->setStatus(403);
          $app->response()->getStatus();
          return json_encode($app->response()->header('Need an authentication key? : localhost:8080/genAuth', 403));
     }
     if($SQLAuth->authenticate()!==1)
     {
          $app->response()->setStatus(401);
          $app->response()->getStatus();
          return json_encode($app->response()->header('Need to register? : localhost:8080/RegistrationForm', 401));
     }
     if($SQLAuth->authenticate()===1)
     {
          $app->response()->setStatus(200);
          $app->response()->getStatus();
//                $_SESSION["username"]==$_POST['username'];
//                $_SESSION["password"]==$_POST['password'];
//                echo 'set session' + $_SESSION['username'];
          return json_encode($app->response()->header('Login successful : localhost:8080/Profile', 200));
     }
  });
//
//	$app->post('/register', function (){
//	//echo 'post crap';
//            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'register.html');
//
//	});
	$app->get('/register', function(){
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'RegistrationForm.html');

            //echo 'get crap';
	});


	$app->run();