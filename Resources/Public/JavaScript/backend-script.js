/*
	author: istockphp.com
*/
jQuery(function($) {
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy'
	});
	var startDate = new Date(2012,1,20);
	var endDate = new Date(2012,1,25);

	$('.from_date').datepicker({
		format: 'dd-mm-yyyy'
	}).on('changeDate', function(ev){
		startDate = new Date(ev.date);
		if (ev.date.valueOf() > endDate.valueOf()){
			jQuery('#saleReportExportOption button[type="submit"]').prop( "disabled", true);
		} else {
			jQuery('#saleReportExportOption button[type="submit"]').prop( "disabled", false);
		}
	});
	$('.to_date').datepicker({
		format: 'dd-mm-yyyy'
	}).on('changeDate', function(ev){
		if (ev.date.valueOf() < startDate.valueOf()){
			jQuery('#saleReportExportOption button[type="submit"]').prop( "disabled", true);
		} else {
			jQuery('#saleReportExportOption button[type="submit"]').prop( "disabled", false);
		}
	});


	$(".form-horizontal").validate({
		ignore: null,
		rules : {
			password : {
				minlength : 5
			},
			passwordConfirm : {
				minlength : 5,
				equalTo : "#password"
			},
			imageResource: {
				required: true,
				accept: "image/png, image/gif, image/jpeg, image/pjpeg"
			}
		},
		submitHandler: function(form) {
			$("#confirmSubmit").modal({});
			$('#confirmSubmitOk').on('click', function () {
				form.submit();
			});
		}
	});
    tinymce.init({
        selector: ".rte",
        theme: "modern",
        content_css : "/_Resources/Static/Packages/Flow.Box/Css/Bootstrap/3.0.0/bootstrap.css"
    });

	// update showDiscount
	jQuery('.show-discount').click(function(){
		var iconEye = jQuery(this);
		jQuery.ajax({
			type: 'GET',
			url: 'backend/book/ajaxupdateshowdiscount',
			data: {
				book: iconEye.attr('data-bind')
			}
		}).done(function(){
			iconEye.toggleClass('text-success glyphicon-eye-open glyphicon-eye-close');
		});
	});

	// update pedning sale report
	jQuery('.saleReport-pending').click(function(){
		var statusIcon = jQuery(this);
		jQuery.ajax({
			type: 'GET',
			url: 'backend/salereport/ajaxupdatepending',
			data: {
				saleReport: statusIcon.attr('data-bind')
			}
		}).done(function(){
			statusIcon.toggleClass('text-success glyphicon-remove-circle glyphicon-ok-circle');
			if (statusIcon.hasClass('glyphicon-ok-circle')) {
				statusIcon.attr('title', 'Complete');
			} else {
				statusIcon.attr('title', 'Pending');
			}

			if (statusIcon.attr('data-target') == 'remove') {
				statusIcon.closest('tr').remove();
			}
		});
	});

	// Cancel block
	jQuery('.cancel').on( "click", function() {
		var thisHref = jQuery(this).attr('href');
		$("#confirmCancel").modal({});
		$('#confirmCancelOk').on('click', function () {
			window.location.replace(thisHref);
		});
		return false;
	});

	// Delete block
	jQuery('.btn-delete').on("click", function(form){
		$("#confirmDelete").modal({});
		var thisForm = jQuery(this).parent('.delete-icon');
		$('#confirmSubmitOk').on('click', function () {
			thisForm.submit();
		});
		return false;
	});

	// Select content type
	jQuery('#typeContent').on('click', function(){
		if(jQuery(this).is(':checked')) {
			jQuery('#description').removeClass('hidden');
		} else {
			jQuery('#description').addClass('hidden');
		}
	});
	$('.tokenize').select2({});
}); // jQuery End