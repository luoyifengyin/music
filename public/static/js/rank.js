function onClick(ev){
   	var rank = this.getAttribute("data-rank");
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && 
			(xmlhttp.status>=200 && xmlhttp.status<300 || xmlhttp.status=304)){
			xmlhttp.responseText
		}
	}
}