document.observe('dom:loaded', function() {
	new PhpStormMenu;
});
var PhpStormMenu = Class.create({
	initialize: function() {
		$('phpStormMenu').observe('click', this.onClick.bind(this));
	},
	onClick: function( ev ) {
		var el = ev.element();
		var dt;

		if ( dt = el.up('dt') ) {
			ev.stop();
			dt.next('dd').toggle();
		} else if( el.innerHTML == 'New Program' ) {
			ev.stop();
			el.up('dd').hide();
			var href = el.href;
			new Ajax.Request( href, {
				onComplete: this.onComplete.bind(this)
			});
		}
	},
	onComplete: function ( transport ) {
		var result = transport.responseText;
		if ( ! this.win ) {
			this.win = new MadWindow('New Program');
		}
		this.win.setContent( result );
		this.win.show();
	}
});
