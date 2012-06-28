document.observe('dom:loaded', function() {
	new WriteSub;
});
var WriteSub = Class.create({
	initialize: function() {
		this.controllers = new Controllers;
		$('name').observe( 'blur', this.onNameBlur.bind(this) );
	},
	onNameBlur: function() {
		$('href').value = $('href').value + $F('name');
	},
	onClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		var position = el.positionedOffset();
		this.controllers.showAt.bind( this.controllers )( position, el );
	}
});
var Controllers = Class.create({
	initialize: function() {
		this.container = $('MVCManager');
		this.controllers = $('controllers');
		this.actions = $('actions');

		this.controllers.observe( 'click', this.onClick.bind(this) );
		this.actions.observe( 'click', this.onClick.bind(this) );
	},
	showAt: function( position , el ) {
		this.controllers.setStyle({
			top: position.top + el.getHeight() + 'px',
			left: position.left + 'px',
			position: 'absolute'
		});
	},
	onClick: function( ev ) {
		ev.stop();
		var el = ev.element();
		el.up('ul').select('a').invoke('removeClassName','current');
		el.addClassName('current');

		var id = el.up('dd').id;
		if ( id == 'controllers' ) {
			var controller = el.innerHTML;
			$('controller').value = controller;
			this.getActions( controller );
			$('action').value = '';
		} else if ( id == 'actions' ) {
			$('action').value = el.innerHTML;
		}
	},
	getActions: function( controller ) {
		var url = 'getActions?controller=' + controller;
		new Ajax.Updater( this.actions, url );
	}
});
