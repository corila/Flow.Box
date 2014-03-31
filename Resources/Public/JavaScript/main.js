$(function() {
	$( "table#sortable tbody" ).sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			var order = $(this).sortable("serialize"); 
			$.post("/seed/updateOrder", order, function(theResponse){
			}); 
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