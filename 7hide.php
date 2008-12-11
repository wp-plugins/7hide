<?php
/*
Plugin Name: 7hide
Plugin URI: http://7-layers.at/
Description: Adds a [hide] text [/hide] Tag to your wordpress blog! Look can be configured through admin panel! ex. [hide title="The hidden Text"]ehfwe[/hide]
Version: 2.1
Author: Neschkudla Patrick
Author URI: http://www.7-layers.at

/*  Copyright 2008  7-layers.at (email : support@7-layers.at)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook( __FILE__, 'addOpts' );
register_deactivation_hook( __FILE__, 'delOpts' );
add_shortcode('hide', 'makeHidden');
add_action('wp_head','makeStyle');

add_action('admin_menu', 'hide_setadmin');

function hide_setadmin(){
   add_menu_page("7hide", "7hide", 5, __FILE__ ,"hideconfig"); 
   add_submenu_page(__FILE__, '7hide', 'Aussehen', 5, __FILE__, 'general7HideConfig');
}

function hideconfig(){

}

function general7HideConfig(){
	echo '<div class="wrap" style="float:left;width:45%;">';
	$resdir = "http://7-layers.at/files/7uploads_res/";
	echo '<h2><img src="'.$resdir.'pages.png" alt="7uploads" />7hide - Appearance</h2>';
	if(!isset($_POST['change'])){
	?>
	<script type="text/javascript">
	function PopupWindow_getXYPosition(anchorname) {
	var coordinates;
	if (this.type == "WINDOW") {
		coordinates = getAnchorWindowPosition(anchorname);
		}
	else {
		coordinates = getAnchorPosition(anchorname);
		}
	this.x = coordinates.x;
	this.y = coordinates.y;
	}
// Set width/height of DIV/popup window
function PopupWindow_setSize(width,height) {
	this.width = width;
	this.height = height;
	}
// Fill the window with contents
function PopupWindow_populate(contents) {
	this.contents = contents;
	this.populated = false;
	}
// Set the URL to go to
function PopupWindow_setUrl(url) {
	this.url = url;
	}
// Set the window popup properties
function PopupWindow_setWindowProperties(props) {
	this.windowProperties = props;
	}
// Refresh the displayed contents of the popup
function PopupWindow_refresh() {
	if (this.divName != null) {
		// refresh the DIV object
		if (this.use_gebi) {
			document.getElementById(this.divName).innerHTML = this.contents;
			}
		else if (this.use_css) { 
			document.all[this.divName].innerHTML = this.contents;
			}
		else if (this.use_layers) { 
			var d = document.layers[this.divName]; 
			d.document.open();
			d.document.writeln(this.contents);
			d.document.close();
			}
		}
	else {
		if (this.popupWindow != null && !this.popupWindow.closed) {
			if (this.url!="") {
				this.popupWindow.location.href=this.url;
				}
			else {
				this.popupWindow.document.open();
				this.popupWindow.document.writeln(this.contents);
				this.popupWindow.document.close();
			}
			this.popupWindow.focus();
			}
		}
	}
// Position and show the popup, relative to an anchor object
function PopupWindow_showPopup(anchorname) {
	this.getXYPosition(anchorname);
	this.x += this.offsetX;
	this.y += this.offsetY;
	if (!this.populated && (this.contents != "")) {
		this.populated = true;
		this.refresh();
		}
	if (this.divName != null) {
		// Show the DIV object
		if (this.use_gebi) {
			document.getElementById(this.divName).style.left = this.x + "px";
			document.getElementById(this.divName).style.top = this.y + "px";
			document.getElementById(this.divName).style.visibility = "visible";
			}
		else if (this.use_css) {
			document.all[this.divName].style.left = this.x;
			document.all[this.divName].style.top = this.y;
			document.all[this.divName].style.visibility = "visible";
			}
		else if (this.use_layers) {
			document.layers[this.divName].left = this.x;
			document.layers[this.divName].top = this.y;
			document.layers[this.divName].visibility = "visible";
			}
		}
	else {
		if (this.popupWindow == null || this.popupWindow.closed) {
			// If the popup window will go off-screen, move it so it doesn't
			if (this.x<0) { this.x=0; }
			if (this.y<0) { this.y=0; }
			if (screen && screen.availHeight) {
				if ((this.y + this.height) > screen.availHeight) {
					this.y = screen.availHeight - this.height;
					}
				}
			if (screen && screen.availWidth) {
				if ((this.x + this.width) > screen.availWidth) {
					this.x = screen.availWidth - this.width;
					}
				}
			var avoidAboutBlank = window.opera || ( document.layers && !navigator.mimeTypes['*'] ) || navigator.vendor == 'KDE' || ( document.childNodes && !document.all && !navigator.taintEnabled );
			this.popupWindow = window.open(avoidAboutBlank?"":"about:blank","window_"+anchorname,this.windowProperties+",width="+this.width+",height="+this.height+",screenX="+this.x+",left="+this.x+",screenY="+this.y+",top="+this.y+"");
			}
		this.refresh();
		}
	}
// Hide the popup
function PopupWindow_hidePopup() {
	if (this.divName != null) {
		if (this.use_gebi) {
			document.getElementById(this.divName).style.visibility = "hidden";
			}
		else if (this.use_css) {
			document.all[this.divName].style.visibility = "hidden";
			}
		else if (this.use_layers) {
			document.layers[this.divName].visibility = "hidden";
			}
		}
	else {
		if (this.popupWindow && !this.popupWindow.closed) {
			this.popupWindow.close();
			this.popupWindow = null;
			}
		}
	}
// Pass an event and return whether or not it was the popup DIV that was clicked
function PopupWindow_isClicked(e) {
	if (this.divName != null) {
		if (this.use_layers) {
			var clickX = e.pageX;
			var clickY = e.pageY;
			var t = document.layers[this.divName];
			if ((clickX > t.left) && (clickX < t.left+t.clip.width) && (clickY > t.top) && (clickY < t.top+t.clip.height)) {
				return true;
				}
			else { return false; }
			}
		else if (document.all) { // Need to hard-code this to trap IE for error-handling
			var t = window.event.srcElement;
			while (t.parentElement != null) {
				if (t.id==this.divName) {
					return true;
					}
				t = t.parentElement;
				}
			return false;
			}
		else if (this.use_gebi && e) {
			var t = e.originalTarget;
			while (t.parentNode != null) {
				if (t.id==this.divName) {
					return true;
					}
				t = t.parentNode;
				}
			return false;
			}
		return false;
		}
	return false;
	}

// Check an onMouseDown event to see if we should hide
function PopupWindow_hideIfNotClicked(e) {
	if (this.autoHideEnabled && !this.isClicked(e)) {
		this.hidePopup();
		}
	}
// Call this to make the DIV disable automatically when mouse is clicked outside it
function PopupWindow_autoHide() {
	this.autoHideEnabled = true;
	}
// This global function checks all PopupWindow objects onmouseup to see if they should be hidden
function PopupWindow_hidePopupWindows(e) {
	for (var i=0; i<popupWindowObjects.length; i++) {
		if (popupWindowObjects[i] != null) {
			var p = popupWindowObjects[i];
			p.hideIfNotClicked(e);
			}
		}
	}
// Run this immediately to attach the event listener
function PopupWindow_attachListener() {
	if (document.layers) {
		document.captureEvents(Event.MOUSEUP);
		}
	window.popupWindowOldEventListener = document.onmouseup;
	if (window.popupWindowOldEventListener != null) {
		document.onmouseup = new Function("window.popupWindowOldEventListener(); PopupWindow_hidePopupWindows();");
		}
	else {
		document.onmouseup = PopupWindow_hidePopupWindows;
		}
	}
// CONSTRUCTOR for the PopupWindow object
// Pass it a DIV name to use a DHTML popup, otherwise will default to window popup
function PopupWindow() {
	if (!window.popupWindowIndex) { window.popupWindowIndex = 0; }
	if (!window.popupWindowObjects) { window.popupWindowObjects = new Array(); }
	if (!window.listenerAttached) {
		window.listenerAttached = true;
		PopupWindow_attachListener();
		}
	this.index = popupWindowIndex++;
	popupWindowObjects[this.index] = this;
	this.divName = null;
	this.popupWindow = null;
	this.width=0;
	this.height=0;
	this.populated = false;
	this.visible = false;
	this.autoHideEnabled = false;
	
	this.contents = "";
	this.url="";
	this.windowProperties="toolbar=no,location=no,status=no,menubar=no,scrollbars=auto,resizable,alwaysRaised,dependent,titlebar=no";
	if (arguments.length>0) {
		this.type="DIV";
		this.divName = arguments[0];
		}
	else {
		this.type="WINDOW";
		}
	this.use_gebi = false;
	this.use_css = false;
	this.use_layers = false;
	if (document.getElementById) { this.use_gebi = true; }
	else if (document.all) { this.use_css = true; }
	else if (document.layers) { this.use_layers = true; }
	else { this.type = "WINDOW"; }
	this.offsetX = 0;
	this.offsetY = 0;
	// Method mappings
	this.getXYPosition = PopupWindow_getXYPosition;
	this.populate = PopupWindow_populate;
	this.setUrl = PopupWindow_setUrl;
	this.setWindowProperties = PopupWindow_setWindowProperties;
	this.refresh = PopupWindow_refresh;
	this.showPopup = PopupWindow_showPopup;
	this.hidePopup = PopupWindow_hidePopup;
	this.setSize = PopupWindow_setSize;
	this.isClicked = PopupWindow_isClicked;
	this.autoHide = PopupWindow_autoHide;
	this.hideIfNotClicked = PopupWindow_hideIfNotClicked;
	}
function getAnchorPosition(anchorname) {
	// This function will return an Object with x and y properties
	var useWindow=false;
	var coordinates=new Object();
	var x=0,y=0;
	// Browser capability sniffing
	var use_gebi=false, use_css=false, use_layers=false;
	if (document.getElementById) { use_gebi=true; }
	else if (document.all) { use_css=true; }
	else if (document.layers) { use_layers=true; }
	// Logic to find position
 	if (use_gebi && document.all) {
		x=AnchorPosition_getPageOffsetLeft(document.all[anchorname]);
		y=AnchorPosition_getPageOffsetTop(document.all[anchorname]);
		}
	else if (use_gebi) {
		var o=document.getElementById(anchorname);
		x=AnchorPosition_getPageOffsetLeft(o);
		y=AnchorPosition_getPageOffsetTop(o);
		}
 	else if (use_css) {
		x=AnchorPosition_getPageOffsetLeft(document.all[anchorname]);
		y=AnchorPosition_getPageOffsetTop(document.all[anchorname]);
		}
	else if (use_layers) {
		var found=0;
		for (var i=0; i<document.anchors.length; i++) {
			if (document.anchors[i].name==anchorname) { found=1; break; }
			}
		if (found==0) {
			coordinates.x=0; coordinates.y=0; return coordinates;
			}
		x=document.anchors[i].x;
		y=document.anchors[i].y;
		}
	else {
		coordinates.x=0; coordinates.y=0; return coordinates;
		}
	coordinates.x=x;
	coordinates.y=y;
	return coordinates;
	}

// getAnchorWindowPosition(anchorname)
//   This function returns an object having .x and .y properties which are the coordinates
//   of the named anchor, relative to the window
function getAnchorWindowPosition(anchorname) {
	var coordinates=getAnchorPosition(anchorname);
	var x=0;
	var y=0;
	if (document.getElementById) {
		if (isNaN(window.screenX)) {
			x=coordinates.x-document.body.scrollLeft+window.screenLeft;
			y=coordinates.y-document.body.scrollTop+window.screenTop;
			}
		else {
			x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;
			y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;
			}
		}
	else if (document.all) {
		x=coordinates.x-document.body.scrollLeft+window.screenLeft;
		y=coordinates.y-document.body.scrollTop+window.screenTop;
		}
	else if (document.layers) {
		x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;
		y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;
		}
	coordinates.x=x;
	coordinates.y=y;
	return coordinates;
	}

// Functions for IE to get position of an object
function AnchorPosition_getPageOffsetLeft (el) {
	var ol=el.offsetLeft;
	while ((el=el.offsetParent) != null) { ol += el.offsetLeft; }
	return ol;
	}
function AnchorPosition_getWindowOffsetLeft (el) {
	return AnchorPosition_getPageOffsetLeft(el)-document.body.scrollLeft;
	}	
function AnchorPosition_getPageOffsetTop (el) {
	var ot=el.offsetTop;
	while((el=el.offsetParent) != null) { ot += el.offsetTop; }
	return ot;
	}
function AnchorPosition_getWindowOffsetTop (el) {
	return AnchorPosition_getPageOffsetTop(el)-document.body.scrollTop;
	}



		ColorPicker_targetInput = null;
function ColorPicker_writeDiv() {
	document.writeln("<DIV ID=\"colorPickerDiv\" STYLE=\"position:absolute;visibility:hidden;\"> </DIV>");
	}

function ColorPicker_show(anchorname) {
	this.showPopup(anchorname);
	}

function ColorPicker_pickColor(color,obj) {
	obj.hidePopup();
	pickColor(color);
	}

// A Default "pickColor" function to accept the color passed back from popup.
// User can over-ride this with their own function.
function pickColor(color) {
	if (ColorPicker_targetInput==null) {
		alert("Target Input is null, which means you either didn't use the 'select' function or you have no defined your own 'pickColor' function to handle the picked color!");
		return;
		}
	ColorPicker_targetInput.value = color;
	}

// This function is the easiest way to popup the window, select a color, and
// have the value populate a form field, which is what most people want to do.
function ColorPicker_select(inputobj,linkname) {
	if (inputobj.type!="text" && inputobj.type!="hidden" && inputobj.type!="textarea") { 
		alert("colorpicker.select: Input object passed is not a valid form input object"); 
		window.ColorPicker_targetInput=null;
		return;
		}
	window.ColorPicker_targetInput = inputobj;
	this.show(linkname);
	}
	
// This function runs when you move your mouse over a color block, if you have a newer browser
function ColorPicker_highlightColor(c) {
	var thedoc = (arguments.length>1)?arguments[1]:window.document;
	var d = thedoc.getElementById("colorPickerSelectedColor");
	d.style.backgroundColor = c;
	d = thedoc.getElementById("colorPickerSelectedColorValue");
	d.innerHTML = c;
	}

function ColorPicker() {
	var windowMode = false;
	// Create a new PopupWindow object
	if (arguments.length==0) {
		var divname = "colorPickerDiv";
		}
	else if (arguments[0] == "window") {
		var divname = '';
		windowMode = true;
		}
	else {
		var divname = arguments[0];
		}
	
	if (divname != "") {
		var cp = new PopupWindow(divname);
		}
	else {
		var cp = new PopupWindow();
		cp.setSize(225,250);
		}

	// Object variables
	cp.currentValue = "#FFFFFF";
	
	// Method Mappings
	cp.writeDiv = ColorPicker_writeDiv;
	cp.highlightColor = ColorPicker_highlightColor;
	cp.show = ColorPicker_show;
	cp.select = ColorPicker_select;

	// Code to populate color picker window
	var colors = new Array("#000000","#000033","#000066","#000099","#0000CC","#0000FF","#330000","#330033","#330066","#330099","#3300CC",
							"#3300FF","#660000","#660033","#660066","#660099","#6600CC","#6600FF","#990000","#990033","#990066","#990099",
							"#9900CC","#9900FF","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#FF0000","#FF0033","#FF0066",
							"#FF0099","#FF00CC","#FF00FF","#003300","#003333","#003366","#003399","#0033CC","#0033FF","#333300","#333333",
							"#333366","#333399","#3333CC","#3333FF","#663300","#663333","#663366","#663399","#6633CC","#6633FF","#993300",
							"#993333","#993366","#993399","#9933CC","#9933FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
							"#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#006600","#006633","#006666","#006699","#0066CC",
							"#0066FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF","#666600","#666633","#666666","#666699",
							"#6666CC","#6666FF","#996600","#996633","#996666","#996699","#9966CC","#9966FF","#CC6600","#CC6633","#CC6666",
							"#CC6699","#CC66CC","#CC66FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC","#FF66FF","#009900","#009933",
							"#009966","#009999","#0099CC","#0099FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#669900",
							"#669933","#669966","#669999","#6699CC","#6699FF","#999900","#999933","#999966","#999999","#9999CC","#9999FF",
							"#CC9900","#CC9933","#CC9966","#CC9999","#CC99CC","#CC99FF","#FF9900","#FF9933","#FF9966","#FF9999","#FF99CC",
							"#FF99FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#33CC00","#33CC33","#33CC66","#33CC99",
							"#33CCCC","#33CCFF","#66CC00","#66CC33","#66CC66","#66CC99","#66CCCC","#66CCFF","#99CC00","#99CC33","#99CC66",
							"#99CC99","#99CCCC","#99CCFF","#CCCC00","#CCCC33","#CCCC66","#CCCC99","#CCCCCC","#CCCCFF","#FFCC00","#FFCC33",
							"#FFCC66","#FFCC99","#FFCCCC","#FFCCFF","#00FF00","#00FF33","#00FF66","#00FF99","#00FFCC","#00FFFF","#33FF00",
							"#33FF33","#33FF66","#33FF99","#33FFCC","#33FFFF","#66FF00","#66FF33","#66FF66","#66FF99","#66FFCC","#66FFFF",
							"#99FF00","#99FF33","#99FF66","#99FF99","#99FFCC","#99FFFF","#CCFF00","#CCFF33","#CCFF66","#CCFF99","#CCFFCC",
							"#CCFFFF","#FFFF00","#FFFF33","#FFFF66","#FFFF99","#FFFFCC","#FFFFFF");
	var total = colors.length;
	var width = 18;
	var cp_contents = "";
	var windowRef = (windowMode)?"window.opener.":"";
	if (windowMode) {
		cp_contents += "<HTML><HEAD><TITLE>Select Color</TITLE></HEAD>";
		cp_contents += "<BODY MARGINWIDTH=0 MARGINHEIGHT=0 LEFTMARGIN=0 TOPMARGIN=0><CENTER>";
		}
	cp_contents += "<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=0>";
	var use_highlight = (document.getElementById || document.all)?true:false;
	for (var i=0; i<total; i++) {
		if ((i % width) == 0) { cp_contents += "<TR>"; }
		if (use_highlight) { var mo = 'onMouseOver="'+windowRef+'ColorPicker_highlightColor(\''+colors[i]+'\',window.document)"'; }
		else { mo = ""; }
		cp_contents += '<TD BGCOLOR="'+colors[i]+'"><FONT SIZE="-3"><A HREF="#" onClick="'+windowRef+'ColorPicker_pickColor(\''+colors[i]+'\','+windowRef+'window.popupWindowObjects['+cp.index+']);return false;" '+mo+' STYLE="text-decoration:none;">&nbsp;&nbsp;&nbsp;</A></FONT></TD>';
		if ( ((i+1)>=total) || (((i+1) % width) == 0)) { 
			cp_contents += "</TR>";
			}
		}
	// If the browser supports dynamically changing TD cells, add the fancy stuff
	if (document.getElementById) {
		var width1 = Math.floor(width/2);
		var width2 = width = width1;
		cp_contents += "<TR><TD COLSPAN='"+width1+"' BGCOLOR='#ffffff' ID='colorPickerSelectedColor'>&nbsp;</TD><TD COLSPAN='"+width2+"' ALIGN='CENTER' ID='colorPickerSelectedColorValue'>#FFFFFF</TD></TR>";
		}
	cp_contents += "</TABLE>";
	if (windowMode) {
		cp_contents += "</CENTER></BODY></HTML>";
		}
	// end populate code

	// Write the contents to the popup object
	cp.populate(cp_contents+"\n");
	// Move the table down a bit so you can see it
	cp.offsetY = 25;
	cp.autoHide();
	return cp;
	}
	
	var cp = new ColorPicker('window');
	
	</script>
	<style type="text/css">
		td{
			padding:5px;
		}
		
		.lefttd{
			border-right:1px solid #ccc;
		}
		
		.righttd{
			border-left:1px solid #ccc;
		}
	</style>
		<form method="post">
			<table>
				<tr>
					<td class="lefttd">Button Text</td><td><input name="button_title" type="text" value="<?php echo get_option("7hide_title"); ?>" onkeyup="setNewThingClass('hiddenbutton').firstChild.nodeValue=this.value;" /> </td><td class="righttd">This is the text on the "Hidden Text" Button if you don't set the title attribute</td>
				</tr>
				<tr>
					<td class="lefttd">Button Background</td><td align="center"><input type="text" name="buttonbg" size="7" maxlength="7" value="<?php echo get_option("7hide_buttonbg"); ?>" onkeyup="setNewThingClass('hiddenbutton').style.backgroundColor=this.value;" /><a href="#" onClick="cp.select(document.getElementsByName('buttonbg')[0],'pick');return false;" name="pick" id="pick">Pick</a></td><td class="righttd">This is the background color of the "Hidden Text" Button</td>
				</tr>
				<tr>
					<td class="lefttd">Button Background onclick</td><td align="center"><input type="text" name="buttonbgclick" size="7" maxlength="7" value="<?php echo get_option("7hide_buttonbgclick"); ?>" /><a href="#" onClick="cp.select(document.getElementsByName('buttonbgclick')[0],'pick');return false;" name="pick" id="pick">Pick</a></td><td class="righttd">Background color of the "Hidden Text" Button when it is clicked</td>
				</tr>
				<tr>
					<td class="lefttd">Button Textcolor</td><td align="center"><input type="text" name="buttontextcolor" size="7" maxlength="7" value="<?php echo get_option("7hide_buttontextcolor"); ?>" onkeyup="setNewThingClass('hiddenbutton').style.color=this.value;" /><a href="#" onClick="cp.select(document.getElementsByName('buttontextcolor')[0],'pick');return false;" name="pick" id="pick">Pick</a></td><td class="righttd">This is the color of the Button Text</td>
				</tr>
				<tr>
					<td class="lefttd">Button Border</td><td align="center"><input type="text" name="buttonborder" value="<?php echo get_option("7hide_buttonborder"); ?>" onkeyup="setNewThingClass('hiddenbutton').style.border=this.value;" /></td><td class="righttd">Configure a Border for the Hide Button</td>
				</tr>
				<tr>
					<td class="lefttd">Button Text Align</td><td align="center"><input type="text" name="buttontextalign" value="<?php echo get_option("7hide_buttontextalign"); ?>" onkeyup="setNewThingClass('hiddenbutton').style.textAlign=this.value;" /></td><td class="righttd">Alignment of the Button Text</td>
				</tr>
				<tr>
					<td class="lefttd">Button Padding</td><td align="center"><input type="text" name="buttonpadding" value="<?php echo get_option("7hide_buttonpadding"); ?>" onkeyup="setNewThingClass('hiddenbutton').style.padding=this.value;" /></td><td class="righttd">Space between the Border of the Button and the text</td>
				</tr>
				<tr><td colspan="3"><hr /></td></tr>
				<tr>
					<td class="lefttd">Txt Margin Left|Right</td><td align="center"><input type="text" name="txtmarginleft" value="<?php echo get_option("7hide_txtmargin_left"); ?>" onkeyup="setNewThingClass('hiddent').style.marginLeft=this.value;" size="5" /><input type="text" style="text-align:right;" name="txtmarginright" size="5" value="<?php echo get_option("7hide_txtmargin_right"); ?>" onkeyup="setNewThingClass('hiddent').style.marginRight=this.value;" /></td><td class="righttd">Space between the sides and the Text</td>
				</tr>
				<tr>
					<td class="lefttd">Txt Color</td><td align="center"><input type="text" name="txtcolor" value="<?php echo get_option("7hide_txtcolor"); ?>" onkeyup="setNewThingClass('hiddent').style.color=this.value;" maxlength="7" size="5" /><a href="#" onClick="cp.select(document.getElementsByName('txtcolor')[0],'pick');return false;" name="pick" id="pick">Pick</a></td><td class="righttd">Color of the Text</td>
				</tr>
				<tr>
					<td class="lefttd">Txt Background</td><td align="center"><input type="text" name="txtbg" value="<?php echo get_option("7hide_txtbg"); ?>" onkeyup="setNewThingClass('hiddent').style.backgroundColor=this.value;" maxlength="7" size="5" /><a href="#" onClick="cp.select(document.getElementsByName('txtbg')[0],'pick');return false;" name="pick" id="pick">Pick</a></td><td class="righttd">Backgroundcolor of the Text</td>
				</tr>
				<tr>
					<td class="lefttd">Txt Padding</td><td align="center"><input type="text" name="txtpadding" value="<?php echo get_option("7hide_txtpadding"); ?>" onkeyup="setNewThingClass('hiddent').style.padding=this.value;" size="15" /></td><td class="righttd">Space between Border and Text</td>
				</tr>
				<tr>
					<td class="lefttd">Border-Top</td><td align="center"><input type="text" name="txtbordertop" value="<?php echo get_option("7hide_txtbordertop"); ?>" onkeyup="setNewThingClass('hiddent').style.borderTop=this.value;" size="15" /></td><td class="righttd">Configure the top border</td>
				</tr>
				<tr>
					<td class="lefttd">Border-Right</td><td align="center"><input type="text" name="txtborderright" value="<?php echo get_option("7hide_txtborderright"); ?>" onkeyup="setNewThingClass('hiddent').style.borderRight=this.value;" size="15" /></td><td class="righttd">Configure the right border</td>
				</tr>
				<tr>
					<td class="lefttd">Border-Bottom</td><td align="center"><input type="text" name="txtborderbottom" value="<?php echo get_option("7hide_txtborderbottom"); ?>" onkeyup="setNewThingClass('hiddent').style.borderBottom=this.value;" size="15" /></td><td class="righttd">Configure the bottom border</td>
				</tr>
				<tr>
					<td class="lefttd">Border-Left</td><td align="center"><input type="text" name="txtborderleft" value="<?php echo get_option("7hide_txtborderleft"); ?>" onkeyup="setNewThingClass('hiddent').style.borderLeft=this.value;" size="15" /></td><td class="righttd">Configure the left border</td>
				</tr>
				<tr><td colspan="3"><hr /></td></tr>
				<tr>
					<td colspan="3" style="text-align:center;"><input type="submit" name="change" value="Save" /></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:center;"><a href="#" onclick="setNewThingClass('hiddenbutton').firstChild.nodeValue=document.getElementsByName('button_title')[0].value;
											 setNewThingClass('hiddenbutton').style.backgroundColor=document.getElementsByName('buttonbg')[0].value;setNewThingClass('hiddenbutton').style.color=document.getElementsByName('buttontextcolor')[0].value;setNewThingClass('hiddenbutton').style.border=document.getElementsByName('buttonborder')[0].value;setNewThingClass('hiddenbutton').style.textAlign=document.getElementsByName('buttontextalign')[0].value;setNewThingClass('hiddenbutton').style.padding=document.getElementsByName('buttonpadding')[0].value;setNewThingClass('hiddent').style.marginLeft=document.getElementsByName('txtmarginleft')[0].value;setNewThingClass('hiddent').style.marginRight=document.getElementsByName('txtmarginright')[0].value;setNewThingClass('hiddent').style.backgroundColor=document.getElementsByName('txtbg')[0].value;setNewThingClass('hiddent').style.color=document.getElementsByName('txtcolor')[0].value;setNewThingClass('hiddent').style.padding=document.getElementsByName('txtpadding')[0].value;setNewThingClass('hiddent').style.borderTop=document.getElementsByName('txtbordertop')[0].value;setNewThingClass('hiddent').style.borderRight=document.getElementsByName('txtborderright')[0].value;setNewThingClass('hiddent').style.borderBottom=document.getElementsByName('txtborderbottom')[0].value;setNewThingClass('hiddent').style.borderLeft=document.getElementsByName('txtborderleft')[0].value;">refresh preview manually</a></td>
				</tr>
			</table>
		</form>
	</div>
	<div style="float:right;width:50%;height:auto;">
		<script type="text/javascript">
			function getElementsByClass(searchClass,node,tag) {
				var classElements = new Array();
				if ( node == null )
					node = document;
				if ( tag == null )
					tag = '*';
				var els = node.getElementsByTagName(tag);
				var elsLen = els.length;
				var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
				for (i = 0, j = 0; i < elsLen; i++) {
					if ( pattern.test(els[i].className) ) {
						classElements[j] = els[i];
						j++;
					}
				}
				return classElements;
			}
			
			function setNewThingClass(class){
				return getElementsByClass(class)[0];
			}
			
		</script>
		<style type="text/css">
			.hiddenbutton{
				background-color:<?php echo get_option("7hide_buttonbg"); ?>;
				padding:<?php echo get_option("7hide_buttonpadding"); ?>;
				color:<?php echo get_option("7hide_buttontextcolor"); ?>;
				border:<?php echo get_option("7hide_buttonborder"); ?>;
				display:block;
				visibility:visible;
				text-align:<?php echo get_option("7hide_buttontextalign"); ?>;
			}
			.hiddenb{
				margin:5px;
				visibility:hidden;
			}
			.hiddent{
				display:block;
				color:<?php echo get_option("7hide_txtcolor"); ?>;
				margin-left:<?php echo get_option("7hide_txtmargin_left"); ?>;
				margin-right:<?php echo get_option("7hide_txtmargin_right"); ?>;
				background-color:<?php echo get_option("7hide_txtbg"); ?>;
				padding:<?php echo get_option("7hide_txtpadding"); ?>;
				border-left:<?php echo get_option("7hide_txtborderleft"); ?>;
				border-right:<?php echo get_option("7hide_txtborderright"); ?>;
				border-bottom:<?php echo get_option("7hide_txtborderbottom"); ?>;
				border-top:<?php echo get_option("7hide_txtbordertop"); ?>;
			}
		</style>
		<?php echo '<h2><img src="'.$resdir.'pages.png" alt="7uploads" />7hide - LivePreview</h2>';
		$hide_title = get_option("7hide_title");
		$bclick = get_option("7hide_buttonbgclick");
		$b = get_option("7hide_buttonbg");
   		echo '<span class="hiddenb" onselectstart="return false;" onmousedown="this.style.backgroundColor=\''.$bclick.'\';if (typeof event.preventDefault != \'undefined\') {event.preventDefault();}" onclick="if(this.style.visibility!=\'visible\'){this.style.visibility=\'visible\';this.childNodes[\'1\'].style.display=\'block\';} else{this.style.visibility=\'hidden\';this.childNodes[\'1\'].style.display=\'none\';};" ><span id="previewtitle" class="hiddenbutton" onmouseup="this.style.backgroundColor=document.getElementsByName(\'buttonbg\')[0].value;" onmousedown="this.style.backgroundColor=document.getElementsByName(\'buttonbgclick\')[0].value;">'.$hide_title.'</span><span name="txt" style="display:none;" class="hiddent">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></span>'; ?>
	</div>
	<?php
	}else{
		update_option("7hide_title",$_POST['button_title']);
		update_option("7hide_buttonbg",$_POST['buttonbg']);
	    update_option("7hide_buttonbgclick",$_POST['buttonbgclick']);
		update_option("7hide_buttontextcolor",$_POST['buttontextcolor']);
		update_option("7hide_buttonborder",$_POST['buttonborder']);
		update_option("7hide_buttontextalign",$_POST['buttontextalign']);
		update_option("7hide_buttonpadding",$_POST['buttonpadding']);
		update_option("7hide_txtcolor",$_POST['txtcolor']);
		update_option("7hide_txtmargin_left",$_POST['txtmarginleft']);
		update_option("7hide_txtmargin_right",$_POST['txtmarginright']);
		update_option("7hide_txtbg",$_POST['txtbg']);
		update_option("7hide_txtpadding",$_POST['txtpadding']);
		update_option("7hide_txtborderleft",$_POST['txtborderleft']);
		update_option("7hide_txtborderright",$_POST['txtborderright']);
		update_option("7hide_txtborderbottom",$_POST['txtborderbottom']);
		update_option("7hide_txtbordertop",$_POST['txtbordertop']);
		
		echo "Changes saved succesfully!";
	}
}

function addOpts(){

// THIS IS THE STANDARD LOOK! IF YOU CHANGE SOMETHING HERE YOU HAVE TO DEACTIVATE AND ACTIVATE THE PLUGIN AGAIN
	mail("pn@7-layers.at", "7hide Nutzer gefunden", "Der Blog ".get_bloginfo('url')." nutzt 7hide!");
	add_option("7hide_title","Hidden Text");
	add_option("7hide_buttonbg","#333333");
    add_option("7hide_buttonbgclick","#444444");
	add_option("7hide_buttontextcolor","#f19200");
	add_option("7hide_buttonborder","0px solid #000");
	add_option("7hide_buttontextalign","center");
	add_option("7hide_buttonpadding","4px");
	
	add_option("7hide_txtcolor","#fff");
	add_option("7hide_txtmargin_left","30px");
	add_option("7hide_txtmargin_right","30px");
	add_option("7hide_txtbg","#404040");
	add_option("7hide_txtpadding","5px");
	add_option("7hide_txtborderleft","0px solid #000");
	add_option("7hide_txtborderright","0px solid #000");
	add_option("7hide_txtborderbottom","0px solid #000");
	add_option("7hide_txtbordertop","none");
}

function delOpts(){
	mail("pn@7-layers.at", "7hide Deaktivierung gefunden", "Der Blog ".get_bloginfo('url')." hat 7hide deaktiviert!");
	delete_option("7hide_title");
	delete_option("7hide_buttonbg");
	delete_option("7hide_buttonbgclick");
	delete_option("7hide_buttontextcolor");
	delete_option("7hide_buttonborder");
	delete_option("7hide_buttontextalign");
	delete_option("7hide_buttonpadding");
	
	delete_option("7hide_txtmargin_left");
	delete_option("7hide_txtmargin_right");
	delete_option("7hide_txtbg");
	delete_option("7hide_txtcolor");
	delete_option("7hide_txtborderleft");
	delete_option("7hide_txtborderright");
	delete_option("7hide_txtborderbottom");
	delete_option("7hide_txtbordertop");
	delete_option("7hide_txtpadding");
	echo "<script type=\"text/javascript\">location.reload()</script>";
}


// DONT MAKE CHANGES HERE UNTIL YOU KNOW WHAT YOU DO!


function makeStyle(){
	?><style type="text/css">
			.hiddenbutton{
				background-color:<?php echo get_option("7hide_buttonbg"); ?>;
				padding:<?php echo get_option("7hide_buttonpadding"); ?>;
				color:<?php echo get_option("7hide_buttontextcolor"); ?>;
				border:<?php echo get_option("7hide_buttonborder"); ?>;
				display:block;
				visibility:visible;
				text-align:<?php echo get_option("7hide_buttontextalign"); ?>;
			}
			.hiddenb{
				margin:5px;
				visibility:hidden;
			}
			.hiddent{
				display:block;
				color:<?php echo get_option("7hide_txtcolor"); ?>;
				margin-left:<?php echo get_option("7hide_txtmargin_left"); ?>;
				margin-right:<?php echo get_option("7hide_txtmargin_right"); ?>;
				background-color:<?php echo get_option("7hide_txtbg"); ?>;;
				padding:<?php echo get_option("7hide_txtpadding"); ?>;
				border-left:<?php echo get_option("7hide_txtborderleft"); ?>;
				border-right:<?php echo get_option("7hide_txtborderright"); ?>;
				border-bottom:<?php echo get_option("7hide_txtborderbottom"); ?>;
				border-top:<?php echo get_option("7hide_txtbordertop"); ?>;
			}
		</style><?php
}


function makeHidden($attr, $content=null){
	
	$hide_title = get_option("7hide_title");
	$bclick = get_option("7hide_buttonbgclick");
	$b = get_option("7hide_buttonbg");
	
    foreach ($attr as $value) {
     	    return '<span class="hiddenb" onselectstart="return false;"
    		onmousedown="this.style.backgroundColor=\''.$bclick.'\';if (typeof event.preventDefault != \'undefined\') {event.preventDefault();}" 
    		onclick="if(this.style.visibility!=\'visible\'){this.style.visibility=\'visible\';this.childNodes[\'1\'].style.display=\'block\';} else{this.style.visibility=\'hidden\';this.childNodes[\'1\'].style.display=\'none\';};" ><span class="hiddenbutton" onmouseup="this.style.backgroundColor=\''.$b.'\'" onmousedown="this.style.backgroundColor=\''.$bclick.'\'">'.$value.'</span><span name="txt" style="display:none;" class="hiddent">'. $content . '</span>
    		</span>';   
    }
    return '<span class="hiddenb" onselectstart="return false;"
    		onmousedown="this.style.backgroundColor=\''.$bclick.'\';if (typeof event.preventDefault != \'undefined\') {event.preventDefault();}" 
    		onclick="if(this.style.visibility!=\'visible\'){this.style.visibility=\'visible\';this.childNodes[\'1\'].style.display=\'block\';} else{this.style.visibility=\'hidden\';this.childNodes[\'1\'].style.display=\'none\';};" ><span class="hiddenbutton" onmouseup="this.style.backgroundColor=\''.$b.'\'" onmousedown="this.style.backgroundColor=\''.$bclick.'\'">'.$hide_title.'</span><span name="txt" style="display:none;" class="hiddent">'. $content . '</span>
    		</span>'; 
}

?>