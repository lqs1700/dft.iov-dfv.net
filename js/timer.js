window.onload = function(){
var timer = document.getElementById('timer');

setInterval("timer.innerHTML=new Date().toLocaleString()"); 
	
}