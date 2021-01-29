// JavaScript Document
var XMLHttpRequestObject=false;
function add_to_cart_data(add_to_cart_data,discount,competitor,tilecategory)
{
	//alert(document.getElementById("tilecategory").value);	
	//alert(add_to_cart_data);
	//alert(tilecategory);
	//alert(competitor);
	//alert(discount);
		
		if(document.getElementById("tilecategory").value==""){
			alert("Error: Please Select Tile Category");
			return false;
		}
		
		if(document.getElementById("qty").value==""){
			alert("Error: Please Enter QTY");
			return false;
		}else if(isNaN(discount)){
			alert("Error: Please Enter Valid QTY");
			return false;
		}
		
					
	//alert(add_to_cart_data);
	//alert(tilecategory);
//	alert(competitor);
	//alert(discount);
var supply_year = document.getElementById("supply_year").value;
var supply_month = document.getElementById("supply_month").value;
var tilecategory = document.getElementById("tilecategory").value;


//alert(supply_year);
//alert(supply_month);
//alert(tilecategory);

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
//XMLHttpRequestObject.open("GET","add_to_cart_data.php?add_to_cart_data="+add_to_cart_data+"&disc="+discount+"&competitor="+competitor,true);
XMLHttpRequestObject.open("GET","supply_add_to_cart_data.php?add_to_cart_data="+add_to_cart_data+"&disc="+discount+"&supply_year="+supply_year+"&supply_month="+supply_month+"&tilecategory="+tilecategory,true);

XMLHttpRequestObject.send();
}