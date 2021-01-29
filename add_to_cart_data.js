// JavaScript Document
var XMLHttpRequestObject=false;
function add_to_cart_data(add_to_cart_data,d_location,discount,competitor,tilecategory,obl_price,tile_name)
{
	//alert(document.getElementById("tilecategory").value);	
	//alert(add_to_cart_data);
	//alert(tilecategory);
	//alert(competitor);
	//alert(to_meet_with);
		
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
		if(document.getElementById("obl_price").value==""){
			alert("Error: Please Enter OBL Price");
			return false;
		}
		if(document.getElementById("tile_name").value==""){
			alert("Error: Please Enter Tile Name");
			return false;
		}
		if(document.getElementById("d_location").value==""){
			alert("Error: Please Select Plant Location");
			return false;
		}
		if(document.getElementById("competitor").value==""){
			alert("Error: Please Select Competitor");
			return false;
		}			
	//alert(add_to_cart_data);
	//alert(tilecategory);
//	alert(competitor);
	//alert(discount);
var competitor = document.getElementById("competitor").value;
var tilecategory = document.getElementById("tilecategory").value;
var obl_price = document.getElementById("obl_price").value;
var tile_name = document.getElementById("tile_name").value;
var d_location = document.getElementById("d_location").value;
/*var contact_no = document.getElementById("contact_no").value;*/

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
XMLHttpRequestObject.open("GET","add_to_cart_data.php?add_to_cart_data="+add_to_cart_data+"&disc="+discount+"&competitor="+competitor+"&tilecategory="+tilecategory+"&tile_name="+tile_name+"&obl_price="+obl_price+"&d_location="+d_location,true);

XMLHttpRequestObject.send();
}