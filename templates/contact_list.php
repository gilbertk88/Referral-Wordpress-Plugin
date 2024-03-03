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

</style>

<div class="cl_container">

    <div class="cl_table_title">
        <center><b>Contact List</b></center>
    </div>

    <div class="cl_short_code_doc">
        <center> Shortcode: [referral_form] </center>
    </div>
    <?php

    $contact_list = get_posts( [
        "post_status"   => "entered",
        "post_type"     => "gil_f_cl",
        'posts_per_page' => -1,
    ] ) ;

    // gil_r_schedule_emails();

    gil_r_loop_though_unsent_api();

    ?>

    <table class="cl_table_cl">
        <tr>

            <td class="cl_table_header"><b>Name</b></td>
            <td class="cl_table_header"><b>Contact Details</b></td>
            <td class="cl_table_header"><b>Referer</b></td>

            <td class="cl_table_header"><b>Email sent</b></td>
            <td class="cl_table_header"><b>Hubspot API</b></td>

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

        <tr>
            <td class="cl_table_body"><?php echo $fname .' '. $lname; ?></td>
            <td class="cl_table_body"><?php echo 'Email: '.$email .'<br>'; echo 'Birthday: '.$phone; ?></td>
            <td class="cl_table_body"><?php echo $gil_f_referer ; ?></td>

            <td class="cl_table_body"><?php echo $email_sent; ?></td>
            <td class="cl_table_body"><?php echo $hubspot_api_sent ; ?></td>
        </tr>
            
        <?php
        }
        ?>

    </table>

</div>
