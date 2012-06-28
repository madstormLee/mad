document.observe('dom:loaded', function() {
	new FileBrowser;
});
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
