<style>

    .cl_container{
        background:#fff;
        padding:20px;
        margin: 50px 20px;
        border:0px solid #ccc;
        border-radius: 10px;
    }
    .cl_table_cl{
        width: 100%;
    }
    .cl_table_title{
        padding: 20px;
        font-size: 18px;
    }
    .cl_table_header{
        background-color:#ccc3;
        padding: 10px 20px;
    }
    .cl_table_body{
        border-bottom: 1px solid #ccc6;
        padding: 10px 20px;
    }
    .cl_short_code_doc{
        width: 100%;
        background-color:#ccc1;
        padding: 20px;
        border-radius: 0px;
    }
    .gil_delete_contact, .gil_send_email, .gil_send_hubspot {
        border: 1px solid #ccc ;
        background-color: #fff ;
        padding: 5px 20px ;
        color: #333 ;
        cursor: pointer ;
        margin-bottom: 10px;
    }
    .gil_reponse_popup{
        background-color: #fff ;
        border: 1px solid #ccc;
        width: 75%;
        border-radius: 0px;
        height: 50%;
    }
    .gil_reponse_popup_background{
        position:fixed;
        left: 0% ;
        top: 0% ;
        width: 100%;
        height: 100%;
        z-index: 10000;
        background-color: #33333358;
        padding: 10% ;
        display: none;
    }
    .gil_reponse_popup_inner{
        padding: 5% ;
    }
    .gil_reponse_popup_menu{
        width: 100%;
    }
    .gil_close_popup_dialog{
        float: right;
        background-color: #871dc1 ;
        color: #fff ;
        border: 1px solid #871dc1 ;
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
    }

</style>

<div class="cl_container">

    <div class="cl_table_title">
        <center><b>Contact List</b></center>
    </div>

    <div class="cl_short_code_doc">
        <center> Shortcode: <b>[referral_form]</b> </center>
    </div>
    <?php

        $contact_list = get_posts( [
            "post_status"   => "entered",
            "post_type"     => "gil_f_cl",
            'posts_per_page' => -1,
        ] ) ; // gil_r_schedule_emails();

        gil_r_loop_though_unsent_api();

    ?>

    <table class="cl_table_cl">
        <tr>
            <td class="cl_table_header"><b>Name</b></td>
            <td class="cl_table_header"><b>Contact Details</b></td>
            <td class="cl_table_header"><b>Referer</b></td>
            <td class="cl_table_header"><b>Email sent</b></td>
            <td class="cl_table_header"><b>Hubspot API</b></td>
            <td class="cl_table_header"></td>
        </tr>

        <?php
        
        foreach( $contact_list as  $contact) {

            $fname = get_post_meta( $contact->ID, 'fname', true );
            $lname = get_post_meta( $contact->ID, 'lname', true );
            $email = get_post_meta( $contact->ID, 'email', true );
            $phone = get_post_meta( $contact->ID, 'phone', true );
            $field_id = get_post_meta( $contact->ID, 'field_id', true );
            $gil_f_referer = get_post_meta( $contact->ID, 'gil_f_referer', true );

            $email_sent = get_post_meta( $contact->ID, 'email_sent', true );
            $hubspot_api_sent = get_post_meta( $contact->ID, 'hubspot_api_sent', true );

            if( $email_sent == FALSE || $email_sent == 'not_sent' ){
                $email_sent = 'Not sent';
            }
            else{
                $email_sent = 'Sent successfully';
            }

            if( $hubspot_api_sent == FALSE || $hubspot_api_sent == 'not_sent' ){
                $hubspot_api_sent = 'Not sent';
            }
            else{
                $hubspot_api_sent = 'Sent successfully';
            }

        ?>

        <tr id="gil_table_line_<?php echo $contact->ID; ?>">
            <td class="cl_table_body"><?php echo $fname .' '. $lname; ?></td>
            <td class="cl_table_body"><?php echo 'Email: '.$email .'<br>'; echo 'Birthday: '.$phone; ?></td>
            <td class="cl_table_body"><?php echo $gil_f_referer ; ?></td>
            <td class="cl_table_body" id="gil_email_line_<?php echo $contact->ID; ?>"><?php echo $email_sent; ?></td>
            <td class="cl_table_body" id="gil_api_line_<?php echo $contact->ID; ?>"><?php echo $hubspot_api_sent ; ?></td>
            <td class="cl_table_body">
                <input type="button" class="gil_delete_contact" value="Delete Contact" data-contact-id="<?php echo $contact->ID; ?>" > <br>
                <input type="button" class="gil_send_email" value="Send Email" data-contact-id="<?php echo $contact->ID; ?>" > <br>
                <input type="button" class="gil_send_hubspot" value="Send To Hubspot" data-contact-id="<?php echo $contact->ID; ?>" >
            </td>
        </tr>
            
        <?php
        }
        ?>

    </table>

</div>

<div class="gil_reponse_popup_background">
    <div class="gil_reponse_popup">
        <div class="gil_reponse_popup_menu">
            <input type="button" class="gil_close_popup_dialog" value="Close" >
        </div>
        <div class="gil_reponse_popup_inner">
        </div>
    </div>
</div>
