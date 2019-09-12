$(function() {

	URL_DOMAIN = 'http://localhost/'

	//alert("------pjax")
	$(document).pjax('[data-pjax] a, a[data-pjax], ul.pagination li a', '#pjax-container')
	//alert("--------pjax2")
	$(document).on('submit', 'form[data-pjax]', function(ev) {
		$.pjax.submit(ev, '#pjax-container')
	})
	//alert("-------pjax3")
	
	//播放歌曲
	$('#pjax-container').delegate('[data-play]', 'click', function() {
		//alert('ajax play')
		var song_id = $(this).data('play')
		$.ajax({
			type: 'GET',
			url: URL_DOMAIN + 'ajax/play',
			data: {id: song_id},
			success: function(res) {
				//alert('success')
				//alert('json:'+res)
				var song = JSON.parse(res);
				//console.log(player)
				player.addSong(song, true);
				//alert('success2')
			},
			error: function() {
				alert('连接服务器失败');
			}
		})
	})

	$('#pjax-container').delegate('[data-add]', 'click', function(){
		var song_id = $(this).data('add')
		$.ajax({
			type: 'GET',
			url: URL_DOMAIN + 'ajax/play',
			data: {id: song_id},
			success: function(res) {
				var song = JSON.parse(res);
				player.addSong(song);
			},
			error: function() {
				alert('连接服务器失败');
			}
		})
	})

	//下载歌曲
	$('#pjax-container').delegate('[data-download]', 'click', function(){
		var song_id = $(this).data('download')
		$.ajax({
			type: 'GET',
			url: URL_DOMAIN + 'ajax/download',
			data: {id: song_id},
			success: function(res){
				// alert(res);
				// return;
				res = JSON.parse(res);
				let a = document.createElement('a');
				a.href = res.url;
				a.download = res.downloadName;
				//a.target = '_blank'
				a.click();
				window.URL.revokeObjectURL(url);
			},
			error: function(){
				alert('连接服务器失败');
			}
		})
	})

	$('#pjax-container').delegate('[data-collect]', 'click', function(){
		var song_id = $(this).data('collect')
		$.ajax({
			type: 'POST',
			url: URL_DOMAIN + 'ajax/collect',
			data: {id: song_id},
			success: function(res){
				//alert(res)
				if (res == 1) alert('收藏成功')
				else if (res == 0) alert('收藏失败')
				else if (res == 2) alert('该歌曲已在收藏列表中')
			},
			error: function(){
				alert('连接服务器失败');
			}
		})
	})

	$('#pjax-container').delegate('[data-delete]', 'click', function(){
		var self = $(this)
		var song_id = self.data('delete')
		$.ajax({
			type: 'POST',
			url: URL_DOMAIN + 'ajax/delete',
			data: {id: song_id},
			success: function(res){
				if (res == 1){
					
				}
			},
			error: function(){
				alert('连接服务器失败');
			}
		})
	})

	// $('#pjax-container').delegate('form[data-ajax-res]', 'submit', function(){
	// 	let form = $(this);
	// 	$.ajax({
	// 		type: form.attr('method'),
	// 		url: form.attr('action'),
	// 		data: form,
	// 		success: function(res){
	// 			alert(res);
	// 		},
	// 		error: function(){
	// 			alert('连接服务器失败')
	// 		}
	// 	})
	// })
})

//$(document).pjax('[data-pjax] a, a[data-pjax]', '#pjax-container')
// $(document).on("pjax:success", function(){
// 	var str = $('#pjax-container').text();
// 	alert(str);
// 	$('#pjax-wrap').attr("src", str.substring(1,str.length-1))
// 	// alert($(this).attr('href'))
// 	// $('#pjax-wrap').document.write(str);
// 	// alert("------------")
// })

// $(function() {
// 	// $('[data-pjax] a, a[data-pjax]').click(function(ev){
// 	// 	$('#pjax-container').attr("src", $(this).attr('href'))
// 	// 	ev.preventDefault();
// 	// })

// 	// $('#pjax-wrap').contentWindow.onload = function(){
// 	// 	alert("******")
// 	// 	document.location.href = "123";
// 	// }
// })