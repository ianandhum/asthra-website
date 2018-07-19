function createXHR(){
    var xmlHttp=null;
    if(window.ActiveXObejct){
        try{
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(e){
            xmlHttp=false;  
        }
    }
    else{
        try{
            xmlHttp=new XMLHttpRequest();
        }
        catch(e){
            xmlHttp=false;
        }
    }
    return xmlHttp;
}
function ajax(url){
	var xmlHttp=createXHR();
	xmlHttp.onreadystatechange=function(){
	    if(xmlHttp.readyState==3){
				    
	    }
	    else if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
	    				console.log("hell:"+xmlHttp.responseText);
	    }
	    else if(xmlHttp.Status>=400 && xmlHttp.Status<=500){
	       return "Failed";
	    }
	}
	xmlHttp.open("GET",encodeURI(url+"&wekt="+Math.random()*Math.pow(10,17)),true);
	xmlHttp.send(null);
}

