﻿$(function(){
	$(".change,.dropdown").hover(function(){
		$(this).css("background-color","#FFCC66");
	},
	function(){
		$(this).css("background-color","#EDD634");
	});
	$(".dropdown").click(function(){
		if($(".child>p").css("visibility")=="hidden"){
			$(".child>p").css("visibility","visible");
		}else{
			$(".child>p").css("visibility","hidden");
		}
	});
});