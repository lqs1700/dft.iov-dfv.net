//计算字体大小
		(function(){
			var	getFontSize=function(size){	
				var oHtml=document.querySelector('html');
			
				var nwidth=oHtml.getBoundingClientRect().width;				
				oHtml.style.fontSize=(nwidth/size)+'px';			
			}
				getFontSize(20);
			window.onresize=function(){
				getFontSize(20);
			};
			
			
			
		})();