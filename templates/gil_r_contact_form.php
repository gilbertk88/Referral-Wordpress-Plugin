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
        background:green;
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
        border: 1px solid #ccc3;
        border-radius: 0px;
    }
    .gil_f_sec_inner{
        background-color: #ccc1;
        padding: 20px;
        margin-top: 20px;
        border-radius: 0px;
    }
    .gil_f_sec_bottom_menu{
        width: 100%;
        padding: 10px;
    }
    .gil_f_new_referee{
        float: right;
        background-color: #ccc1;
        color: green;
        border: 0px;
        padding: 10px;
        cursor: pointer;
        border-radius: 0px;
        border: 1px solid green;
    }
    .gil_f_sec_bottom_menu{
        overflow: auto;
        padding: 30px;
        width: 95%;
    }
    .gil_f_new_save_contacts{
        background-color: green;
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

</style>

<div class="gil_f_wrap">

<div class="gil_f_wrap_referer">

    <div class="gil_f_welcome_description">
        <center>Welcome to our referral programme</center>
    </div>

    <div>
        Your Full Name
        <br>
        <input type="text" placeholder="Your Full Names" class="gil_f_referral_name">
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
                    <input type="text" placeholder="Date/Month/Year" class="gil_f_field_input" id="gil_f_pnumber_0">
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
            <input type="button" value="Save Contacts" class="gil_f_new_save_contacts">
        </center>
    </div>

</div>

</div>