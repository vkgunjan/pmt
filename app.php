<html>
<head>
<script>
    //Ask the user for name and store it on name variable
    var name = prompt("Please Enter Your Name");

    //This will be called when the link is clicked
    function sendWhatsapp(){
        var url     = "www.abcd.com/?name=" + name;
        var sMsg    = encodeURIComponent( "hi this is " + name + " and my link is " + url );
        var whatsapp_url = "whatsapp://send?text=" + sMsg;
        window.location.href = whatsapp_url;
    }
</script>
</head>
<body>
    <a onclick="sendWhatsapp()">share on whatsapp</a>
</body>
</html>