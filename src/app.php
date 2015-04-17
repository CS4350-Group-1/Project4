<?php 
//    session_start();
	$app->get('/', function () {
	//require('../src/Views/LoginForm.html');
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'LoginForm.html');
	   // echo "Forward Unto Dawn";
	});

        
    $app->get('/profile', function () {
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'Profile.html');
	});

    $app->post('/profileCheck', function() use ($app)
    {
        $user=$app->request()->params('username');
        
        $SQLReg = new \Common\Authentication\SQLiteReg($user,$pass);
        return json_encode($SQLReg->getProfile());
        
        
    });

    $app->post('/newuser', function() use ($app)
    {
        $user = $app->request->params('username');
        $pass = $app->request->params('password'); 
        $SQLReg = new \Common\Authentication\SQLiteReg($user,$pass);
        $SQLRes = $SQLReg->registerNewUser();
        if($SQLRes!==1)
        {
            $app->response()->setStatus(401);
            echo $app->response()->getStatus();
            return json_encode($app->response()->header('User failed to create.',401));
        }
        //echo $SQLReg ->registerNewUser();
        if ($SQLRes===1)
        {
            
            $app->response()->setStatus(200);
            echo $app->response()->getStatus();
            return json_encode($app->response()->header('User successfully created.',200));   
        }
    });

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

	$app->get('/register', function(){
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'RegistrationForm.html');

            //echo 'get crap';
	});

$app->post('/twitter', function() use ($app)
    {
        $app->response()->setStatus (511);
        echo $app->response->getStatus();
        return json_encode($app->response()->header('get crap', 511));

        
        
    });


	$app->run();