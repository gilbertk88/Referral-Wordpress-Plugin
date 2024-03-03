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
    .gil_hubspot_key_f{
        width: 100% ;
        border: 1px solid #ccc;
        margin: 10px 0px ;
        padding: 10px;
    }
    .gil_r_save_hubspot_api{
        background : #323232 ;
        color : #fff ;
        border: 0px ;
        padding: 10px 20px ;
    }
    .cl_api_documentation{
        width: 100% ;
        padding: 10px;
    }

</style>
<?php

    $gil_hubspot_key_f = get_option( 'gil_hubspot_key_f' );

    if( $gil_hubspot_key_f !== false ){
        $gil_hubspot_api = $gil_hubspot_key_f ;
    }
    else{
        $gil_hubspot_api = '';
    }

?>

<div class="hsapi_container">

    <div>
        <center><span class="gil_hubspot_title">Hubspot API</span></center>
    </div>
    <div>
        Hubspot API
        <input type="text" placeholder="Enter hubspot API" class="gil_hubspot_key_f" value="<?php echo $gil_hubspot_api ; ?>">
        <div class="cl_api_documentation">
            Get the API key by <a target="_blank" href="https://knowledge.hubspot.com/integrations/how-do-i-get-my-hubspot-api-key">clicking here</a>
        </div>
    </div>
    <div>
        <center>
            <span class='gil_update_api_message_area'></span><br><br>
            <input type="button" value="Save" class="gil_r_save_hubspot_api">
        </center>
    </div>

</div>