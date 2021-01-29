// JavaScript Document
var XMLHttpRequestObject=false;
function mtype(show_size)
{
//alert(show_size);
if(window.XMLHttpRequest)
{
XMLHttpRequestObject=new XMLHttpRequest();
}
else if(window.ActiveXObject)
{
XMLHttpRequestObject=new ActiveXObject("Microsoft.XMLHTTP");
} 
XMLHttpRequestObject.onreadystatechange=function()
{
if (XMLHttpRequestObject.readyState==4 && XMLHttpRequestObject.status==200)
{
document.getElementById("show_checklist").innerHTML=XMLHttpRequestObject.responseText;
}
}
XMLHttpRequestObject.open("GET","checklist_display.php?ipg="+show_size,true);
XMLHttpRequestObject.send();
}