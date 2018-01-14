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
        <title>Add user</title>
        <meta name="description" content="Sticky Table Headers Revisited: Creating functional and flexible sticky table headers" />
        <meta name="keywords" content="Sticky Table Headers Revisited" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../../favicon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/demos.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/lr_recpage/component.css" />
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <style type="text/css">
            table{
                border: 1px solid darkgrey;
            }
            .button{
                border-radius: 5px;
                padding: 6px;
                width: 100px;
                color: royalblue;
                font-size: large;
            }
            .I{
                font-weight: 100 !important;
            }
            .D{
            	font-size: 14px;
            	background-color: #EC2211;
            	color: white;"
            }

            .inp{
                width: 100%;
                border-radius: 8px;
                padding: 6px;
            }
            .hidden{
                display: none;
            }
            table{
                border: 1px solid darkgrey;
            }
            .admin{
                border: 2px dotted aqua;
                background: azure;
                box-shadow: 4px 4px 8px 0px lightslategrey;
            }
            .admin_no{
                display: none;
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
            .corner_btn{
                display: inline-block;
            }
            .view_btn{
                color: black;
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
               <span><a href="<?php echo base_url();?>index.php/perfect/godashboard" class="codrops-icon codrops-icon-add "><i class="fa fa-home" style="font-size:20px"></i>Dashboard</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add active"><i class="fa fa-user-plus" style="font-size:20px"></i>Add Users</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goLR" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>LR Records</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goMemo" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>Memo Records</a></span>
            </div>
        </nav>
        <div class="container">
           
            <div class="component">
            <?php echo form_open('perfect/save_User'); ?>
            	<form method="post">
					<table align="center">
					    <tr>
					    <td><input class="inp" type="text" id="id" name="id" placeholder="Autogenerated ID" readonly/></td>
					    </tr>
					    <tr>
					    <td><input class="inp" type="text" id="name" name="name" placeholder="Name" required /></td>
					    </tr>
					    <tr>
					    <td><input class="inp" type="text" id="user_id" name="user_id" placeholder="User Id" required /></td>
					    </tr>					    
					    <tr>
					    <td><input class="inp" type="text" id="password" name="password" placeholder="password" required /></td>
					    </tr>					    
				    </table>
				    <section class="related">
	                    <input class="button" type="submit" name="submit" value="Register"/>	                    
                	</section>
			    </form>
                <?php echo form_close();?>
                <a style="color: orange;">* click row to Update</a>
                <table>
                    <thead>
                        <tr>
                           <th>ID</th>
		                  <th>Name</th>
		                  <th>User Id</th>
		                  <th>Password</th>
		                  <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php 
                  $query = $this->db->query("SELECT * FROM users;");
                  foreach ($query->result() as $row) { ?>                
		                <tr onclick="editrow(this);">
		                  <td style="width: 8%;"><?php echo $row->id; ?></td>
		                  <td style="width: 25%;"><?php echo $row->name; ?></td>
		                  <td style="width: 25%;"><?php echo $row->user_id; ?></td>
		                  <td style="width: 25%;"><?php echo $row->password; ?></td>
		                  <td style="width: 17%;">
		                  		<?php echo form_open('perfect/delete_User?id='.$row->id); ?>
		                  		<center>
                                
		                  			<button class="button D <?php if (isset($row->user_type) ) { if ($row->user_type == "admin") { echo "admin_no"; } } ?>" type="submit" name="submit" value="delete" onclick="return confirm('Do you want to delete this user?');" >Delete</button>
		                  		</center>
		                  		<?php echo form_close();?>
		                  </td>
		                </tr>
		                <?php } ?>
                    </tbody>
                </table>
                
            </div>
           <!--  <section class="related">
                <p>If you enjoyed these effects you might also like:</p>
                <div><a href="http://tympanus.net/Development/HeaderEffects/"><h4>On Scroll Header Effects</h4></a></div>
                <div><a href="http://tympanus.net/Development/MultiElementSelection/"><h4>Multi-Item Selection</h4></a></div>
            </section> -->
        </div><!-- /container -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.stickyheader.js"></script>
        <script>
			function editrow(row){
					document.getElementById('id').value = $(row).find('td:eq(0)').text();
					document.getElementById('name').value = $(row).find('td:eq(1)').text();
				   	document.getElementById('user_id').value = $(row).find('td:eq(2)').text();
				   	document.getElementById('password').value = $(row).find('td:eq(3)').text();	   
			}
		</script>
    </body>
</html>