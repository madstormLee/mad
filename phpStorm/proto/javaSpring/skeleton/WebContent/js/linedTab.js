jQuery(function($){
	var tab = $('.linedTab');
	tab.removeClass('jsOff');
	function onSelectTab(){
		var t = $(this);
		var myclass = [];
		t.parentsUntil('.linedTab:first').filter('li').each(function(){
			myclass.push( $(this).attr('class') );
		});
		myclass = myclass.join(' ');
		if (!tab.hasClass(myclass)) tab.attr('class','linedTab').addClass(myclass);
	}
	tab.find('li>a').click(onSelectTab).focus(onSelectTab);
});