//<![CDATA[
jQuery(function($){
	
	// LNB : Local Navigation Bar 서브메뉴
	var sMenu = $('div.lnb');
	var sItem = sMenu.find('>ul>li');
	var ssItem = sMenu.find('>ul>li>ul>li');
	var lastEvent = null;
	
	sItem.find('>ul').css('display','none');
	sMenu.find('>ul>li>ul>li[class=active]').parents('li').attr('class','active');
	sMenu.find('>ul>li[class=active]').find('>ul').css('display','block');

	function sMenuToggle(event){
		var t = $(this);
		
		if (this == lastEvent) return false;
		lastEvent = this;
		setTimeout(function(){ lastEvent=null }, 200);
		
		if (t.next('ul').is(':hidden')) {
			sItem.find('>ul').slideUp(100);
			t.next('ul').slideDown(100);
		} else if(!t.next('ul').length) {
			sItem.find('>ul').slideUp(100);
		} else {
			t.next('ul').slideUp(100);
		}
		
		if (t.parent('li').hasClass('active')){
			t.parent('li').removeClass('active');
		} else {
			sItem.removeClass('active');
			t.parent('li').addClass('active');
		}
	}
	sItem.find('>a[href=#]').click(sMenuToggle).focus(sMenuToggle);
	
	function subMenuActive(){
		ssItem.removeClass('active');
		$(this).parent(ssItem).addClass('active');
	}; 
	ssItem.find('>a').click(subMenuActive).focus(subMenuActive);
	
	//icon
	sMenu.find('>ul>li>ul').prev('a').append('<span class="i"></span>');
});



jQuery(function(){
	
	var article = $('.faq .article');
	article.addClass('hideF');
	article.find('.a').slideUp(100);
	article.eq(0).removeClass('hideF').addClass('show'); // 첫 번째 항목을 열어 둡니다
	article.eq(0).find('.a').slideDown(100); // 첫 번째 항목을 열어 둡니다
	
	$('.faq .article .trigger').click(function(){
		var myArticle = $(this).parents('.article:first');
		if(myArticle.hasClass('hideF')){
			article.addClass('hideF').removeClass('show'); // 아코디언 효과를 원치 않으면 이 라인을 지우세요
			article.find('.a').slideUp(100); // 아코디언 효과를 원치 않으면 이 라인을 지우세요
			myArticle.removeClass('hideF').addClass('show');
			myArticle.find('.a').slideDown(100);
		} else {
			myArticle.removeClass('show').addClass('hideF');
			myArticle.find('.a').slideUp(100);
		}
	});
	
	$('.faq .hgroup .trigger').click(function(){
		var hidden = $('.faq .article.hideF').length;
		if(hidden > 0){
			article.removeClass('hideF').addClass('show');
			article.find('.a').slideDown(100);
		} else {
			article.removeClass('show').addClass('hideF');
			article.find('.a').slideUp(100);
		}
	});
	
});




////////////////////////////////////2010년 11월 25일 수정한 부분////////////////////////////////////

function chg(n) { //v2.0
	if(n=='1'){
		document.getElementById("all_menu").style.display='';
		document.getElementById("all_menu_view").style.display='';
	}else{
		document.getElementById("all_menu").style.display='';
		document.getElementById("all_menu_view").style.display='none';
	}
}

function chga(n) { //v2.0
	if(n=='1'){
		document.getElementById("eb_all_menu").style.display='';
		document.getElementById("eb_all_menu_view").style.display='';
	}else{
		document.getElementById("eb_all_menu").style.display='';
		document.getElementById("eb_all_menu_view").style.display='none';
	}
}


function overImg( obj ) {
	obj.src = obj.src.replace( '.gif', 'ov.gif' );
}
function outImg( obj ) {
	obj.src = obj.src.replace( 'ov.gif', '.gif' );
}

//flash visual
function makeflash(Url,Width,Height,m,s)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.write("<param name=\"FlashVars\" value=\"m="+m+"&s="+s+"\">");
	document.writeln("</object>");
}

//]]>