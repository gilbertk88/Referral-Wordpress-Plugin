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

    .gil_list_availability{
        background-color: #ccc5 ;
        padding: 20px;
        margin: 10px 0px;
    }

</style>
<?php

    $gil_hubspot_key_f = get_option( 'gil_hubspot_key_f' );

    $gil_list_id = get_option( 'gil_list_id' );

    if( $gil_hubspot_key_f !== false ){
        $gil_hubspot_api = $gil_hubspot_key_f ;
    }
    else{
        $gil_hubspot_api = '';
    }

    $list_list = [] ;

    if( $gil_hubspot_key_f !== false ) {

        $list_list = gil_r_get_contact_list() ;
        
    }

    
?>

<div class="hsapi_container">

    <div>
        <center><span class="gil_hubspot_title">Hubspot API</span></center>
    </div>
    <div>
        <b>Hubspot API</b>
        <input type="text" placeholder="Enter hubspot API" class="gil_hubspot_key_f" value="<?php echo $gil_hubspot_api ; ?>">
        <div class="cl_api_documentation">
            Get the API key by <a target="_blank" href="https://knowledge.hubspot.com/integrations/how-do-i-get-my-hubspot-api-key">clicking here</a>
        </div>
    </div>

    <div>
        <br><br>
        <b>Select a List:</b>
        <?php
        if( $gil_hubspot_key_f == false ) {
            echo '<br>Please enter API key to select a list';
        }
        else {
        
        $html_l = '<select id="gil_list_id">';
        $html_l .= '<option> Please Select a List </option>';

        foreach( $list_list as $key => $value ) {
            if( $value['list_type'] !== "DYNAMIC" ) {

                $selected = '';
                $select_d = '1'.$value['list_id'] ;
                if( $select_d == $gil_list_id ){
                    $selected = 'selected';
                }
                $html_l .= '<option value="' . $value['list_id'] . '" '.$selected.'>'.$value['name'] . ' ( List type: '. $value['list_type']. ') </option>';

            }   
        }

            $html_l .= '</select>';

            echo '<br>'.$html_l;

            $unqualified_list = '';

            foreach( $list_list as $key => $value ) {

                if( $value['list_type'] == "DYNAMIC" ) {
                    $unqualified_list .= $value['name'] . ' ( ID:'.$value['list_id'] .', List type: '. $value['list_type']. ') <br>';
                }
                
            }
            if( strlen( $unqualified_list ) ){
                echo '<div class="gil_list_availability">The following lists do not qualify to be selected because they are of list type "DYNAMIC" <br><br>'.$unqualified_list .'</div>';
            }
        }
    ?>
    
    </div>

    <div>
        <center>
            <span class='gil_update_api_message_area'></span><br><br>
            <input type="button" value="Save" class="gil_r_save_hubspot_api">
        </center>
    </div>

</div>