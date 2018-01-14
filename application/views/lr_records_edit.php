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
        if (array_key_exists('servicetaxno', $row)) { $servicetaxno = $row['servicetaxno']; }else{ $servicetaxno = ""; }
        if (array_key_exists('invoice_div', $row)) { $invoice_div = $row['invoice_div']; }else{ $invoice_div = ""; }
        if (array_key_exists('lrno', $row)) { $lrno = $row['lrno']; }else{ $lrno = ""; }
        if (array_key_exists('Lr_Date', $row)) { $Lr_Date = $row['Lr_Date']; }else{ $Lr_Date = ""; }
        if (array_key_exists('consigner_name', $row)) { $consigner_name = $row['consigner_name']; }else{ $consigner_name = ""; }
        if (array_key_exists('consigner_Addr', $row)) { $consigner_Addr = $row['consigner_Addr']; }else{ $consigner_Addr = ""; }
        if (array_key_exists('consignee_name', $row)) { $consignee_name = $row['consignee_name']; }else{ $consignee_name = ""; }
        if (array_key_exists('consignee_Addr_l1', $row)) { $consignee_Addr_l1 = $row['consignee_Addr_l1']; }else{ $consignee_Addr_l1 = ""; }
        if (array_key_exists('consignee_Addr_l2', $row)) { $consignee_Addr_l2 = $row['consignee_Addr_l2']; }else{ $consignee_Addr_l2 = ""; }
        if (array_key_exists('consignee_Addr_l3', $row)) { $consignee_Addr_l3 = $row['consignee_Addr_l3']; }else{ $consignee_Addr_l3 = ""; }
        if (array_key_exists('consignee_state', $row)) { $consignee_state = $row['consignee_state']; }else{ $consignee_state = ""; }
        if (array_key_exists('consignee_state_cd', $row)) { $consignee_state_cd = $row['consignee_state_cd']; }else{ $consignee_state_cd = ""; }
        if (array_key_exists('consignee_gstn', $row)) { $consignee_gstn = $row['consignee_gstn']; }else{ $consignee_gstn = ""; }
        if (array_key_exists('from', $row)) { $from = $row['from']; }else{ $from =  "" ;}
        if (array_key_exists('to', $row)) { $to = $row['to']; }else{ $to = ""; }
        if (array_key_exists('invoice_no', $row)) { $invoice_no = $row['invoice_no']; }else{ $invoice_no = ""; }
        if (array_key_exists('vehicle_no', $row)) { $vehicle_no = $row['vehicle_no']; }else{ $vehicle_no = ""; }
        if (array_key_exists('num_packages', $row)) { $num_packages = $row['num_packages']; }else{ $num_packages = ""; }
        if (array_key_exists('material_type', $row)) { $material_type = $row['material_type']; }else{ $material_type = ""; }
        if (array_key_exists('actual_weight', $row)) { $actual_weight = $row['actual_weight']; }else{ $actual_weight = ""; }
        if (array_key_exists('gst_tax', $row)) { $gst_tax = $row['gst_tax']; }else{ $gst_tax = ""; }
        if (array_key_exists('delivery_date', $row)) { $delivery_date = $row['delivery_date']; }else{ $delivery_date = ""; }
        if (array_key_exists('POD_receiptno', $row)) { $POD_receiptno = $row['POD_receiptno']; }else{ $POD_receiptno = ""; }
        if (array_key_exists('type_transportation', $row)) { $type_transportation = $row['type_transportation']; }else{ $type_transportation = ""; }
        if (array_key_exists('vehicle_type', $row)) { $vehicle_type = $row['vehicle_type']; }else{ $vehicle_type = ""; }
        if (array_key_exists('frieght_rate', $row)) { $frieght_rate = $row['frieght_rate']; }else{ $frieght_rate = ""; }
        if (array_key_exists('detaintion', $row)) { $detaintion = $row['detaintion']; }else{ $detaintion = ""; }
        if (array_key_exists('loading_charge', $row)) { $loading_charge = $row['loading_charge']; }else{ $loading_charge = ""; }
        if (array_key_exists('unloading_charge', $row)) { $unloading_charge = $row['unloading_charge']; }else{ $unloading_charge = ""; }
        if (array_key_exists('extracollectioncharge', $row)) { $extracollectioncharge = $row['extracollectioncharge']; }else{ $extracollectioncharge = ""; }
        if (array_key_exists('statsticalcharge', $row)) { $statsticalcharge = $row['statsticalcharge']; }else{ $statsticalcharge = ""; }
        if (array_key_exists('mail_box', $row)) { $mail_box = $row['mail_box']; }else{ $mail_box = ""; }
    }
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Lr records edit</title>
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
            .consignee{
                background: yellow !important;
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
               <span><a href="<?php echo base_url();?>index.php/perfect/goLR" class="codrops-icon codrops-icon-add active"><i class="fa fa-book" style="font-size:20px"></i>LR Records</a></span>
               <span><a href="<?php echo base_url();?>index.php/perfect/goMemo" class="codrops-icon codrops-icon-add"><i class="fa fa-book" style="font-size:20px"></i>Memo Records</a></span>
            </div>
        </nav>
        <div class="container">
           
            <div class="component">
            <a class="codrops-icon codrops-icon-prev" href="<?php echo base_url();?>index.php/perfect/back_lr"><span>Back</span></a>
            <form method="post" action="<?php echo base_url();?>index.php/perfect/custom_lr" >
                <input class="hidden" name="id" value="<?php echo $id;?>" readonly="true" />
            <table>
                <tr>
                    <td style="width: 60%;">Service Tax No.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="servicetaxno" value="<?php echo $servicetaxno;?>" readonly="true" />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">LR No.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="lrno" value="<?php echo $lrno;?>" readonly="true"/>
                    </td>
                </tr>

                <tr>
                    <td style="width: 60%;">Invoice Div.</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="invoice_div" value="<?php echo $invoice_div;?>" readonly="true"/>
                    </td>
                </tr>

                <tr>
                    <td style="width: 60%;">LR Date</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="Lr_Date" value="<?php echo $Lr_Date;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">From</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="from_l" value="<?php echo $from;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">To</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="to_l" value="<?php echo $to;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Consigner Name</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="consigner_name" value="<?php echo $consigner_name;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Consigner Address</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="consigner_Addr" value="<?php echo $consigner_Addr;?>" readonly="true"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee Name</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_name" value="<?php echo $consignee_name;?>" />
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee Address line 1</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_Addr_l1" value="<?php echo $consignee_Addr_l1;?>"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee Address line 2</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_Addr_l2" value="<?php echo $consignee_Addr_l2;?>"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee Address line 3</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_Addr_l3" value="<?php echo $consignee_Addr_l3;?>"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee State</td>
                    <td style="width: 40%;">    
                       <input type="text" class="inp" name="consignee_state" value="<?php echo $consignee_state;?>"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee State Code</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_state_cd" value="<?php echo $consignee_state_cd;?>"/>
                    </td>
                </tr>
                <tr class="consignee">
                    <td style="width: 60%;">Consignee GSTN No</td>
                    <td style="width: 40%;">     
                       <input type="text" class="inp" name="consignee_gstn" value="<?php echo $consignee_gstn;?>" />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Invoice No</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="invoice_no" value="<?php echo $invoice_no;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Vehicle No</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="vehicle_no" value="<?php echo $vehicle_no;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Material Type</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="material_type" value="<?php echo $material_type;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Number of Packages</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="num_packages" value="<?php echo $num_packages;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Actual Weight</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="actual_weight" value="<?php echo $actual_weight;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">GST Tax</td>
                    <td style="width: 40%;">     
                       <input class="inp" name="gst_tax" value="<?php echo $gst_tax;?>" readonly="true"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Delivery Date</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" type="date" name="delivery_date" value="<?php echo $delivery_date;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">POD Receipt No</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="POD_receiptno" value="<?php echo $POD_receiptno;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Type of Transportation</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="type_transportation" value="<?php echo $type_transportation;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Vehicle Type</td>
                    <td style="width: 40%;">     
                       <select class="inp admin" name="vehicle_type"  required>
                            <option value="LCV" <?php if($vehicle_type == "LCV"){ echo "selected"; }else{} ?> >LCV</option>
                            <option value="LPT" <?php if($vehicle_type == "LPT"){ echo "selected"; }else{} ?> >LPT</option>
                            <option value="PICKUP" <?php if($vehicle_type == "PICKUP"){ echo "selected"; }else{} ?> >PICKUP</option>
                            <option value="FTL" <?php if($vehicle_type == "FTL"){ echo "selected"; }else{} ?> >FTL</option>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Frieght Rate</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="frieght_rate" value="<?php echo $frieght_rate;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Detaintion</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="detaintion" value="<?php echo $detaintion;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Loading Charge</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="loading_charge" value="<?php echo $loading_charge;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">unloading_charge</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="unloading_charge" value="<?php echo $unloading_charge;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Extra Collection Charge</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="extracollectioncharge" value="<?php echo $extracollectioncharge;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Statstical Charge</td>
                    <td style="width: 40%;">     
                       <input class="inp admin" name="statsticalcharge" value="<?php echo $statsticalcharge;?>" required />
                    </td>
                </tr>
                <tr>
                    <td style="width: 60%;">Mail Box</td>
                    <td style="width: 40%;">     
                       <textarea class="inp admin" name="mail_box" ><?php echo htmlspecialchars($mail_box);?></textarea>
                    </td>
                </tr>
                
            </table>
            <p style="color: red;">* highlighted fields are to be filled by admin</p>
            <div>
                <section class="related">
                    <input class="button" type="submit" name="submit" value="Update"/>
                    <input class="button I" type="submit" name="submit" value="Generate Invoice"/>
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