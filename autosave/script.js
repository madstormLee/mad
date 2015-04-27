var Autosave = function() {
	var my = this;

	my.interval = $('#interval').val();
	my.timer = null;

	this.init = function() {
		$('form.autosavable').submit( function( ev ) {
			my.delete( ev );
		});
		$('#autosaveWrite a.load').click( my.load );
		$('#autosaveWrite a.save').click( my.save );
		$('#autosaveWrite a.stop').click( my.stop );
		$('#autosaveWrite a.start').click( my.start );
		$('#autosaveWrite a.delete').click( my.delete );

		my.start();
		my.load();
	};

	this.start = function() {
		if ( my.timer != null ) {
			return false;
		}
		my.timer = window.setInterval( function() {
			if ( $('#interval').val() <= 0 ) {
				my.save();
			} else {
				$('#interval').val( $('#interval').val() - 1 );
			}
		}, 1000 );
		return false;
	};
	this.stop = function( ev ) {
		clearInterval(my.timer);
		my.timer = null;
		return false;
	};

	this.load = function( ev ) {
		var json = $('#formData').val();
		if ( json.length == 0 ) {
			return false;
		}
		var data = JSON && JSON.parse(json) || jQuery.parseJSON(json);
		jQuery.each(data, function(key, value) {
			$('#' + key ).val( value );
		});
		return false;
	};

	this.delete = function( ev ) {
		$.ajax({
			url: $('#autosaveWrite a.delete').attr('href'),
			success: my.update
		});
		if ( $(ev.target).hasClass('delete') ) {
			return false;
		}
	};
	this.update = function( data ) {
		$('#formData').html(data);
		$('#interval').val( my.interval );
	};
	this.save = function() {
		$.post(
			 $('#autosaveWrite').attr('action'),
			 $('form.autosavable').serialize(),
			 my.update
		);
		return false;
	};

	my.init();
}
$( function() {
	new Autosave;
});
