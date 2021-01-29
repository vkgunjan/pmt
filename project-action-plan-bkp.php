<?php
//session_start();
//print_r($_SESSION);

//echo '<br>'.$_GET['pid'];
?>
 <script>
function loadDoc(refered_by) {
	//alert(refered_by);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML =  this.responseText;
    }
  };
//document.getElementById("show_size").innerHTML=XMLHttpRequestObject.responseText;

// XMLHttpRequestObject.open("GET","show_size.php?ipg="+show_size,true);
  xhttp.open("GET", "responsible-employee-list.php?ref_name="+refered_by, true);
  xhttp.send();
}
</script>

<script>
function show(){

	alert("action_plan_activity: "+document.getElementById("action_plan_activity").value);
	alert("refered_by: "+document.getElementById("refered_by").value);
	alert("refered_by_name: "+document.getElementById("refered_by_name").value);
	alert("tile_stage_date"+ document.getElementById("tile_stage_date").value);
	alert("request_remarks"+ document.getElementById("request_remarks").value);

}
</script>

 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form-horizontal">
	<h3 align="left">Project Action Plan</h3>

          <table border="0" style="width:100%" align="center">

        <tr height="27">
			<th colspan="4" align="left"  style="background-color:#0099CC; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
            	&nbsp; Project Influencer Role & Degree of Influence 
            </th>
		</tr>
        
        
		<tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th> Degree of Influence </th>  
		    <th> OBL Perception Rating</th>
		</tr>


		<tr>
			<th>Key Purchaser</th>
			<th> <input type="text"></th>
			<th> 
				<select name="degree_k">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</th>         
      <th>
				<select name="degree_k">
                <option>-Select Rating-</option>
					<option value="high">-5</option>
					<option value="low">-4</option>
					<option value="medium">-3</option>
					<option value="high">-2</option>
					<option value="low">-1</option>
					<option value="medium">0</option>
					<option value="high">1</option>
					<option value="low">2</option>
					<option value="medium">3</option>
					<option value="high">4</option>
					<option value="low">5</option>
				</select>

      </th>
    </tr>
		<tr>
			<th>Architect Involved</th>
			<th> <input type="text"></th>
			<th> 
				<select name="degree_a">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</th> 
      <th>
				<select name="degree_k">
                                <option>-Select Rating-</option>
					<option value="high">-5</option>
					<option value="low">-4</option>
					<option value="medium">-3</option>
					<option value="high">-2</option>
					<option value="low">-1</option>
					<option value="medium">0</option>
					<option value="high">1</option>
					<option value="low">2</option>
					<option value="medium">3</option>
					<option value="high">4</option>
					<option value="low">5</option>
				</select>
      </th>
		</tr>
		<tr>
			<th>OBL Champion</th>
			<th> <input type="text"></th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</th>  
      <th>
				<select name="degree_k">
                                <option>-Select Rating-</option>
					<option value="high">-5</option>
					<option value="low">-4</option>
					<option value="medium">-3</option>
					<option value="high">-2</option>
					<option value="low">-1</option>
					<option value="medium">0</option>
					<option value="high">1</option>
					<option value="low">2</option>
					<option value="medium">3</option>
					<option value="high">4</option>
					<option value="low">5</option>
				</select>
      </th>
		</tr>


<tr>
			<th>User / Project Manager</th>
			<th> <input type="text"></th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</th>  
      <th>
				<select name="degree_k">
                                <option>-Select Rating-</option>
					<option value="high">-5</option>
					<option value="low">-4</option>
					<option value="medium">-3</option>
					<option value="high">-2</option>
					<option value="low">-1</option>
					<option value="medium">0</option>
					<option value="high">1</option>
					<option value="low">2</option>
					<option value="medium">3</option>
					<option value="high">4</option>
					<option value="low">5</option>
				</select>
      </th>
		</tr>


<tr>
			<th>Key Decision Maker</th>
			<th> <input type="text"></th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
				</select>
			</th>  
      <th>
				<select name="degree_k">
                                <option>-Select Rating-</option>
					<option value="high">-5</option>
					<option value="low">-4</option>
					<option value="medium">-3</option>
					<option value="high">-2</option>
					<option value="low">-1</option>
					<option value="medium">0</option>
					<option value="high">1</option>
					<option value="low">2</option>
					<option value="medium">3</option>
					<option value="high">4</option>
					<option value="low">5</option>
				</select>
      </th>
		</tr>
