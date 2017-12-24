<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
if (isset($this->session->userdata['logged_in'])) {
$name = ($this->session->userdata['logged_in']['name']);
$user_type = ($this->session->userdata['logged_in']['user_type']);
} else {
header("location: login");
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Lr records</title>
        <meta name="description" content="Sticky Table Headers Revisited: Creating functional and flexible sticky table headers" />
        <meta name="keywords" content="Sticky Table Headers Revisited" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/demos.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/component.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/dashboard/dashboard.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-latest.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <script>
          $(document).ready(function() {      
             
            $(function(){  
                 $( '#gen_su' ).click(function() {
                   if($('#month').val() == "Select"){
                     alert( "Please! Select Month." );  
                     return false;
                   }else{
                     return true;
                   }
              });
            }); 

            $(function(){  
                 $( '#gen_su' ).click(function() {
                   if($('#year').val() == "Select"){
                     alert( "Please! Select Year." );  
                     return false;
                   }else{
                     return true;
                   }
              });
            });        
        });
    </script>
        <style type="text/css">
            table{
                border: 1px solid darkgrey;
            }
            .opt{
                border: 1px solid aqua !important;
                border-radius: 5px !important;
            }
            .company{
                color: aliceblue;
                background: black;
                font-family: serif;
                font-style: oblique;
                font-size: xx-large;
            }
            .right{
                float:right;
                margin-right: 10px;
            }
            .left{
                float:left;
                margin-left: 10px;
            }
            .clearfixs{
                display: block;
                margin-top: 1px;
                background: black;
                padding-top: 3px;
                text-transform: uppercase;
                width: 100%;
                font-size: 0.69em;
                line-height: 2.2;
            }
            .user-logout{
                margin-top: 1px;
                background: black;
                height: 25px;
                font-style: oblique;
                padding-top: 2px;
            }
            .active{
                border-bottom: 4px solid;
            }
        </style>
    </head>
    <body>
        <nav>
            <header>
                <div class="company"><center>Perfect Transport Solution</center></div> 
                <div class="user-logout">
                    <a class="left"><i class="fa fa-user-circle-o"></i><span> Hello!<?php echo " "; echo $user_type; echo " "; echo $name; ?></span></a>
                    <span class="right"><a href="<?php echo base_url();?>index.php/perfect/logout"><span>LogOut  </span><i class="fa fa-sign-out" style="font-size:20px" aria-hidden="true"></i></a></span>
                </div>          
            </header>            
            <div class="codrops-top clearfixs">              
               <span><a href="<?php echo base_url();?>index.php/perfect/godashboard" class="codrops-icon codrops-icon-add active"><i class="fa fa-home" style="font-size:20px"></i>Dashboard</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-user-plus" style="font-size:20px"></i>Add Users</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goLR" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>LR Records</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goMemo" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>Memo Records</a></span>
            </div>
        </nav>
        <div class="container">
            
          
            <div class="component">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Today's Lorry Recipt</h3>
                    <button class="btn btn-default pull-right" style="margin-top: -24px; border-radius: 14px;"><a href="" >View Records</a></button>
                </div>
                <div class="panel-body">
                    Panel content
                    <a href="#" class="btn btn-info">Info</a>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Today's Memo</h3>
                    <button class="btn btn-default pull-right" style="margin-top: -24px; border-radius: 14px;"><a href="" >View Records</a></buttton>
                </div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>               
            
        </div><!-- /container -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.stickyheader.js"></script>
    </body>
</html>