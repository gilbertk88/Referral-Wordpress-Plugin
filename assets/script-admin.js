jQuery(document).ready( function($) {

    var gil_check_fields_validity = function(){

        gil_valid = true;

        if( $(".gil_email_from").val().length == 0 ){
            $(".gil_email_from").css( "border", "1px solid red !important" );
            gil_valid = false;
        }

        if( $(".gil_email_subject").val().length == 0 ){
            $(".gil_email_subject").css( "border", "1px solid red" );
            gil_valid = false;
        }

        if( $(".gil_email_body").val().length == 0 ){
            $(".gil_email_body").css( "border", "1px solid red" );
            gil_valid = false;
        }

        return gil_valid;
        
    }

    var  gil_send_email_details = function (){

        var form_data = new FormData() ;

        form_data.append( 'action' , 'gil_f_save_email_d' ) ;
        form_data.append( 'gil_email_from' , $(".gil_email_from").val() ) ;
        form_data.append( 'gil_email_subject' , $(".gil_email_subject").val() ) ;
        form_data.append( 'gil_email_body' , $(".gil_email_body").val() ) ;

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response );
                response = JSON.parse( response );
                $('.gil_update_message_area').html(' Email updated successfully ');
            },
            error: function (response) {

                console.log( response );

            }

        } ) ;

    }

    $('.gil_email_save_button').click( function(){

        $('.gil_update_message_area').html(' Updating... ');

        gil_check_fields_validity = gil_check_fields_validity() ;

        //console.log( gil_check_fields_validity ) ;
        if( gil_check_fields_validity == true ){
            gil_send_email_details() ;
        }

    } )

    $('.gil_r_save_thankyou_page_id').click( function(){

        gil_r_save_thankyou_page_id();

    } )

    $('.gil_thankyou_id').focus( function(){
        $('.gil_update_typ_message_area').html('');
    } )

    var gil_r_save_thankyou_page_id = function(){

        $('.gil_update_typ_message_area').html('');

        var form_data = new FormData() ;

        gil_thankyou_id = $(".gil_thankyou_id").val();

        if( gil_thankyou_id > 0 ){
            console.log('looks good');
            console.log( gil_thankyou_id );
        }
        else{
            alert( 'Please make sure that that you hav selected a thank you page before saving' );
            console.log( gil_thankyou_id );
        }

        form_data.append( 'action' , 'gil_r_save_thankyou_page_id' );

        form_data.append( 'gil_thankyou_id' , gil_thankyou_id ) ;

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {

                console.log( response );
                response = JSON.parse( response );
                $('.gil_update_typ_message_area').html(' Thank you page updated successfully ');

            },
            error: function (response) {

                console.log( response );

            }

        } ) ;
        
    }


    var gil_send_hubspot_api_details = function(){

        var form_data = new FormData() ;

        form_data.append( 'action' , 'gil_send_hubspot_api_details' ) ;
        form_data.append( 'gil_hubspot_key_f' , $(".gil_hubspot_key_f").val() ) ;

        jQuery.ajax( {

            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response );
                response = JSON.parse( response );
                $('.gil_update_api_message_area').html(' Email updated successfully ');
            },
            error: function (response) {

                console.log( response );

            }

        } ) ;
        
    }

    $('.gil_r_save_hubspot_api').click( function(){

        gil_valid = true;

        if( $(".gil_hubspot_key_f").val().length == '0' ){

            $(".gil_hubspot_key_f").css( { "border": "1px solid red" } );
            gil_valid = false;

        }

        gil_send_hubspot_api_details();

    } )

    $(".gil_hubspot_key_f").focus( function(){

        $(".gil_hubspot_key_f").css({ "border": "1px solid #ccc !important" });
    } )

} )