function initNavigation(seq,sec) {

	nav = document.getElementById("gnb");
	nav.menu = new Array();
	nav.current = null;
	nav.menuseq = 0;
	navLen = nav.childNodes.length;

	allA = nav.getElementsByTagName("li")
	for(k = 0; k < allA.length; k++) {
		allA.item(k).onmouseover = allA.item(k).onfocus = function () {
			nav.isOver = true;
		}
		allA.item(k).onmouseout = allA.item(k).onblur = function () {
			nav.isOver = false;
		}
	}

	for (i = 0; i < navLen; i++) {
		navItem = nav.childNodes.item(i);

		if (navItem.tagName != "LI")
			continue;

		navAnchor = navItem.getElementsByTagName("a").item(0);
		navAnchor.submenu = navItem.getElementsByTagName("ul").item(0);


		navAnchor.onmouseover = navAnchor.onfocus = function () {

			if (nav.current) {
				menuImg = nav.current.childNodes.item(0);
				menuImg.src = menuImg.src.replace("ov.gif", ".gif");

				if (nav.current.submenu)
					nav.current.submenu.style.visibility = "hidden";
				nav.current = null;
			}

			if (nav.current != this) {
				menuImg = this.childNodes.item(0);
				menuImg.src = menuImg.src.replace(".gif", "ov.gif");

				if (this.submenu)
					this.submenu.style.visibility = "visible";
				nav.current = this;
			}

			nav.isOver = true;
		}
		nav.menuseq++;
		nav.menu[nav.menuseq] = navAnchor;
	}
	if (nav.menu[seq])
		nav.menu[seq].onmouseover();
}



function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function initMoving(target, topPosition, topLimit, btmLimit) {
	if (!target)
		return false;

	var obj = target;
	obj.initTop = topPosition;
	obj.initLeft = "680px";
	obj.topLimit = topLimit;
	obj.bottomLimit = document.documentElement.scrollHeight - btmLimit;

	obj.style.position = "absolute";
	obj.top = obj.initTop;
	obj.style.left = "928px";
	obj.style.top = obj.top + "px";

	obj.getTop = function() {
		if (document.documentElement.scrollTop) {
			return document.documentElement.scrollTop;
		} else if (window.pageYOffset) {
			return window.pageYOffset;
		} else {
			return 0;
		}
	}
	
	obj.getHeight = function() {
		if (self.innerHeight) {
			return self.innerHeight;
		} else if(document.documentElement.clientHeight) {
			return document.documentElement.clientHeight;
		} else {
			return 500;
		}
	}
	obj.move = setInterval(function() {
		//pos = obj.getTop() + obj.getHeight() / 2 - 15;
		pos = obj.getTop() + topPosition;

		if (pos > obj.bottomLimit)
			pos = obj.bottomLimit
		if (pos < obj.topLimit)
			pos = obj.topLimit

		interval = obj.top - pos;
		obj.top = obj.top - interval / 3;
		obj.style.top = obj.top + "px";
	}, 30)
}



// flash visual
function makeflash(Url,Width,Height,m,s)
{                 
  document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">"); 
  document.writeln("<param name=\"movie\" value=\"" + Url + "\">"); 
  document.writeln("<param name=\"quality\" value=\"high\" />");     
  document.writeln("<param name=\"wmode\" value=\"transparent\">"); 
  document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" wmode=\"transparent\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + (eval(Height) - 5) + "\">"); 
  document.write("<param name=\"FlashVars\" value=\"m="+m+"&s="+s+"\">");	
  document.writeln("</object>");     
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}



