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
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Top Navigation -->
            <div class="codrops-top clearfix">
                <a ><i class="fa fa-user-circle-o" style="font-size:20px"></i><span>Hello!<?php echo " "; echo $user_type; echo " "; echo $name; ?></span></a>
                <span class="right"><a href="<?php echo base_url();?>index.php/perfect/logout"><span>LogOut </span><i class="fa fa-sign-out" style="font-size:20px" aria-hidden="true"></i></a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-user-plus" style="font-size:20px"></i>Add Users</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-home" style="font-size:20px"></i>Dashboard</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>LR Records</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>Memo Records</a></span>
            </div>
            <header>
                <h1><em>Perfect Transport Solution</em> <span>Lorry Records</span></h1> 
               
            </header>
            <div class="component">
     <?php echo form_open('perfect/pagination_rec'); ?>
    <form method="post">
    <div style="display: inline-flex;">
   
     <?php 
        $js = 'id="month", class="opt"';
        $options = array(
                'Select' => 'Select Month',
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December',
                );
   
          echo "<div>";
          echo form_dropdown('month', $options, '0', $js);
          echo "</div>"; 
     ?>
     <?php 

        $js = 'id="year", class="opt"';
        $options = array(
                'Select' => 'Select',                               
                );

        $cur_year = date('Y');
        for($year = '2015'; $year <= ($cur_year+10); $year++) {
            $options[$year] = $year;
        }   
   
          echo "<div>";
          echo form_dropdown('year', $options, '0', $js);
          echo "</div>"; 
     ?>
     
     <button class="btn btn-default opt" type="submit" id="gen_su" name="submit" value="gen_su"  ><span class="fa fa-search">  Search</span></button>   
     <button class="btn btn-default opt" ><span class="fa fa-refresh" aria-hidden="true" ><a style="color: black;" href="<?php echo base_url();?>index.php/perfect/refresh" >  Refresh</a></span></button>   
    </div><br/>
    
  </form>
<?php echo form_close(); ?>                    
               
                <table>
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>LR No.</th>
                            <th>LR Date</th>
                            <th>Consignee Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php if ($results) {
                            
                         foreach($results as $row){ ?>
                        <tr>
                            <td><?php if (array_key_exists('id', $row)) { echo $row->id; }else{} ?></td>
                            <td><?php if (array_key_exists('lrno', $row)) { echo $row->lrno; }else{}?></td>
                            <td><?php if (array_key_exists('Lr_Date', $row)) { echo $row->Lr_Date; }else{}?></td>
                            <td><?php if (array_key_exists('consignee_name', $row)) { echo $row->consignee_name; }else{}?></td>
                            <td><?php if (array_key_exists('from_l', $row)) { echo $row->from_l; }else{}?></td>
                            <td><?php if (array_key_exists('to_l', $row)) { echo $row->to_l; }else{}?></td>                           
                            <td><a  href="<?php echo base_url();?>index.php/perfect/edit_lr/<?php echo $row->id;?>"><i class="fa fa-edit" style="font-size:24px"></i><span>Edit</span></a></td>
                        </tr>
                        <?php } }?>
                    </tbody>
                </table>
                
            </div>
            
            <section class="related">
                <!-- <p>If you enjoyed these effects you might also like:</p> -->
                <div><a href=""><h4><p><?php echo $links; ?></p></h4></a></div>
                <!-- <div><a href="http://tympanus.net/Development/MultiElementSelection/"><h4>Multi-Item Selection</h4></a></div> -->
            </section>
        </div><!-- /container -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.stickyheader.js"></script>
    </body>
</html>