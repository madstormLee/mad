$( function() {
	$('#toBacklog').click(function(ev){ 
		var id = $('#right .view .contents > dt').html().substring(4);

		var contents = $('#contents')[0];
		if (contents.selectionStart == undefined) {
			return false;
		}
		var startPos = contents.selectionStart;
		var endPos = contents.selectionEnd;
		var selected = contents.value.substring(startPos, endPos)

		$.ajax({
			type: 'POST',
			data: {
				id: id,
				contents: selected
			},
			url: $(ev.target).attr('data-href'),
			success: function( result ) {
				$('#right').load( $('#right').attr('data-href').replace(/=[a-zA-Z0-9]+$/, '=' + id) );
			}
		});
	}); 
});
