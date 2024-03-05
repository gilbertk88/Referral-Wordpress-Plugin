<style>
    .hsapi_container{
        background:#fff;
        padding:20px;
        margin: 50px 20px;
        border:0px solid #ccc;
        border-radius: 10px;
    }
    .gil_hubspot_title{
        font-size : 18px;
        padding : 20px;
    }
    .gil_thankyou_id{
        width: 100% ;
        border: 1px solid #ccc;
        margin: 10px 0px ;
        padding: 10px;
    }
    .gil_r_save_thankyou_page_id{
        background : #323232 ;
        color : #fff ;
        border: 0px ;
        padding: 10px 20px ;
        cursor: pointer;
    }
    .cl_typ_documentation{
        width: 100% ;
        padding: 10px;
        color: #4a4a4a;
    }
    .gil_update_typ_message_area{
        color:#871dc1;
    }

</style>
<?php

    $gil_thankyou_id = get_option( 'gil_thankyou_id' );

    if( $gil_thankyou_id !== false ){
        $gil_thankyou_id = $gil_thankyou_id ;
    }
    else{
        $gil_thankyou_id = '';
    }

    $page_list = get_posts( [

        'post_type' => 'page',
        'post_status' => 'published',
        'fields' => 'ids',
        'numberposts' => '-1',

    ] ) ;

    // var_dump( $page_list );
    // <input type="text" placeholder="Enter id" value=" echo $gil_thankyou_id ; 

?>

<div class="hsapi_container">

    <div>
        <center><span class="gil_hubspot_title">Thank You Page Settings</span></center>
    </div>
    <div>
        <br><br><br>
        <b>Thank You Page</b><br><br>
        <select  class="gil_thankyou_id">
        <option value="0"> Please select a thank you page </option>
            <?php foreach ( $page_list as $key_pl => $value_pl ) { ?>
                <option value="<?php echo $value_pl; ?>" <?php if( $gil_thankyou_id == $value_pl ){ echo "selected"; } ?> > <?php echo get_the_title($value_pl) . ' ( ID: ' .$value_pl. ' ) ' ; ?> </option>
            <?php } ?>
        </select>

        <div class="cl_typ_documentation">
            From the above drop down, please select the thank you page. The user will be redirected to this page after they successfully sharing contacts.
        </div>

    </div>
    
    <div>

        <center>
            <span class='gil_update_typ_message_area'></span><br><br>
            <input type="button" value="Save" class="gil_r_save_thankyou_page_id">
        </center>

    </div>

</div>
