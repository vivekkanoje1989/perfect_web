<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/animate-custom.css" />
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">
                <a href="">
                    <strong>&laquo; Date: </strong><?php echo date("d M, Y");?>
                </a>
                <span class="right">
                    <a href="">
                        <strong>Always be Happy !</strong>
                    </a>
                    <!-- <a href="http://localhost/edcoca_web/index.php/welcome/schedulers">
                        <strong>Back to the Scheduler lo</strong>
                    </a> -->
                </span>
                <div class="clr"></div>
            </div> <!--/ Codrops top bar -->
            <header>
                <h1><span>LogIn for </span> Perfect Tansport Solutions</h1>
				<!-- <nav class="codrops-demos">
					<span>Click <strong>"Here"</strong> to go to</span>
					<a href="index.html" class="current-demo">Demo 1</a>
					<a href="index2.html">Demo 2</a>
					<a href="index3.html">Demo 3</a>
                    <a href="http://localhost/edcoca_web/index.php/welcome/schedulers" class="current-demo">Go to Scheduler</a>
				</nav> -->
            </header>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                        <?php echo form_open('Perfect/login'); ?>
                            <form  action="" method="post" autocomplete="on"> 
                                <h1>Your Credintials</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your username </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="mymail@gmail.com"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <!-- <p class="keeplogin"> 
									<input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
									<label for="loginkeeping">Keep me logged in</label>
								</p> -->
                                <p class="login button"> 
                                    <input type="submit" value="login" /> 
								</p>
                                <!-- <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
								</p> -->
                                <p class="change_link">
                                <?php if (isset($error_message)) { echo $error_message; echo validation_errors();}else{} 
                                      if (isset($logout_message)) { echo $logout_message;}else{}
                                      if (isset($message_display)) { echo $message_display;}else{}
                                ?>
                                </p>
                            </form>
                            <?php echo form_close(); ?>
                        </div>

                       <!--  <div id="register" class="animate form">
                            <form  action="mysuperscript.php" autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p class="signin button"> 
									<input type="submit" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
                        </div> -->
						
                    </div>
                </div>  
            </section>
        </div>
        <!-- botttom bar -->
        <div class="codrops-top " style="line-height: 46px;">
            <span class="right" >
                <a href="">
                    <strong><span>Powered By</span><a href="https://www.edigitech.in/">Edigitech Solutions</a></strong>
                </a>
            </span>
            <div class="clr"></div>
        </div> <!--/ botttom bar -->
    </body>
</html>