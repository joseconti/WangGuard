jQuery(document).ready(function () {
jQuery('span.bbp-author-ip').mouseover(function () {
		var thisParentWidth = jQuery(this).parent().width() - 530;
		
		thisParentWidth = thisParentWidth + 'px';



		if (jQuery(this).find('span.bbp-author-ip').length == 0) {
			jQuery('.widefat td').css('overflow', 'visible');
			jQuery(this).css('position', 'relative');
			var thisIP = jQuery(this).attr('data');
			jQuery(this).append('<div class="wangguard-ipinfo wangguard-ipinfo-container" style="left: '+thisParentWidth+'"><div class="wangguard-ipdata-container"><img class="wangguard-ipdata-wait" src="'+wangguard_JSadminurl+'images/wpspin_light.gif" alt="..." /></div><div class="mshot-arrow-right"></div></div>');
			
			data = {
				action	: 'wangguard_ajax_ip_info',
				ip	: thisIP
			};
			
			jQuery(".wangguard-ipdata-container" , this).load( ajaxurl , data);
			
		} else {
			jQuery(this).find('span.bbp-author-ip').css('left', thisParentWidth).show();
		}
	}).mouseout(function () {
		jQuery(this).find('span.bbp-author-ip').hide();
	});
});
	
jQuery.extend({WGtks2AK_URLEncode:function(c){var o='';var x=0;c=c.toString();var r=/(^[a-zA-Z0-9_.]*)/;
  while(x<c.length){var m=r.exec(c.substr(x));
    if(m!=null && m.length>1 && m[1]!=''){o+=m[1];x+=m[1].length;
    }else{if(c[x]==' ')o+='+';else{var d=c.charCodeAt(x);var h=d.toString(16);
    o+='%'+(h.length<2?'0':'')+h.toUpperCase();}x++;}}return o;}
});