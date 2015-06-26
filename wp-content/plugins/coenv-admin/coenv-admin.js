// hello world!
;jQuery(function ($) {
	'use strict';



	$("select#acf-field-menu_visibility").on( 'change', function () {

		if ($("select#parent_id").val() == "") {
			alert('Please select a parent for this page before adding it to the menu.');
			$("select#acf-field-menu_visibility").val('not-visible');

		}


        
        //var url = $(this).parent('div').attr('data-url');
        //var cat = $(this).parent('div').attr('data-url');
        //var catval = $(this).val();
        //window.location.href = cat + catval;
    } );





//#
//visible

//
//''







	$( "#parent_id" ).addClass( "active" );
});