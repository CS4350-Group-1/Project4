<?php 
//    session_start();
	$app->get('/', function () {
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'LoginForm.html');
	});

        
        $app->get('/profile/:name', function ($name) {
            echo $name;
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'Profile.html');
            
	});

        $app->post('/newuser', function() use ($app)
        {
            //$user = $app->request->params('username');
            //$pass = $app->request->params('password');

            $user = new \Models\User($app->request->params('username'), $app->request->params('password'));
            $user->setFirstName($app->request->params('firstname'));
            $user->setLastName($app->request->params('lastname'));
            $user->setEmail($app->request->params('email'));
            $user->setTwitterName($app->request->params('twittername'));
            $user->setRegistrationDate($app->request->params('date'));


            //$SQLReg = new \Common\Authentication\SQLiteReg($user,$pass);
            $SQLReg = new \Common\Authentication\SQLiteReg($user);
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
        }
        );


        $app->get('/genAuth', function ()
        {
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'genAuth.php');   
        });


        $app->post('/api',function()use($app){
           //echo 'api endpoint'; 
            //$data = $app->request->getBody();
            $username = $app->request->params('username');
            $password = $app->request->params('password');
            $auth = $app->request->params('authKey');
           $SQLAuth = new \Common\Authentication\SQLiteAuth($username, $password);
           if($SQLAuth->authenticateA($auth)!==1)
           {  
                $app->response()->setStatus(403);
               // $app->response()->getStatus();
                return json_encode($app->response()->header('Need an authentication key? : localhost:8080/genAuth', 403));
           }
           if($SQLAuth->authenticate()!==1)
           {
                $app->response()->setStatus(401);
               // $app->response()->getStatus();
                return json_encode($app->response()->header('Need to register? : localhost:8080/RegistrationForm', 401));
           }
           if($SQLAuth->authenticate()===1)
           {
                $app->response()->setStatus(200);
               // $app->response()->getStatus();
                $user = new \Models\User($username, $password);
                $SQLReg = new \Common\Authentication\SQLiteReg($user);

                $S = $SQLReg->getProfile();
                $S = json_encode($S);
                echo $S;
               // return; //json_encode($app->response()->header('Login successful : localhost:8080/Profile', 200));
           }
        });

	$app->post('/twitter', function(){
            //echo 'post twitter';
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Common'.DIRECTORY_SEPARATOR.'Authentication'.DIRECTORY_SEPARATOR.'TwitterAuth.php');
            //TwitterAuth();
            
        });        

        $app->get('/register', function(){
            require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'RegistrationForm.html');

            //echo 'get crap';
	});


	$app->run();