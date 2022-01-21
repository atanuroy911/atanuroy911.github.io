<?php
$primary_color 		= htmlspecialchars($_REQUEST['primary']);
$secondary_color 	= htmlspecialchars($_REQUEST['secondary']);
$text_color 		= htmlspecialchars($_REQUEST['text']);
$icon_color 		= htmlspecialchars($_REQUEST['icon']);
if(empty($primary_color)){
	$primary_color = 'FFFFFF';
}
if(empty($secondary_color)){
	$secondary_color = 'DEDEDE';
}
if(empty($text_color)){
	$text_color = '232323';
}
if(empty($icon_color)){
	$icon_color = 'dark-icons';
}
$primary 			= '#'.$primary_color;
$secondary 			= '#'.$secondary_color;
$textc 				= '#'.$text_color;
$hex = $secondary;
list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
$hexbg = 'rgb('.$r.','.$g.','.$b.',0.5)';
header("Content-type: text/css; charset: UTF-8");
$css = "
body { background-color: $primary; background-image: none; }
html[dir='ltr'] #toolbarContainer,
.findbar,
.secondaryToolbar { box-shadow: 1px 2px 20px $secondary; -webkit-box-shadow: 1px 2px 20px $secondary; -moz-box-shadow: 1px 2px 20px $secondary; }
html[dir='ltr'] #toolbarSidebar { box-shadow: 1px 2px 20px $secondary; -webkit-box-shadow: 1px 2px 20px $secondary; -moz-box-shadow: 1px 2px 20px $secondary; }
html[dir='ltr'] #sidebarContent { box-shadow: none; }
#sidebarContent { background: $secondary; }
.toolbarButton.toggled,
.splitToolbarButton.toggled > .toolbarButton.toggled,
.secondaryToolbarButton.toggled { background-color: transparent; background-image: none;}
.splitToolbarButton:hover > .toolbarButton,
.splitToolbarButton:focus > .toolbarButton,
.splitToolbarButton.toggled > .toolbarButton,
.toolbarButton.textButton { background-color: transparent; background-image: none; background-clip: padding-box; border: 0px; border-color: transparent; box-shadow: none; }
html[dir='rtl'] .secondaryToolbarButton{ padding-right: 30px; }
.splitToolbarButton > .toolbarButton:hover,
.splitToolbarButton > .toolbarButton:focus,
.dropdownToolbarButton:hover,
.overlayButton:hover,
.overlayButton:focus,
.toolbarButton.textButton:hover,
.toolbarButton.textButton:focus { background-color: transparent; box-shadow: none; }
#toolbarContainer,
.findbar,
.secondaryToolbar { background-color: $primary; background-image: none; }
.pdfViewer .page { border: 0px; border-image: none; box-shadow: 0px 0px 50px -30px; -webkit-box-shadow: 0px 0px 50px -30px; -moz-box-shadow: 0px 0px 50px -30px; margin: 1px auto 15px auto; }
#toolbarSidebar { width: 200px; height: 32px; background-color: $primary; background-image: none; }
.doorHanger:before,
.doorHangerRight:before { border-bottom-color: $primary; }
.doorHanger:after,
.doorHangerRight:after { border-bottom-color: $primary; }
.doorHanger,
.doorHangerRight { border: 0px; }
.toolbarField { padding: 3px 6px; margin: 4px 0 4px 0; border: 1px solid transparent; border-radius: 2px; background-color: $secondary; background-image: none; background-clip: padding-box; border: 1px solid $secondary; border-color: $secondary; box-shadow: none; color: $textc; }

