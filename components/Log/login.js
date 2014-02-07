document.observe('dom:loaded',function() {
		$$('.btnSubmit').invoke('observe','click',function( ev ){
			ev.element().up('form').submit();
			});
		});
