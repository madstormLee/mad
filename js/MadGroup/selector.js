var MadGroupSelector = Class.create({
	selector: null,
	initialize: function() {
	},
	setResponder: function( responder ) {
		this.responder = responder;
	},
	toggleForm: function( ev ) {
		this.target = ev.element();
		if ( this.selector == null ) {
			this.openSelector.bind(this)( ev );
		} else {
			this.selector.toggle();
		}
		ev.stop();
	},
	openSelector: function( ev ) {
		this.el = ev.element();
		var url = this.el.href;
		this.id = url.parseQuery().tail;
		new Ajax.Request(url,{
			parameters: { 'id':this.id },
			onSuccess: this.insertSelector.bind(this)
		});
	},
	insertSelector: function( transport ) {
		var result = transport.responseText;
		$('container').insert( result );
		this.observeClick.bind(this)();
	},
	observeClick: function() {
		this.selector = $(this.id + 'Selector');
		this.selector.select('.btnClose').invoke('observe','click', this.toggleForm.bind(this));
		this.selector.select('dt a').invoke('observe','click', this.onGroupToggle.bind(this));
		this.selector.select('dt a').invoke('observe','dblclick', this.responder);
	},
	onGroupToggle: function( ev ) {
		ev.stop();
		var el = ev.element();
		var target;
		if( target = el.up('dt').next('dd') ) {
			Element.toggle.delay(0.3,target);
		}
	}
});