.toolbarField[type='checkbox'] { margin: 10px 0; }
.toolbarLabel { color: $textc; margin: 5px 2px 5px 0; }
.splitToolbarButtonSeparator { padding: 10px 0; background-color: $secondary; display: none; }
.splitToolbarButton:hover > .splitToolbarButtonSeparator,
.splitToolbarButton.toggled > .splitToolbarButtonSeparator { padding: 10px 0; margin: 5px 0; }
.toolbarButton:hover,
.toolbarButton:focus,
.overlayButton,
.secondaryToolbarButton:hover,
.secondaryToolbarButton:focus { background-color: transparent; background-image: none; background-clip: padding-box; border: 0px; border-color: transparent; box-shadow: none; }
.toolbarButton,
.dropdownToolbarButton,
.secondaryToolbarButton,
.overlayButton { border-radius: 0px; }
.horizontalToolbarSeparator { background-color: $secondary; box-shadow: none; display: none; }
.toolbarButton,
.dropdownToolbarButton,
.secondaryToolbarButton,
.overlayButton { color: $textc; border: 0px; }
.overlayButton { color: $textc; border: 1px solid #aaa; background: $secondary; }
.toolbarButton.toggled:hover:active,
.splitToolbarButton.toggled > .toolbarButton.toggled:hover:active,
.secondaryToolbarButton.toggled:hover:active { background: $secondary; border-color: $secondary; box-shadow: none; }
.dropdownToolbarButton > select { color: $textc; background: $hexbg; }
.dropdownToolbarButton > select > option { background-color: $secondary; color: $textc; }
#overlayContainer > .container > .dialog { background-color: $primary; background-image: none; color: $textc; box-shadow: 0px 0px 15px #555; -webkit-box-shadow: 0px 0px 15px #555; -moz-box-shadow: 0px 0px 15px #555; border-radius: 0px; border: 1px solid #eee; }
#tnc-share { background: $secondary; }
.outlineItem > a,
.attachmentsItem > button { color: $textc; }
.outlineItem > a:hover,
.attachmentsItem > button:hover { color: $textc; }
html[dir='ltr'] .verticalToolbarSeparator { display: none; }
html[dir='ltr'] .secondaryToolbarButton { padding-left: 30px; }
html[dir='ltr'] .dropdownToolbarButton { margin: 5px 2px 4px 0; }
html[dir='ltr'] .toolbarButton#sidebarToggle::before { content: url($icon_color/toolbarButton-sidebarToggle.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton#sidebarToggle::before { content: url($icon_color/toolbarButton-sidebarToggle-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .toolbarButton#secondaryToolbarToggle::before { content: url($icon_color/toolbarButton-secondaryToolbarToggle.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton#secondaryToolbarToggle::before { content: url($icon_color/toolbarButton-secondaryToolbarToggle-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .toolbarButton.findPrevious::before { content: url($icon_color/findbarButton-previous.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton.findPrevious::before { content: url($icon_color/findbarButton-previous-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .toolbarButton.findNext::before { content: url($icon_color/findbarButton-next.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton.findNext::before { content: url($icon_color/findbarButton-next-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .toolbarButton.pageUp::before { content: url($icon_color/toolbarButton-pageUp.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton.pageUp::before { content: url($icon_color/toolbarButton-pageUp-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .toolbarButton.pageDown::before { content: url($icon_color/toolbarButton-pageDown.svg); width: 23px; height: 23px; }
html[dir='rtl'] .toolbarButton.pageDown::before { content: url($icon_color/toolbarButton-pageDown-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] #viewOutline.toolbarButton::before { content: url($icon_color/toolbarButton-viewOutline.svg); width: 23px; height: 23px; }
html[dir='rtl'] #viewOutline.toolbarButton::before { content: url($icon_color/toolbarButton-viewOutline-rtl.svg); width: 23px; height: 23px; }
html[dir='ltr'] .outlineItemToggler.outlineItemsHidden::before { content: url($icon_color/treeitem-collapsed.svg); width: 23px; height: 23px; }
html[dir='rtl'] .outlineItemToggler.outlineItemsHidden::before { content: url($icon_color/treeitem-collapsed-rtl.svg); width: 23px; height: 23px; }
.dropdownToolbarButton { background: url($icon_color/toolbarButton-menuArrows.png) no-repeat; }
.toolbarButton.zoomOut::before { content: url($icon_color/toolbarButton-zoomOut.svg); width: 23px; height: 23px; }
.toolbarButton.zoomIn::before { content: url($icon_color/toolbarButton-zoomIn.svg); width: 23px; height: 23px; }
.toolbarButton.presentationMode::before,
.secondaryToolbarButton.presentationMode::before { content: url($icon_color/toolbarButton-presentationMode.svg); width: 23px; height: 23px; }
.toolbarButton.print::before,
.secondaryToolbarButton.print::before { content: url($icon_color/toolbarButton-print.svg); width: 23px; height: 23px; }
.toolbarButton.openFile::before,
.secondaryToolbarButton.openFile::before { content: url($icon_color/toolbarButton-openFile.svg); width: 23px; height: 23px; }
.toolbarButton.download::before,
.secondaryToolbarButton.download::before { content: url($icon_color/toolbarButton-download.svg); width: 23px; height: 23px; }
.toolbarButton.bookmark::before,
.secondaryToolbarButton.bookmark::before { content: url($icon_color/toolbarButton-bookmark.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.firstPage::before { content: url($icon_color/secondaryToolbarButton-firstPage.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.lastPage::before { content: url($icon_color/secondaryToolbarButton-lastPage.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.rotateCcw::before { content: url($icon_color/secondaryToolbarButton-rotateCcw.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.rotateCw::before { content: url($icon_color/secondaryToolbarButton-rotateCw.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.handTool::before { content: url($icon_color/secondaryToolbarButton-handTool.svg); width: 23px; height: 23px; }
.secondaryToolbarButton.documentProperties::before { content: url($icon_color/secondaryToolbarButton-documentProperties.svg); width: 23px; height: 23px; }
.outlineItemToggler::before { content: url($icon_color/treeitem-expanded.svg); width: 23px; height: 23px; display: inline-block; position: absolute; }
#viewThumbnail.toolbarButton::before { content: url($icon_color/toolbarButton-viewThumbnail.svg); width: 23px; height: 23px; }
#viewAttachments.toolbarButton::before { content: url($icon_color/toolbarButton-viewAttachments.svg); width: 23px; height: 23px; }
#viewFind.toolbarButton::before { content: url($icon_color/toolbarButton-search.svg); width: 23px; height: 23px; }

/** Custom Social **/

/* PDF viewer for WordPress Stylesheet
Developed by ThemeNcode 
*/
.tnc_social_share { display: table; margin: 5px 10px; }
.tnc_social_share ul { padding: 0; }
.tnc_social_share ul li { float: left; margin: 0 5px; list-style: none; color: #999; }
.tnc_social_share ul li a { display: block; color: #999; width: 24px; height: 24px; }
.tnc_social_share ul li a.tnc_share { width: 42px; padding-top: 4px; font-weight: bold; font-size: 14px; text-decoration: none; color: #fff; }
.social_icon_d { background: url('$icon_color/share.svg') no-repeat; background-size: 23px 23px; margin: 5px 0; width: 23px; height: 23px; }
.tnc_fb { background: url('$icon_color/facebook.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
.tnc_tw { background: url('$icon_color/twitter.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
.tnc_lin { background: url('$icon_color/linkedin.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
.tnc_whatsapp { background: url('$icon_color/whatsapp.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
.tnc_email { background: url('$icon_color/email.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
.logo_text a { font-size: 18px; color: #fff; padding: 8px 10px 0 0; font-weight: bold; text-decoration: none; }
.logo_block { margin-right: 20px; margin-top: 7px; }

/* popup form */
.popup_content input[type='text'] { border: 1px solid #ddd; border-radius: 5px; padding: 5px 0; margin: 7px 0; color: #666; }
.popup_content textarea { border: 1px solid #ddd; border-radius: 5px; padding: 2px 0; margin: 7px 0; color: #666; }
.popup_content h3 { color: #666; text-align: center; margin-bottom: 10px; }
/* Retina */
@media screen and (-webkit-min-device-pixel-ratio: 2), screen and (min-resolution: 2dppx) {

	/* Rules for Retina screens */
	.toolbarButton::before { -webkit-transform: scale(0.5); transform: scale(0.5); top: -10px; }
	.secondaryToolbarButton::before { -webkit-transform: scale(0.5); transform: scale(0.5); top: -10px; }
	html[dir='ltr'] .toolbarButton::before,
	html[dir='rtl'] .toolbarButton::before { left: -1px; }
	html[dir='ltr'] .secondaryToolbarButton::before { left: -2px; }
	html[dir='rtl'] .secondaryToolbarButton::before { left: 186px; }
	.toolbarField.pageNumber.visiblePageIsLoading,

	.dropdownToolbarButton { background: url($icon_color/toolbarButton-menuArrows@2x.png) no-repeat; background-size: 7px 16px; }
	html[dir='ltr'] .toolbarButton#sidebarToggle::before { content: url($icon_color/toolbarButton-sidebarToggle.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton#sidebarToggle::before { content: url($icon_color/toolbarButton-sidebarToggle-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .toolbarButton#secondaryToolbarToggle::before { content: url($icon_color/toolbarButton-secondaryToolbarToggle.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton#secondaryToolbarToggle::before { content: url($icon_color/toolbarButton-secondaryToolbarToggle-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .toolbarButton.findPrevious::before { content: url($icon_color/findbarButton-previous.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton.findPrevious::before { content: url($icon_color/findbarButton-previous-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .toolbarButton.findNext::before { content: url($icon_color/findbarButton-next.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton.findNext::before { content: url($icon_color/findbarButton-next-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .toolbarButton.pageUp::before { content: url($icon_color/toolbarButton-pageUp.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton.pageUp::before { content: url($icon_color/toolbarButton-pageUp-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .toolbarButton.pageDown::before { content: url($icon_color/toolbarButton-pageDown.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .toolbarButton.pageDown::before { content: url($icon_color/toolbarButton-pageDown-rtl.svg); width: 46px; height: 46px; }
	.toolbarButton.zoomIn::before { content: url($icon_color/toolbarButton-zoomIn.svg); width: 46px; height: 46px; }
	.toolbarButton.zoomOut::before { content: url($icon_color/toolbarButton-zoomOut.svg); width: 46px; height: 46px; }
	.toolbarButton.presentationMode::before,
	.secondaryToolbarButton.presentationMode::before { content: url($icon_color/toolbarButton-presentationMode.svg); width: 46px; height: 46px; }
	.toolbarButton.print::before,
	.secondaryToolbarButton.print::before { content: url($icon_color/toolbarButton-print.svg); width: 46px; height: 46px; }
	.toolbarButton.openFile::before,
	.secondaryToolbarButton.openFile::before { content: url($icon_color/toolbarButton-openFile.svg); width: 46px; height: 46px; }
	.toolbarButton.download::before,
	.secondaryToolbarButton.download::before { content: url($icon_color/toolbarButton-download.svg); width: 46px; height: 46px; }
	.toolbarButton.bookmark::before,
	.secondaryToolbarButton.bookmark::before { content: url($icon_color/toolbarButton-bookmark.svg); width: 46px; height: 46px; }
	#viewThumbnail.toolbarButton::before { content: url($icon_color/toolbarButton-viewThumbnail.svg); width: 46px; height: 46px; }
	html[dir='ltr'] #viewOutline.toolbarButton::before { content: url($icon_color/toolbarButton-viewOutline.svg); width: 46px; height: 46px; }
	html[dir='rtl'] #viewOutline.toolbarButton::before { content: url($icon_color/toolbarButton-viewOutline-rtl.svg); width: 46px; height: 46px; }
	#viewAttachments.toolbarButton::before { content: url($icon_color/toolbarButton-viewAttachments.svg); width: 46px; height: 46px; }
	#viewFind.toolbarButton::before { content: url($icon_color/toolbarButton-search.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.firstPage::before { content: url($icon_color/secondaryToolbarButton-firstPage.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.lastPage::before { content: url($icon_color/secondaryToolbarButton-lastPage.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.rotateCcw::before { content: url($icon_color/secondaryToolbarButton-rotateCcw.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.rotateCw::before { content: url($icon_color/secondaryToolbarButton-rotateCw.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.handTool::before { content: url($icon_color/secondaryToolbarButton-handTool.svg); width: 46px; height: 46px; }
	.secondaryToolbarButton.documentProperties::before { content: url($icon_color/secondaryToolbarButton-documentProperties.svg); width: 46px; height: 46px; }
	.outlineItemToggler::before { -webkit-transform: scale(0.5); transform: scale(0.5); top: -1px; content: url($icon_color/treeitem-expanded.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .outlineItemToggler.outlineItemsHidden::before { content: url($icon_color/treeitem-collapsed.svg); width: 46px; height: 46px; }
	html[dir='rtl'] .outlineItemToggler.outlineItemsHidden::before { content: url($icon_color/treeitem-collapsed-rtl.svg); width: 46px; height: 46px; }
	html[dir='ltr'] .outlineItemToggler::before { right: 0; }
	html[dir='rtl'] .outlineItemToggler::before { left: 0; }
	.social_icon_d { background: url('$icon_color/share.svg') no-repeat; background-size: 23px 23px; margin: 5px 0; width: 23px; height: 23px; }
	.tnc_fb { background: url('$icon_color/facebook.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
	.tnc_tw { background: url('$icon_color/twitter.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
	.tnc_lin { background: url('$icon_color/linkedin.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
	.tnc_whatsapp { background: url('$icon_color/whatsapp.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
	.tnc_email { background: url('$icon_color/email.svg') no-repeat left; background-size: 23px 23px; text-indent: -999em; }
}
.spread .page, .pdfViewer.scrollHorizontal .page, .pdfViewer.scrollWrapped .page{
	margin-left: 6px;
	margin-right: 6px;
}
.tnc-pdf-back-to-btn{
  background: $primary;
  padding: 15px 30px;
  position: fixed;
  right: 10px;
  bottom: 10px;
  border: 1px solid $primary;
}
";
if( $icon_color == "light-icons" ){
	$css .= "
	.tnc-pdf-back-to-btn a{
		color: #fff;
		text-decoration: none;
	}";
} else {
	$css .= "
	.tnc-pdf-back-to-btn a{
		color: #000;
		text-decoration: none;
	}";
}
echo $css;