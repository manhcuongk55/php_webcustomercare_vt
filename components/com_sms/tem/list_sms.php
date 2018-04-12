<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objsms=new CLS_SMS;

if(isset($_GET['del'])) {
	$objsms->ID=$_GET['del'];
	$objsms->Delete();
	echo "<script>window.location='".ROOTHOST."list_sms';</script>";
}

if(isset($_POST['startdate'])) {
	$where = " tbl_sms.mem_id='".$GLOBALS['MEM_ID']."' ";
	$startdate = $finishdate = "";
	if (isset($_POST['startdate']) && isset($_POST['finishdate'])) {

		if ($_POST['startdate'] != null || $_POST['startdate'] != "") {
			$startdate = $_POST['startdate'];
		} else if ($_POST['finishdate'] != null || $_POST['finishdate'] != "") {
			$finishdate = $_POST['finishdate'];
		}

		if ($startdate != "" && $finishdate == "") {
			$where.= " and tbl_sms.time_send >= '".$startdate."'";
		} else if ($finishdate != "" && $startdate == "") {
			$where.= " and tbl_sms.time_send <= '".$finishdate."'";
		} else if ($startdate != "" && $finishdate != ""){
			$where.= " and tbl_sms.time_send >= '".$startdate."' and tbl_sms.time_send <= '".$finishdate."'";	
		}
	}	

	if (isset($_POST['cbo_status'])) {
		if ($_POST['cbo_status'] != "") {
			$where.= " and tbl_sms.status='".$_POST['cbo_status']."'";
		}
	}	

	$objsms->getList($where, " LIMIT 1000");

} else {
	$where = " tbl_sms.mem_id= ".$GLOBALS['MEM_ID']." order by tbl_sms.id desc ";
	$objsms->getList($where, "LIMIT 10000");
}

?>
<section class="" id="widget-grid">
	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Quản lý tin nhắn</h2>
				</header>

				<!-- widget div-->
				<div role="content ">
					<!-- widget content -->
					<div class="widget-body no-padding">
						<form action="" id="search-form" class="smart-form" method="POST" novalidate="novalidate">

						<fieldset style="padding: 10px 14px 5px;">
							<div class="row">
								<section class="col col-3">
									<label class="input"> <i class="icon-append fa fa-calendar"></i>
										<input type="text" name="startdate" id="startdate" placeholder="Thời gian từ ngày">
									</label>
								</section>
								<section class="col col-3">
									<label class="input"> <i class="icon-append fa fa-calendar"></i>
										<input type="text" name="finishdate" id="finishdate" placeholder="Đến ngày">
									</label>
								</section>
								<section class="col col-3">
									<label class="select">
										<select name="cbo_status" id="cbo_status">
											<option value="" selected="" disabled="">Trạng thái</option>
											<option value="1">Thành công</option>
											<option value="0">Không thành công</option>
										</select> <i></i> </label>
								</section>
								<section class="col col-3">

									<button type="submit" class="btn btn-primary" style="padding: 6px 10px;">
										Tìm kiếm
									</button>
								</section>
							</div>

						</fieldset>
						
					</form>
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th data-hide="" width="20">No.</th>
									<th data-hide="" width="225px">
										<i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i> Thông tin khách hàng
									</th>
									<th data-hide="">
										<i class="fa fa-fw fa-envelope-o txt-color-blue hidden-md hidden-sm hidden-xs"></i> Nội dung
									</th>
									<th data-hide="" width="80px">
										<i class="fa fa-fw fa-info-circle txt-color-blue hidden-md hidden-sm hidden-xs"></i> Trạng thái
									</th>
									<th data-hide="" width="120px">
										<i class="fa fa-fw fa-clock-o txt-color-blue hidden-md hidden-sm hidden-xs"></i> Thời gian gửi
									</th>
									
									<th data-hide="" width="80px">Hành động</th>
								</tr>
							</thead>
							<tbody class="list_sms">
								<?php
								$stt = 1;							
								while($r=$objsms->Fetch_Assoc()) {
									$id = $r['sms_id'];
								?>
								<tr>
									<td align="center"><?php echo $stt;?></td>
									<td>
										<ul>
											<li><strong>Họ tên: </strong><?php echo $r['user_name'];?></li>
											<li><strong>Điện thoại: </strong><?php echo $r['user_phone'];?></li>
											<li><strong>Nhóm KH: </strong><?php if($r['type']==0) echo "Thường"; else echo "VIP"; ?></li>
											<li><strong>Địa chỉ: </strong><?php echo $r['address'];?></li>
										</ul>
									</td>
									<td><?php echo $r['content'];?></td>
									<td style="text-align: center;" class="status_sms"><?php if($r['status_sms'] == 0) echo "<i class='fa fa-times-circle'></i>"; else echo "<i class='fa fa-check-circle-o'></i>";?></td>
									
									<td><?php echo $r['time_send'];?></td>

									<td align="center">
			                     		<a title="Xóa" href="#" class="btn btn-danger cancel-schedule" onclick="deleteSMS(<?php echo "'".$id."'";?>)"><i class="fa fa-trash-o "></i></a>
			                     	</td>
								</tr>
								<?php $stt++;} ?>
								
							</tbody>
						</table>
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->								


		</article>

	</div>

</section>

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	pageSetUp();
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		$('#startdate').datepicker({
			dateFormat : 'yy-mm-dd',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>'
		}); 

		// START AND FINISH DATE
		$('#finishdate').datepicker({
			dateFormat : 'yy-mm-dd',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
		});
		var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			$('#dt_basic').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

		/* END BASIC */
		
	};
	
	// end pagefunction
	// Load form valisation dependency 
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});

</script>


<script type="text/javascript">
	function deleteSMS(id) {
		smartConfirm('Thông báo', 'Bạn có muốn xóa tin nhắn này không?', function() {
			window.location="<?php echo ROOTHOST?>list_sms/del/" + id;
		})
	}
</script>

<?php 
unset($objsms);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
	.list_sms ul {
		margin: 0px;
		padding: 0px;
		list-style: none;
	}
	.status_sms .fa-times-circle, 
	.status_sms .fa-check-circle-o {
		font-size: 30px;
	}
	.status_sms .fa-check-circle-o {
		color: green;
	}
	.status_sms .fa-times-circle {
		color: red;
	}
</style>

