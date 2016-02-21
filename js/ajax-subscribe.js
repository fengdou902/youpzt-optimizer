//ajax_subscribe
function ajax_subscribe(){
		var url = jQuery("#subscribe-submit").attr("site-url"); //获取a链接的地址		
	   jQuery.ajax({
				url:url,
				data: "soz=ajax&token=open_subscribe&email="+jQuery("#email_subscribe").val(), //传值  				
				dataType: "html",                                
				type: "get",
				contentType:"application/x-www-form-urlencoded",
				beforeSend:function(){
					jQuery("#subscribe_msg").text('正在申请！');
				},
				success:function(message){	
				
				jQuery("#subscribe_msg").text(message);
				if(message.indexOf("成功订阅")>=0||message.indexOf("已存在")>=0){//成功订阅就关闭表单
					jQuery('.subscribe-main').fadeOut('slow',function(){
							jQuery('.subscribe-main').remove();
						});
					jQuery.get(url+"?token=cancel_subscribe");//取消显示订阅表单
				}
				
				},
				error: function() {
					jQuery("#subscribe_msg").html("AJAX Error...");
							 },
		 }); 
	
};

jQuery(document).ready(function(){
	//关闭订阅
	jQuery('.youpzt-close').click(function() {
		jQuery('.subscribe-main').fadeOut('slow',function(){
			jQuery('.subscribe-main').remove();
		});
		jQuery.cookie("subscribe_start", "off",{expires:3}); //设置cookie,7天
	});
	//点击订阅
	jQuery('#subscribe-submit').on('click',function() {
		ajax_subscribe();
	});
	
}); //Final Ready