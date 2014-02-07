var FileBrowser = function( target ) {
	this.my = this;
	this.container = target;

	this.update = function() {
		my.target.load( my.target.attr('data-href') );
	};
	this.getFiles = function( el ) {
		jQuery.ajax({
			url: el.attr('href'),
			success: function( result ) {
				if ( el.hasClass('dir') ) {
					el.after( result );
					return ;
				}
				$('#main').html( result );
			}
		});
	};
	this.updateNext = function( ev ) {
		ev.preventDefault();
		var el = $(ev.target);
		var next = el.next();
		if( next.length > 0 && next[0].tagName == 'H1' ) {
			next.next().toggle();
			return;
		}
		my.getFiles( el );
	};

	/************** assign ***************/
	my.container.click( my.updateNext );
};
$( function() {
	if ( $('#FileBrowser').lenth > 0 ) {
		new FileBrowser( $('#FileBrowser') );
	}
}
