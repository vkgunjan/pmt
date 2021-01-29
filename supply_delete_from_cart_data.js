// JavaScript Document
var XMLHttpRequestObject=false;
function delete_from_cart_data(delete_from_cart_data)
{
//alert(delete_from_cart_data);
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
document.getElementById("add_to_cart_data").innerHTML=XMLHttpRequestObject.responseText;
//document.getElementById("qty").value.innerHTML=XMLHttpRequestObject.responseText;
//document.getElementById("qty").value
}
}
XMLHttpRequestObject.open("GET","supply_tt.php?delid="+delete_from_cart_data,true);
XMLHttpRequestObject.send();
}