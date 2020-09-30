$(function(){

	var CATEGORY = $('#main_contents article').data('category');

	// Split Main&Sub Category by space

	var splitglobal = CATEGORY.split(" ");

	// Activate Main Category

	$('#CMN_gmenu .btn_' + splitglobal[0]).addClass('active');

	/*$('#CMN_sub_gmenu .btn_' + CATEGORY).css({display: "block"});*/

	// Display Sub Category

	$('.' + splitglobal[0]+'_sub').css({display: "block"});

	// ACtivate Sub Category Corressponding link.

	$('#' + splitglobal[1]).addClass('active');

});