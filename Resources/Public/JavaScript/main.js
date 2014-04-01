$(function() {
	$( "table#sortable tbody" ).sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			if ($('tr.hidden input').val() == 'parent') {
				var order = $(this).sortable("serialize"); 
				$.post("/seed/updateOrderParent", order, function(theResponse){
				}); 
			} else if($('tr.hidden input#type').val() == 'children'){
				var order = $(this).sortable("serialize") + '&parent='+$('tr.hidden input#parent').val(); 
				$.post("/seed/updateOrderChild", order, function(theResponse){
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