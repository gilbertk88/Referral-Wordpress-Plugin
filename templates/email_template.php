<style>
    .email_container{
        background:#fff;
        padding:40px;
        margin: 50px 20px;
        border:0px solid #ccc;
        border-radius: 10px;
    }

    .gil_email_manage{
        font-size: 18px;
        padding:20px;
    }

    .gil_email_save_button{
        background-color: #323232;
        color: #fff;
        padding: 10px 20px;
        border: 0px;
        margin-top: 20px;
    }

    .gil_email_body{
        width: 100%;
        height: 300px;
        padding: 15px;
        border: 1px solid #ccc !important;
        margin-top: 3px;
    }

    .gil_email_from{
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc !important;
        margin-top: 3px;
    }
    .gil_email_subject{
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc !important;
        margin-top: 3px;
    }
    .gil_email_section{
        padding: 10px 0px;
    }

</style>

<div class="email_container">

    <div>
        <center><span class="gil_email_manage">Manage Email</span></center>
    </div>

    <?php

            $gil_get_email_post_id = gil_get_email_post_id();

            $post_d = get_post( $gil_get_email_post_id );

            $gil_email_from = '';
      
            $pp_data = get_post_meta( $gil_get_email_post_id ) ;
            
            if( array_key_exists( 'gil_email_from', $pp_data ) ){
                $gil_email_from = $pp_data['gil_email_from'][0] ;
            }

            if( array_key_exists( 'gil_email_subject', $pp_data ) ){
                $gil_email_subject = $pp_data['gil_email_subject'][0];
            }

    ?>

    <div>

            <div class="gil_email_section">
                "From" Email Address<br>
                <input type="text" placeholder='Enter "From" Email Address' class="gil_email_from" value="<?php echo $gil_email_from ; ?>">
            </div>
            
            <div  class="gil_email_section">
                Email Subject<br>
                <input type="text" placeholder="Enter email subject" class="gil_email_subject" value="<?php echo $gil_email_subject  ?>">
            </div>

            <div  class="gil_email_section">
                Email Body<br>
                <textarea type="text" class="gil_email_body"><?php echo $post_d->post_content ; ?></textarea>
            </div>

            <div  class="gil_email_section">
                <center>
                    <span class="gil_update_message_area"></span><br>
                    <input type="button" value="Save" class="gil_email_save_button">
                </center>
            </div>

    </div>
   
</div>