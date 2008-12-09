<?php
/*
Plugin Name: 7hide
Plugin URI: http://7-layers.at/
Description: Adds a [hide] text [/hide] Tag to your wordpress blog! Look can be configured through css!
Version: 1.0
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

function addOpts(){

// THIS IS THE STANDARD LOOK! IF YOU CHANGE SOMETHING HERE YOU HAVE TO DEACTIVATE AND ACTIVATE THE PLUGIN AGAIN

	add_option("7hide_title","Versteckter Text");
	add_option("7hide_buttonbg","#333333");
    add_option("7hide_buttonbgclick","#444444");
	add_option("7hide_buttontextcolor","#f19200");
	add_option("7hide_buttonborder","0px solid #000");
	add_option("7hide_buttontextalign","center");
	add_option("7hide_buttonpadding","4");
	
	add_option("7hide_txtcolor","#fff");
	add_option("7hide_txtmargin_left","30");
	add_option("7hide_txtmargin_right","30");
	add_option("7hide_txtbg","#404040");
	add_option("7hide_txtpadding","5");
	add_option("7hide_txtborderleft","0px solid #000");
	add_option("7hide_txtborderright","0px solid #000");
	add_option("7hide_txtborderbottom","0px solid #000");
	add_option("7hide_txtbordertop","none");
}

function delOpts(){
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
	delete_option("7hide_txtpdeleteing");
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
				padding:<?php echo get_option("7hide_buttonpadding"); ?>px;
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
				margin-left:<?php echo get_option("7hide_txtmargin_left"); ?>px;
				margin-right:<?php echo get_option("7hide_txtmargin_right"); ?>px;
				background-color:<?php echo get_option("7hide_txtbg"); ?>;;
				padding:<?php echo get_option("7hide_txtpadding"); ?>px;
				border-left:<?php echo get_option("7hide_txtborderleft"); ?>;
				border-right:<?php echo get_option("7hide_txtborderright"); ?>;
				border-bottom:<?php echo get_option("7hide_txtborderbottom"); ?>;
				border-top:<?php echo get_option("7hide_txtbordertop"); ?>;
			}
		</style><?php
}


function makeHidden($atts, $content=null){
	
	$hide_title = get_option("7hide_title");
	$bclick = get_option("7hide_buttonbgclick");
	$b = get_option("7hide_buttonbg");
    return '<span class="hiddenb" onselectstart="return false;"
    		onmousedown="this.style.backgroundColor=\''.$bclick.'\';if (typeof event.preventDefault != \'undefined\') {event.preventDefault();}" 
    		onclick="if(this.style.visibility!=\'visible\'){this.style.visibility=\'visible\';this.childNodes[\'1\'].style.display=\'block\';} else{this.style.visibility=\'hidden\';this.childNodes[\'1\'].style.display=\'none\';};" ><span class="hiddenbutton" onmouseup="this.style.backgroundColor=\''.$b.'\'" onmousedown="this.style.backgroundColor=\''.$bclick.'\'">'.$hide_title.'</span><span name="txt" style="display:none;" class="hiddent">'. $content . '</span>
    		</span>';
}

?>