</table>
<br />
<table width="100%" border="0">

 		<tr height="27">
			<th colspan="4"  align="left" style="background-color:#0099CC; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
            	&nbsp; Key Purchase Driver for Project
            </th>
		</tr>

		<tr>
        <th>&nbsp;</th>
        <th>Degree of Influence</th>
        <th>OBL Strength</th>
        <th>OBL Weekness</th>
        </tr>
        
        <tr>
			<th>Account Relationship</th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Modrate</option>
					<option value="low">Low</option>
					<option value="medium">Not Important</option>
				</select>
			</th>  
			
            <th rowspan="5" valign="top">
            <textarea rows="7" style="resize:none;"> </textarea>
            </th>
           	
            <th rowspan="5" valign="top">
            <textarea rows="7" style="resize:none;"></textarea>
            </th>
		</tr>


		
        <tr>
			<th>Product Quality</th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Modrate</option>
					<option value="low">Low</option>
					<option value="medium">Not Important</option>
				</select>
			</th>  
		</tr>


<tr>
			<th>Product Price </th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Modrate</option>
					<option value="low">Low</option>
					<option value="medium">Not Important</option>
				</select>
			</th>  
		</tr>


<tr>
			<th>Design Options</th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Modrate</option>
					<option value="low">Low</option>
					<option value="medium">Not Important</option>
				</select>
			</th>  
		</tr>


<tr>
			<th>Any Other</th>
			<th> 
				<select name="degree_c">
					<option value="high">High</option>
					<option value="low">Modrate</option>
					<option value="low">Low</option>
					<option value="medium">Not Important</option>
				</select>
			</th>  
		</tr>
</table>
<hr />

<h3 align="left">30 Day Action Plan</h3>

          <table border="0" style="width:100%" align="center">

       <tr>
			<th>Activity</th>
			<th>Department</th>  
			<th>Responsible Owner</th>  
			<th>Date Timeline</th> 
            <th>Request Remarks</th> 
            <th></th> 
        </tr>


		<tr>              
       <th>
				<select name="action_plan_activity" id="action_plan_activity" >
					<option value="">-Select-</option>
					<option value="Architect Brand Approval">Architect Brand Approval</option>
					<option value="Architect SKU Design Approval">Architect SKU Design Approval</option>
					<option value="Business Workshop">Business Workshop</option>                    
					<option value="First Discussion Visit">First Discussion Visit</option>
					<option value="GPS Brand Approval">GPS Brand Approval</option>
					<option value="GPS Tender Approval">GPS Tender Approval</option>
					<option value="Mock Up">Mock Up</option>
					<option value="Plant Visit">Plant Visit</option>                    
					<option value="Prodduct Sampling">Prodduct Sampling</option>
					<option value="Sr. Management Visit">Sr. Management Visit</option>
					<option value="Technical Workshop">Technical Workshop</option>
					<option value="Vendor Registration">Vendor Registration</option>                    

				</select>
			</th>
     	
        	<th>
            	<select name="refered_by" onchange="loadDoc(this.value)" id="refered_by" style="width:120px;">
					<option value="">-Select-</option>
					<option value="BD">BD</option>
					<option value="CKA">CKA</option>
		   			<option value="GPS">GPS</option>
					<option value="Retail">Retail</option>
				</select>
			</th>         

		
         <th>

<div id="demo">

	<select name="" class="select" style="width:200px; height:30px; font-size:13.5px;" id="" >
    <option value="">- Select Employee -</option>
	</select>
</div>
<input type="hidden" name="refered_by_name" id="refered_by_name" />

			</th>   
            
 	<th>
      <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"  name="tile_stage_date"  id="tile_stage_date" style="width:100px;"/>
	</th>    

 	<th>
      <textarea style="width:250px; resize:none;" name="request_remarks" id="request_remarks"></textarea>
	</th>    

    <td>
   
   <input type="button" value="add"  onclick="show();"/>
    </td>

</tr>
</table>

<table border="0" style="width:100%" align="center">
<td colspan="4" height="20"></td>
</tr>

		<tr height="27">
			<th colspan="5"  align="center" style="background-color:#FF9900; font:16px Verdana, Geneva, sans-serif; color:#FFFFFF">
            	List of 30 Day Action Plan
            </th>
		</tr>
</table>

<table border="1" style="width:100%" align="center">

<tr>
	<td>
	    <div id="add_to_cart_data"><?php include('action_plan_cart.php');?></div> 
    </td>
</tr>

</table>

<table border="0" style="width:100%" align="center">
<tr>
	<th colspan="4" align="left">
    <br />Support Required
    <textarea style="width:80%;"></textarea>
    </th>
</tr>
     
</table>
                                    
                            
        <div class="form-actions">
          <br /> <button type="submit"  class="btn blue"><i class="icon-ok"></i> Save</button>
          <button type="button" class="btn" >Cancel</button>
        <br />
        </div>
     </form>
