document.observe('dom:loaded', function() {
	new MadGroupSelectorPlain;
});
var MadGroupSelectorPlain = Class.create({
	initialize: function() {
		$$('.MadGroupSelectorPlain a').invoke('observe','click',this.toggleSub.bind(this));
	},
	toggleSub: function( ev ) {
		ev.stop();
		var el = ev.element();
		if ( el.up('dt').next('dd') ) {
			el.up('dt').next('dd').toggle();
			if ( el.innerHTML == '+' ) {
				el.update('-');
			} else {
				el.update('+');
			}
		}
	}
});

