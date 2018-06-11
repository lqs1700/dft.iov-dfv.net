(function(){
	$('.foot>div').click(function(){
		var index=$(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		$('.content>div').eq(index).show().siblings().hide();		
	})
})()
