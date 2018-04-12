<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
	$where = " tbl_schedule.mem_id='".$GLOBALS['MEM_ID']."' ";
	$startdate = $finishdate = "";

	if(isset($_POST['startdate'])) {
		if ($_POST['startdate'] != null || $_POST['startdate'] != "") {
			$startdate = $_POST['startdate'];
		} else if ($_POST['finishdate'] != null || $_POST['finishdate'] != "") {
			$finishdate = $_POST['finishdate'];
		}

		if ($startdate != "" && $finishdate == "") {
			$where.= " and tbl_schedule.event_start >= '".$startdate."'";
		} else if ($finishdate != "" && $startdate == "") {
			$where.= " and tbl_schedule.event_start <= '".$finishdate."'";
		} else if ($startdate != "" && $finishdate != ""){
			$where.= " and tbl_schedule.event_start >= '".$startdate."' and tbl_schedule.event_start <= '".$finishdate."'";	
		}

		if (isset($_POST['cbo_status'])) {
			if ($_POST['cbo_status'] != "") {
				$where.= " and tbl_schedule.status='".$_POST['cbo_status']."'";
			}
		}	

		$objReport->getList($where, " LIMIT 1000");

	}

?>
<section class="" id="widget-grid">
	<article class="col-sm-12 col-md-12 col-lg-12">
		<!-- Widget ID (each widget will need unique ID)-->
		<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2>Thống kê doanh số</h2>
			</header>

			<!-- widget div-->
			<div role="content">
				<!-- widget content -->
				<div class="widget-body no-padding list_schedule">
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
												<option value="-1">Bị hủy bỏ</option>
												<option value="0">Đang chờ</option>
												<option value="1">Đang thực hiện</option>
												<option value="2">Đã hoàn thành</option>
												<option value="3">Quá hạn</option>
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
								<th data-hide="" width="180px">
									<i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>Thông tin khách
								</th>
								<th data-hide="">
									<i class="fa fa-fw fa-calendar-o txt-color-blue hidden-md hidden-sm hidden-xs"></i>Tên lịch hẹn
								</th>
								<th data-hide="">
									<i class="fa fa-fw fa-life-bouy txt-color-blue hidden-md hidden-sm hidden-xs"></i>Dịch vụ
								</th>
								<th data-hide=""><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>Thời gian</th>
								<th data-hide="">
									<i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>Trạng thái
								</th>
							
							</tr>
						</thead>
						<tbody>
							<?php
							$stt = 1;			
							$total = 0;				
							while($r=$objReport->Fetch_Assoc()) {
								$id = $r['schedule_id'];
								$status = $r['status_schedule'];
								$cls = "";
								$total += $r['service_price'];
								switch ($status) {
									case '-1':
										$cls = "cls_cancel";
										break;
									case '0':
										$cls = "cls_wait";
										break;
									case '1':
										$cls = "cls_procee";
										break;
									case '2':
										$cls = "cls_done";
										break;
									case '3':
										$cls = "cls_outdate";
										break;
									default:
										# code...
										break;
								}
							?>
							<tr class="record_item">
								<td align="center" class="<?php echo  $cls;?>" style="color:#fff;"><?php echo $stt;?></td>
								<td>
									<ul>
										<li><strong>Họ tên: </strong><?php echo $r['name_user'];?></li>
										<li><strong>Điện thoại: </strong><?php echo $r['phone_user'];?></li>
										<li><strong>Nhóm KH: </strong><?php if($r['type']==0) echo "Thường"; else echo "VIP"; ?></li>
										<li><strong>Địa chỉ: </strong><?php echo $r['address'];?></li>
									</ul>
								</td>
								<td><?php echo $r['event_subject'];?></td>
								<td>
									<ul>
										<li><strong>Tên: </strong><?php echo $r['service_name'];?></li>
										<li><strong>Giá: </strong><span style="color:red"><?php echo number_format($r['service_price']);?></span></li>
										
									</ul>
									
								</td>
								
								<td>
									<?php echo $r['event_start'];?>
								</td>									
								<td align="center"><?php echo $objReport->getNameStatus($r['status_schedule']);?></td>

							</tr>
							<?php $stt++;} ?>

						</tbody>
							<tr>
								<td colspan="3" align="center"><strong>TỔNG</strong></td>
								<td style="color:red; font-size: 15px;font-weight: bold;" align="left"><?php echo  number_format($total);?> VNĐ</td>
								<td></td>
								<td></td>
							</tr>
						
					</table>
				</div>
				<!-- end widget content -->
				
			</div>
			<!-- end widget div -->
			
		</div>
		<!-- end widget -->								


	</article>


</section>

<!-- SCRIPTS ON PAGE EVENT -->
<script type="text/javascript">	
	pageSetUp();
	
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var pagefunction = function() {
		// START AND FINISH DATE
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
	
</script>

<?php 
unset($objReport);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.radio.gender {
		margin-right: 10px !important;
	}
	.list_schedule ul {
		margin: 0px;
		padding: 0px;
		list-style: none;
	}
	.record_item td.cls_cancel {background: #000000}
	.record_item td.cls_wait {background: #FF8C00 !important;}
	.record_item td.cls_procee {background: #7FFF00}
	.record_item td.cls_done {background: #6B8E23}
	.record_item td.cls_outdate {background: #FF0000}

</style>

