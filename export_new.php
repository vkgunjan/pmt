<?php 
  
  
  
  
  //$query = $_GET['val'];

?>





<?php 
$name = 'pmt_summary_'.date('Ymd').'.csv';
if(isset($_POST['export'])){
  $val=base64_decode($_GET['val']);
  include_once('including/connect.php');
  header('Content-Type: text/csv charset=utf-8;');
  header("Content-Disposition: attachment; filename=$name");
  $output = fopen("php://output", "w");
  fputcsv($output, array('Opportunity ID','Lead ID','Deal Type','Sub Type','Account Name','Project Type','Project Sub Type','Project ame','Zone','State','Territory','City','Full Address','Contractor Firm','Project Contact Name','Architect Firm','Architect Name','Channel Partner','Contractor Name','Tiling Date','Tile Potential(SQMT)','Project Tile(INR)','OBL Forecast(INR)','Probability','File Path','Status','Lead Stage','Lead Source','Discussion Remark','Sampling Remark','Quotation Remark','Lead Approval Remark','Lead Rejection Remark','Quotation Approval Remark','Quotation Rejection Remark','Sampling Approval Remark','Sampling Rejection Remark','Lead Approval Date','Lead Reject Date','Sampling Date','Sampling Approval Date','Sampling Reject Date','Product Approval Date','Quotation Date','Quotation Approval Date','Quotation Reject Date','Created On','Last Login','Last Modified','Created By','Manager','Emp Department','Lead Status','Sampling Status','Quotation Status'));
  $query = "SELECT TOP 1000
o.opportunity_id as [Opportunity ID],
o.lead_id as [Lead ID],
d.deal_type as [Deal Type],
s.deal_sub_type as [Sub Type],
c.cka_name as [Account Name],
p.project_type as [Project Type],
ps.project_sub_type as [Project Sub Type],
o.project_name as [Project Name],
st.zone as [Zone],
st.state_name as [State],
t.territory_name as [Territory],
o.city as [City],
o.address as [Full Address],
o.contractor_firm_name as [Contractor Firm],
o.project_contact_name as [Project Contact Name],
o.architect_firm_name as [Architect Firm],
o.architect_name as [Architect Name],
ISNULL(cp.p_name,'') as [Channel Partner],
ISNULL(o.contractor_name, '') as [Contractor Name],
o.tile_stage_date as ['Tiling Date'],
o.project_tile_potential_sqm as [Tile Potential(SQMT)],
o.project_tile_potential_inr as [Project Tile(INR)],
o.obl_sale_forecast_inr as [OBL Forecast(INR)],
o.probability_of_win as [Probability],
ISNULL(f.size,'') as [SKU Size], 
ISNULL(f.qty,'') as [Quantity], 
ISNULL(f.competitor,'') as [Competitor], 
ISNULL(f.sampling,'') as [Sampling], 
ISNULL(f.no_of_samples_given,'') as [Sample Quantity],
ISNULL(f.sample_tile_cateroty,'') as [Sample Tile],
ISNULL(f.final_bid_price,'') as [Final Bid Price],
ISNULL(f.orc,'') as [ORC],
ISNULL(f.freight,'') as [Freight],
ISNULL(f.ad,'') as [AD],
ISNULL(f.price_type,'') as [Price Type],
o.status as [Status],
pc.stage_name as [Lead Stage],
o.lead_source as [Lead Source],
ISNULL(o.fld_remark,'') as [Discussion Remark],
ISNULL(o.spl_remark,'') as [Sampling Remark],
ISNULL(o.ng_remark,'') as [Quotation Remark],
ISNULL(o.lead_approval_remark,'') as [Lead Approval Remark],
ISNULL(o.lead_reject_remark,'') as [Lead Rejection Remark],
ISNULL(o.qt_approval_remark,'') as [Quotation Approval Remark],
ISNULL(o.qt_reject_remark,'') as [Quotation Rejection Remark],
ISNULL(o.sp_approval_remark,'') as [Sampling Approval Remark],
ISNULL(o.sp_reject_remark,'') as [Sampling Rejection Remark],
o.lead_approve_date as ['Lead Approval Date'],
o.lead_reject_date as ['Lead Reject Date'],
o.sampling_date as ['Sampling Date'],
o.sp_approve_date as ['Sampling Approval Date'],
o.sp_reject_date as ['Sampling Reject Date'],
o.product_approval_date as ['Product Approval Date'],
o.quotation_date as ['Quotation Date'],
o.qt_approve_date as ['Quotation Approval Date'],
o.qt_reject_date as ['Quotation Reject Date'],
o.added_date as ['Created On'],
u.last_login as [Last Login],
u.fullname as [Created By],
um.fullname as [Manager],
u.employee_department as [Emp Department],
l.status_name as [Lead Status],
sa.app_status as [Sampling Status],
qs.app_status as [Quotation Status]





from opportunity o
full outer join fld f on f.opp_id = o.opportunity_id
left join app_status qs on qs.app_status_id = o.quotation_status
left join app_status sa on sa.app_status_id = o.sampling_status
left join lead_status_master l on l.status_id = o.lead_approval_status
left join deal_type d on d.deal_type_id = o.deal_type
left join deal_sub_type s on s.deal_sub_type_id = o.sub_type
left join cka_name_master c on c.cka_name_id = o.cka_name_id
left join project_type_master p on p.project_type_id = o.project_type_id
left join project_sub_type_master ps on ps.project_sub_type_id = o.project_sub
left join state_master st on st.state_id = o.state_id
left join territory_master t on t.territory_id = o.territory
left join channel_partner cp on cp.p_id = o.partner
left join pmt_current_stage pc on pc.stage_id = o.current_stage
left join user_management u on u.uid = o.created_by
left join user_management um on um.uid = (select parent_id from user_management where uid = o.created_by)


--where u.employee_department = 'Retail' 

--where o.lead_id like '%MKTG%'

--where o.opportunity_id in ('5015','1799')

--where convert(date, o.added_date) between '2019-04-01' and '2019-07-11'




order by o.opportunity_id desc";
$result = odbc_exec($conn, $val);
while($row = odbc_fetch_array($result)){
  fputcsv($output, $row);
  }
  fclose($output);
}


?>