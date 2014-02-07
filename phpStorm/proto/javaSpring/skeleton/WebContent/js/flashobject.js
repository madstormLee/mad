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

function makeflashDsbd(Url,Width,Height,totalVar)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.writeln("<param name=\"TotalVar\" value=\""+totalVar+"\">");
	document.writeln("</object>");
}

function makeflashDsbd2(Url,Width,Height,yyyy, maxTxt)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.writeln("<param name=\"yyyy\" value=\""+yyyy+"\">");
	document.writeln("<param name=\"maxTxt\" value=\""+maxTxt+"\">");
	document.writeln("</object>");
}

function makeflashEqmtSts(Url,Width,Height,yyyy)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.writeln("<param name=\"yyyy\" value=\""+yyyy+"\">");
	document.writeln("</object>");
}

function makeflashEqmtDeptSts(Url,Width,Height,yyyy,sch_mm)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.writeln("<param name=\"yyyy\" value=\""+yyyy+"\">");
	document.writeln("<param name=\"sch_mm\" value=\""+sch_mm+"\">");
	document.writeln("</object>");
}

function makeflashEqmtUnitSts(Url,Width,Height,yyyy, hold_inst, eqmt_no)
{
	document.writeln("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"" + Width + "\" height=\"" + Height + "\">");
	document.writeln("<param name=\"movie\" value=\"" + Url + "\">");
	document.writeln("<param name=\"quality\" value=\"high\" />");
	document.writeln("<param name=\"wmode\" value=\"transparent\">");
	document.writeln("<embed src=\"" + Url + "\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"" + Width + "\"  height=\"" + Height + "\" wmode=\"transparent\"></embed>");
	document.writeln("<param name=\"yyyy\" value=\""+yyyy+"\">");
	document.writeln("<param name=\"hold_inst\" value=\""+hold_inst+"\">");
	document.writeln("<param name=\"eqmt_no\" value=\""+eqmt_no+"\">");
	document.writeln("</object>");
}

