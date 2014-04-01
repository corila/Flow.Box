$(function() {
	$('.loader').hide();
	$( "table#sortable tbody" ).sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			if ($('tr.hidden input').val() == 'parent') {
				var order = $(this).sortable("serialize");
				var arrayOrder = order.split('=');
				var listOrder = new Array();
				for (var j = 0; j < arrayOrder.length; j++) {
					if (j > 0) {
						listOrder[j-1] = parseInt(arrayOrder[j]);
					}
				}
				for (i = 0; i < listOrder.length; i++) {
					var currentId = '#recordsArray_' + listOrder[i];
					var newId = 'recordsArray_' + (i+1);
					console.log(currentId + '=>' + newId);
					$(currentId).prop('id', newId)
				}

				$('.loader').show();
				$.post("/seed/updateOrderParent", order, function(theResponse){
				}).done(function() {
					$('.loader').hide();
				});
			} else if($('tr.hidden input#type').val() == 'children'){
				var order = $(this).sortable("serialize") + '&parent='+$('tr.hidden input#parent').val(); 
				$.post("/seed/updateOrderChild", order, function(theResponse) {
					console.log('success');
				}); 
			}
		},
		revert: true
	});
	$( "#draggable" ).draggable({
		connectToSortable: "#sortable",
		helper: "clone",
		revert: "invalid"
	});
	$( "table#sortable" ).disableSelection();
});