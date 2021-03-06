<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($this->session->userdata['logged_in'])) {
    $name = ($this->session->userdata['logged_in']['name']);
    $user_type = ($this->session->userdata['logged_in']['user_type']);
} else {
    header("location: login");
}

    $id = ""; $servicetaxno = ""; $lrno = "";  $Lr_Date = "";  $from = "";  $to = "";  $consigner_name = ""; $consigner_Addr = ""; $consignee_name = ""; $consignee_Addr = ""; $invoice_no = "";  $vehicle_no = ""; $material_type = "";  $num_packages = ""; $actual_weight = ""; $gst_tax = ""; $vehicle_type = ""; $delivery_date = ""; $POD_receiptno = ""; $type_transportation = "";  $frieght_rate = ""; $detaintion = ""; $loading_charge = ""; $unloading_charge = ""; $extracollectioncharge = ""; $statsticalcharge = "";
    $mail_box = "";
    foreach($result as $row){
       // echo "row.....";
      //  print_r($row);
        if (array_key_exists('id', $row)) { $id = $row['id']; }else{ $id = ""; }
        if (array_key_exists('freight', $row)) { $freight = $row['freight']; }else{ $freight = ""; }
        if (array_key_exists('veh_type', $row)) { $veh_type = $row['veh_type']; }else{ $veh_type = ""; }
        if (array_key_exists('lr_no', $row)) { $lr_no = $row['lr_no']; }else{ $lr_no = ""; }
        if (array_key_exists('date', $row)) { $date = $row['date']; }else{ $date = ""; }
        if (array_key_exists('lorry_no', $row)) { $lorry_no = $row['lorry_no']; }else{ $lorry_no = ""; }
        if (array_key_exists('advance', $row)) { $advance = $row['advance']; }else{ $advance = ""; }
        if (array_key_exists('memo_from', $row)) { $memo_from = $row['memo_from']; }else{ $memo_from =  "" ;}
        if (array_key_exists('memo_to', $row)) { $memo_to = $row['memo_to']; }else{ $memo_to = ""; }
        if (array_key_exists('invoice_no', $row)) { $invoice_no = $row['invoice_no']; }else{ $invoice_no = ""; }
    }
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Memo records edit</title>
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
            .button{
                border-radius: 5px;
                padding: 6px;
                width: 100px;
                color: royalblue;
                font-size: large;
            }
            .I{
                width: auto !important;
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

            textarea{
                height: 200px;
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
               <span><a href="<?php echo base_url();?>index.php/perfect/addUser" class="codrops-icon codrops-icon-add"><i class="fa fa-user-plus" style="font-size:20px"></i>Add Users</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goLR" class="codrops-icon codrops-icon-add "><i class="fa fa-book" style="font-size:20px"></i>LR Records</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goMemo" class="codrops-icon codrops-icon-add active"><i class="fa fa-book" style="font-size:20px"></i>Memo Records</a></span>
            </div>
        </nav>
        <div class="container">
           
            <div class="component">
            <a class="codrops-icon codrops-icon-prev" href="<?php echo base_url();?>index.php/perfect/back_memo"><span>Back</span></a>
            <form method="post" action="<?php echo base_url();?>index.php/perfect/custom_memo" >
                <input class="hidden" name="id" value="<?php echo $id;?>" readonly="true" />
            <table>
                <tr>
                    <td style="width: 60%;">Invoice No.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="invoice_no" value="<?php echo $invoice_no;?>" readonly="true" />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">LR No.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="lr_no" value="<?php echo $lr_no;?>" readonly="true"/>
                    </td>
                </tr>

                <tr>
                    <td style="width: 60%;">Lorry No.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="lorry_no" value="<?php echo $lorry_no;?>" readonly="true"/>
                    </td>
                </tr>

                <tr>
                    <td style="width: 60%;">Memo Date</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="date" value="<?php echo $date;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">From</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="memo_from" value="<?php echo $memo_from;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">To</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="memo_to" value="<?php echo $memo_to;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Vehical Type</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="veh_type" value="<?php echo $veh_type;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Freight</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="freight" value="<?php echo $freight;?>" readonly="true"/>
                    </td>
                </tr>
                
               
                <tr>
                    <td style="width: 60%;">Advance</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" type="number" name="advance" value="<?php echo $advance;?>" required />
                    </td>
                </tr>
                
            </table>
            <p style="color: red;">* highlighted fields are to be filled by admin</p>
            <div>
                <section class="related">
                    <input class="button" type="submit" name="submit" value="Update"/>                   
                </section>
            </div>
            </form>
            </div> 

            <!-- class component -->
           <!--  <section class="related">
                <p>If you enjoyed these effects you might also like:</p>
                <div><a href="http://tympanus.net/Development/HeaderEffects/"><h4>On Scroll Header Effects</h4></a></div>
                <div><a href="http://tympanus.net/Development/MultiElementSelection/"><h4>Multi-Item Selection</h4></a></div>
            </section> -->
        </div><!-- /container -->
       
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.stickyheader.js"></script>
    </body>
</html>