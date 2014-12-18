document.observe('dom:loaded',function(){
		MadWindow.init();
	});
var MadWindow = {
init: function () {
		  $$('.window .titleBar .btnMenu').invoke('observe','click',MadWindow.showMenu);
		  $$('.window .titleBar .btnFold').invoke('observe','click',MadWindow.fold);
		  $$('.window .titleBar .btnRemove').invoke('observe','click',MadWindow.remove);
	  },
showMenu: function( ev ) {
			  var el = ev.element();
		  },
fold: function( ev ) {
			  var el = ev.element();
			  el.up('.window').down('.windowContents').toggle();
		  },
remove: function( ev ) {
			  var el = ev.element();
			  el.up('.window').hide();
		  }
}
