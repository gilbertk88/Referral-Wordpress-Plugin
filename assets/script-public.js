jQuery(document).ready( function($) {

    var gil_f_data = [];
    gil_f_data[0] = 0;

    var gil_f_contact_id = 0;
    var gil_f_referer = {};

    $('.gil_f_save_referer').click( function() {

        gil_f_referer = {
            'name': $('.gil_f_referral_name').val(), // 'description' : $('.gil_f_referral_body').val(),
        } ;

        $('.gil_f_wrap_referer').hide();
        $('.gil_f_wrap_contacts').show();

        // var stringArray = gil_f_referer.name.split(/(\s+)/);
        // console.log( stringArray );

    } );

    var confirm_that_the_fields_are_cool = function( gil_f_contact_id = '' ) {

        var truth = true;

        if( $( "#gil_f_fname_" + gil_f_contact_id ).val() == '' ){
            truth = 'fail';
            $( "#gil_f_fname_" + gil_f_contact_id ).css({'border':'1px solid red'});
        }

        if( $( "#gil_f_lname_"+ gil_f_contact_id ).val() == '' ){
            truth = 'fail';
            $( "#gil_f_lname_" + gil_f_contact_id ).css({'border':'1px solid red'});
        }

        if( $( "#gil_f_email_"+ gil_f_contact_id ).val() == '' ){
            truth = 'fail';
            $( "#gil_f_email_" + gil_f_contact_id ).css({'border':'1px solid red'});
        }

        if( $( "#gil_f_pnumber_"+ gil_f_contact_id ).val() == '' ){
            truth = 'fail';
            $( "#gil_f_pnumber_" + gil_f_contact_id ).css({'border':'1px solid red'});
        }

        if( truth == 'fail' ){
            alert('Please fill in the required fields');
        }

        return truth;

    }

    $('.gil_f_field_input').blur( function(){
        $( this ).css({ 'border':'1px solid #ccc2' });
    } );

    $('.gil_f_new_referee').click( function(){

        gil_f_status = confirm_that_the_fields_are_cool( gil_f_contact_id );

        if( gil_f_status == 'fail' ){
            return false;
        }

        gil_f_contact_id++

        $('.gil_f_sec_wrap').append( '<div class="gil_f_sec_inner">\
            <div class="gil_f_sec_100">\
                <div class="gil_f_sec_50">\
                    First Name<br>\
                    <input type="text" placeholder="Enter first name" class="gil_f_field_input" id="gil_f_fname_'+ gil_f_contact_id + '">\
                </div>\
                <div class="gil_f_sec_50">\
                    Last Name<br>\
                    <input type="text" placeholder="Enter last name"  class="gil_f_field_input" id="gil_f_lname_'+ gil_f_contact_id + '">\
                </div>\
            </div>\
            <div class="gil_f_sec_100">\
                <div class="gil_f_sec_50">\
                    Email<br>\
                    <input type="text" placeholder="Enter email" class="gil_f_field_input" id="gil_f_email_'+ gil_f_contact_id + '">\
                </div>\
                <div  class="gil_f_sec_50">\
                    Birthday<br>\
                    <input type="text" placeholder="Enter Date/Month/Year" class="gil_f_field_input" id="gil_f_pnumber_'+ gil_f_contact_id + '">\
                </div>\
            </div>\
        </div>' );

        gil_f_data[ gil_f_contact_id ] = gil_f_contact_id; // console.log( gil_f_data );

    } )

    var gil_f_save_form_feilds = function(){

        var form_data = new FormData() ;

        form_data.append( 'action' , 'gil_f_save_form_feilds' ) ;
        form_data.append( 'gil_f_referer' , JSON.stringify( gil_f_referer ) ) ;

        gil_f_data.forEach( function( field_id , details ){

            gil_f_single_data = {
                'fname' : $( "#gil_f_fname_"+field_id ).val() ,
                'lname' : $( "#gil_f_lname_"+field_id ).val() ,
                'email' : $( "#gil_f_email_"+field_id).val() ,
                'phone' : $( "#gil_f_pnumber_"+field_id ).val() ,
                'field_id' : field_id
            } ;

            gil_f_single_data_json = JSON.stringify( gil_f_single_data ) ;

            // console.log( field_id );  console.log( gil_f_single_data );

            form_data.append( 'ewm_wr_cat_post_id_' + field_id ,  gil_f_single_data_json );
            
        } );

        jQuery.ajax( {
            url: ajax_object.ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: form_data,
            success: function ( response ) {
                console.log( response ) ;
                response = JSON.parse( response ) ;
                $('.gil_f_new_save_message').html('Congratulation, the contacts have been saved successfully!') ;
            },
            error: function (response) {
                console.log( response ) ;
            }

        } ) ;

    }

    $('.gil_f_field_input').click(function(){
        $('.gil_f_new_save_message').html('') ;
    } )

    $('.gil_f_new_save_contacts').click( function(){

        if( $('.gil_f_new_save_message').html() == 'Congratulation, the contacts have been saved successfully!' ){

            alert( 'The contacts have already been saved' );

        }

        gil_f_data.forEach( function( field , details ){

            gil_f_status = confirm_that_the_fields_are_cool( field ) ;
            if( gil_f_status == 'fail' ){
                return false;
            }

        } );

        gil_f_save_form_feilds();

    } );

} )
