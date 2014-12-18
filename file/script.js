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
	new FileBrowser( $('#FileBrowser') );
}
// from index
var FileBrowser = Class.create({
	initialize: function() {
		this.container = $('FileBrowser');
		this.path = $('path');
		this.dirView = this.container.down('.dirView')
		this.fileView = this.container.down('.fileView');
		this.dirView.observe('click', this.onClick.bind(this));
		this.fileView.observe('click', this.onClick.bind(this));
	},
	onClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		this.el = el;
		if ( el.tagName == 'A' ) {
			alert( el.href.toQueryParams().path );
			new Ajax.Updater( this.fileView, el.href );
			new Ajax.Updater( this.dirView, el.href );
		}
	}
});
