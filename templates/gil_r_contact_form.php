<style>

    .gil_f_wrap{
        width: 100%;
        background-color: #fff;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc6;
    }
    .gil_f_save_referer{
        padding: 10px 20px;
        border-radius: 0px;
        border: 0px;
        cursor: pointer;
        background: #871dc1;
        color: #fff;
        margin-top: 20px;
    }
    .gil_f_referral_name{
        width: 90%;
        padding:10px 20px;
        border: 1px solid #ccc;
        margin: 10px 0px;
    }
    .gil_f_referral_body{
        width: 90%;
        padding:10px 20px;
        border: 1px solid #ccc;
        margin: 10px 0px;
    }
    .gil_f_wrap_contacts{
        display: none;
    }
    .gil_f_sec_100{
        width: 95%;
        overflow: auto;
        padding:10px;
    }
    .gil_f_sec_50{
        width: 43%;
        float: left;
        background-color: #fff;
        margin-right: 10px;
        padding: 10px;
        border-radius: 0px;
    }
    .gil_f_sec_inner{
        background-color: #fff;
        padding: 20px;
        margin-top: 20px;
        border-radius: 0px;
        border: 1px solid #ccc;
    }
    .gil_f_sec_bottom_menu{
        width: 100%;
        padding: 10px;
    }
    .gil_f_new_referee{
        float: right;
        background-color: #ccc1;
        color: #871dc1;
        border: 0px;
        padding: 10px;
        cursor: pointer;
        border-radius: 0px;
        border: 1px solid #871dc1;
    }
    .gil_f_sec_bottom_menu{
        overflow: auto;
        padding: 30px;
        width: 95%;
    }
    .gil_f_new_save_contacts{
        background-color: #871dc1;
        color: white;
        border: 0px;
        padding: 20px;
        cursor: pointer;
        border-radius: 0px;
        width: 95%;
    }
    .gil_f_field_input{
        width: 90%;
        border: 1px solid #ccc;
        padding: 8px 10px;
        margin: 5px 0px;
    }
    .gil_f_welcome_description{
        padding: 30px;
    }
    .gil_f_referral_direction{
        color:#333;
    }
    #ui-datepicker-div{
        background-color: #fff;
        padding: 30px;
        border: 1px solid #3331;
        border-radius: 0px;
        margin: 0px;
    }

    .ui-datepicker-prev , .ui-datepicker-next {
        background-color: green;
        color:#fff;
        padding: 5px 15px;
        margin: 0px 10px;
        border-radius: 5px;
    }

    .gil_super_required{
        font-size: .83em ;
        vertical-align: super ;
        color:red ;
        padding: 5px;
    }

</style>

<?php

    $gil_thankyou_id = get_option( 'gil_thankyou_id' ) ;

    if( $gil_thankyou_id !== false ){
        $gil_thankyou_id = $gil_thankyou_id ;
    }
    else{
        $gil_thankyou_id = '0' ;
    }
    
    echo '<script> var gil_thankyou_id = ' . $gil_thankyou_id . ';</script> ' ;

?>

<div class="gil_f_wrap">

<div class="gil_f_wrap_referer">

    <div class="gil_f_welcome_description">
        <center>Welcome to our referral programme</center>
    </div>

    <div>
        Your Full Name
        <br>
        <input type="text" placeholder="Your first name and last name" class="gil_f_referral_name">
    </div>
    <div class="gil_f_referral_direction">
        Please provide up to 20 people that would be glad to hear about us
        <br>
        <input type="hidden" name="description" placeholder class="gil_f_referral_body">
    </div>
    <div>
        <center><input type="button" value="Continue" class="gil_f_save_referer"></center>
    </div>
</div>

<div class="gil_f_wrap_contacts">

    <div>
        <center>Please add an unlimited number of referees here</center>
    </div>

    <div class="gil_f_sec_wrap">

        <div class="gil_f_sec_inner">

            <div class="gil_f_sec_100">
                <div class="gil_f_sec_50">
                    First Name<br>
                    <input type="text" placeholder class="gil_f_field_input" id="gil_f_fname_0">
                </div>
                <div  class="gil_f_sec_50">
                    Last Name<br>
                    <input type="text" placeholder  class="gil_f_field_input" id="gil_f_lname_0">
                </div>

            </div>

            <div class="gil_f_sec_100">
                <div class="gil_f_sec_50">
                    Email<br>
                    <input type="text" placeholder class="gil_f_field_input" id="gil_f_email_0">
                </div>
                <div  class="gil_f_sec_50">
                    Birthday<br>
                    <input type="text" placeholder="Month/ Date/ Year" class="gil_f_field_input" id="gil_f_pnumber_0">
                </div>

            </div>

        </div>

    </div>

    <div class="gil_f_sec_bottom_menu">
        <center>
            <input type="button" value="+ New Fan" class="gil_f_new_referee">
        </center>
    </div>

    <div class="gil_f_sec_bottom_menu">
        <center>
            <span class="gil_f_new_save_message"></span><br><br>
            <input type="button" value="Share Connections" class="gil_f_new_save_contacts">
        </center>
    </div>

</div>

</div>