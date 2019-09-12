$(()=>{	
	$("#pjax-container").delegate("ul.rank_list li.music_item", "mouseover", function(){
		$(this).find(".music_tools").css('display', 'block')
	})
	$("#pjax-container").delegate("ul.rank_list li.music_item", "mouseout", function(){
		$(this).find(".music_tools").css('display', 'none')
	})
})
function overtools(){
	//alert("-------1")
	
	//alert($(this).find(".music_tools").css('display'))
}
function outtools(){
	
}