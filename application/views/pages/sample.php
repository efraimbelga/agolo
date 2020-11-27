

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body onLoad="document.getElementById('addressBar').innerHTML = document.getElementById('myIframe').src" style="font-family:Verdana, Geneva, sans-serif; text-align:center">
<div style="width:494px; height:14px; border:solid 1px #000000; font-size:12px; margin:0 auto; padding:3px" id="addressBar"></div>
<iframe onLoad="document.getElementById('addressBar').innerHTML = document.getElementById('myIframe').contentWindow.location.href" id="myIframe" style="width:500px; height:500px; border:solid 1px #000000; font-size:12px; margin:0 auto; padding:3px" src="page1.html"></iframe>
</body>
</html>