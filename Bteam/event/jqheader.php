$(function(){
	$(".change,.dropdown").hover(function(){
		$(this).css({ backgroundColor:"#f5e56b", height:"30px" });
	},
	function(){
		$(this).css({ backgroundColor:"#EDD634", height:"30px" });

	});
	$(".dropdown").click(function(){
		if($(".child>p").css("visibility")=="hidden"){
			$(".child>p").css("visibility","visible");
		}else{
			$(".child>p").css("visibility","hidden");
		}
	});

	$(".notnow").hover(function(){
		$(this).css("background-color","#f5e56b");
	},
	function(){
		$(this).css("background-color","#f8f4e6");
	});

	$("#button").on("click", function () {
		$(".alert").dialog({
			modal: true,
			width: 500,
			height:150,
			buttons: [
				{	text:"OK",
					class:"dialog_ok",
					click:function(){
						$.post("FN_10.php",{id:eventid},function(data,textStatus) {
							if(textStatus == 'success'){
								window.location.href="PG_11.php";
							}
						}
						,'json');
					}
				},
				{	text:"Cancel",
					class:"dialog_cancel",
					click:function(){
						$(this).dialog("close");
					}
				}
			]
		});
	});
});