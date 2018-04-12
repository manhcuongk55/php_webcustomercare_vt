<?php
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objschedule=new CLS_SCHEDULE;
$objmysql=new CLS_MYSQL;

if(isset($_POST['startdate'])) {
	$strWhere = " tbl_schedule.mem_id='".$GLOBALS['MEM_ID']."' ";
	$startdate = $finishdate = "";

	if ($_POST['startdate'] != null || $_POST['startdate'] != "") {
		$startdate = $_POST['startdate'];
	} else if ($_POST['finishdate'] != null || $_POST['finishdate'] != "") {
		$finishdate = $_POST['finishdate'];
	}

	if ($startdate != "" && $finishdate == "") {
		$strWhere.= " and tbl_schedule.event_start >= '".$startdate."'";
	} else if ($finishdate != "" && $startdate == "") {
		$strWhere.= " and tbl_schedule.event_start <= '".$finishdate."'";
	} else if ($startdate != "" && $finishdate != ""){
		$strWhere.= " and tbl_schedule.event_start >= '".$startdate."' and tbl_schedule.event_start <= '".$finishdate."'";	
	}
	

	if (isset($_POST['cbo_status'])) {
		if ($_POST['cbo_status'] != "") {
			$strWhere.= " and tbl_schedule.status='".$_POST['cbo_status']."'";
		}
	}	

	if (isset($_POST['cbo_type_custumer'])) {
		if ($_POST['cbo_type_custumer'] != "") {
			$strWhere.= " and tbl_user.type='".$_POST['cbo_type_custumer']."'";
		}
	}

	$objschedule->getListSchedule($strWhere, " LIMIT 1000000");

} else {
	$strWhere = " tbl_schedule.mem_id='".$GLOBALS['MEM_ID']."' ";
	$objschedule->autoUpdateStatusOutDate($GLOBALS['MEM_ID']);
	$objschedule->getListSchedule($strWhere, "LIMIT 200");
}

?>
<section class="" id="widget-grid">

	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="alert alert-info fade in" style="margin-bottom: 10px;">
				<button class="close" data-dismiss="alert">
					×
				</button>
				<i class="fa-fw fa fa-info"></i>
				<strong> Chú ý: Lấy 200 lịch hẹn mới nhất từ ngày hiện tại tới các ngày tiếp theo</strong>
			</div>
			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-teal" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Danh sách lịch hẹn</h2>
					<div class="widget-toolbar">
						<button data-toggle="modal"  class="btn btn-danger" onclick="popupSendSms();" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-envelope-o"></i>
		                  Gửi tin nhắn
		                 </button>
		                  <button data-toggle="modal"  class="btn btn-success" onclick="exportDataToExcel(<?php echo $GLOBALS['MEM_ID'];?>);" style="padding:7px 8px!important; font-weight:bold;">
		                  <i class="fa fa-file-excel-o"></i>
		                  Export DS
		                  </button>

	                 </div>
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
								<section class="col col-2">
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
								<section class="col col-2">
									<label class="select">
										<select name="cbo_type_custumer" id="cbo_type_custumer">
											<option value="" selected="" disabled="">Nhóm khách hàng</option>
											<option value="0">Khách Thường</option>
											<option value="1">Khách VIP</option>
										</select> <i></i> </label>
								</section>
								<section class="col col-2">
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
									<th width="20" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
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
									
									<th data-hide="" width="165px">Hành động</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$stt = 1;	
								while($r=$objschedule->Fetch_Assoc()) {
									$id = $r['schedule_id'];
									$status = $r['status_schedule'];
									$cls = "";
									
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
									<td align="center">
										<input type='checkbox' name='chk' id='chk' onclick='docheckonce("chk");' value='<?php echo $r['user_id']?>' />										
									</td>
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
											<li><strong>Trạng thái: </strong>
												<?php echo $objschedule->getNameStatus($r['status_schedule']);?>
											</li>
										</ul>
										
									</td>
									
									<td>
										<?php echo $r['event_start'];?>
									</td>									

									<td align="center">
			                     		<a title="Sửa" href="#"  class="btn btn-primary cmd_edit_schedule" schedule_id="<?php echo $id;?>"><i class="fa fa-edit"></i></a>

			                     		<a title="Xóa" href="#"  class="btn btn-danger cmd_del_schedule" schedule_id="<?php echo $id;?>"><i class="fa fa-trash-o "></i></a>

			                     		<a title="Chuyển trạng thái" href="#"  scheduleId="<?php echo $id;?>" status="<?php echo $status;?>" class="btn btn-primary cmd_change">
			                     			<i class="fa fa-bell-o"></i>
			                     		</a>

			                     		<a title="Gửi tin nhắn" href="#" scheduleId="<?php echo $id;?>" status="<?php echo $status;?>" memId="<?php echo $GLOBALS['MEM_ID'];?>" class="btn btn-primary cmd_send_sms">
			                     			<i class="fa fa-envelope-o"></i>
			                     		</a>
			                     	</td>
								</tr>


								<?php $stt++;} ?>
								<input type="text" name="txtids" id="txtids" style="display: none" />
								
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

<!-- Popup change avatar -->
<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_change_status" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Cập nhật trạng thái lịch hẹn
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
				<form class="smart-form" id="form_change_status" method="POST" novalidate="novalidate" enctype="multipart/form-data">
					<fieldset>
						<section class="col col-6">
							<label class="label">Trạng thái</label>
							<label for="file" class="select">
								<select name="cbo_status_schedule" id="cbo_status_schedule">
									<option value="">Lựa chọn trạng thái</option>
									<option value="0">Đang chờ</option>
									<option value="1">Đang xử lý</option>
									<option value="2">Hoàn thành</option>
									<option value="-1">Hủy bỏ</option>
									<option value="3">Quá hạn xử lý</option>
								</select>

								<i></i>
							</label>
						</section>
						<input type="hidden" name="schedule_id" value="" id="schedule_id" placeholder="">
					</fieldset>
					<footer>
						
						<a href="#" class="btn btn-primary" id="cmd_save_change_status"><i class="fa fa-check"></i>Lưu </a>
						<a href="#" onclick="cancelChangeStatus()" class="btn btn-danger"><i class="fa fa-times-circle"></i>Hủy</a>
					</footer>
				</form>		
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_edit_schedule" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Chỉnh sửa lịch hẹn
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
				<form class="smart-form" id="frm-edit-schedule" method="POST" novalidate="novalidate">
					<fieldset>
						<div class="row">
							<section class="col col-6 cls_ed_fullname">
								<label class="label">Họ tên khách hàng</label>
								<label class="input">
									<i class="icon-append fa fa-user"></i>
									<input type="text" id="ed_fullname" value="" readonly="true">
								</label>
							</section>

							<section class="col col-6">
								<label class="label">Tên lịch hẹn</label>
								<label class="input">
									<i class="icon-append fa fa-edit"></i>
									<input placeholder="Ví dụ: Chị Linh hẹn làm mặt" type="text" name="event_subject"  id="event_subject" value="">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-8">
								<label class="label">Nội dung dịch vụ sử dụng</label>
								<label class="input">
									<i class="icon-append fa fa-edit"></i>
									<input placeholder="Ví dụ: Trị vết nám da mặt" type="text" name="service_name"  id="service_name" value="">
								</label>
							</section>

							<section class="col col-4">
								<label class="label">Chi phí dịch vụ</label>
								<label class="input">
									<i class="icon-append fa fa-edit"></i>
									<input placeholder="Ví dụ: Trị vết nám da mặt" type="text" name="service_price"  id="service_price" value="">
								</label>
							</section>
						</div>
						
						<section>
							<label class="label">Nội dung gửi SMS</label>
							<label class="textarea">
								<i class="icon-append fa fa-check-square-o"></i>
								<textarea name="event_description"  id="event_description" placeholder="Vi du: Opavn xin thông báo: Chieu nay 2h chi co lich hen qua Trung tam dieu trị vet nam, chi nho den dung gio chi nhe."></textarea>
							</label>
						</section>

						<div class="row">
							<section class="col col-6">
								<label class="label">Thời gian</label>
								<label class="input">
									<i class="icon-append fa fa-calendar"></i>
									<input placeholder="" type="text" name="event_start"  id="event_start" value="">
								</label>
							</section>
							<section class="col col-6" style="display: none;">
								<label class="label">Thời gian kết thúc</label>
								<label class="input">
									<i class="icon-append fa fa-calendar"></i>
									<input placeholder="" type="text" name="event_end"  id="event_end" value="">
								</label>
							</section>
	
						</div>
						
						<input type="hidden" name="mem_id" value="<?php echo $GLOBALS['MEM_ID'];?>" id="mem_id">

					</fieldset>
					
					<footer>
						<input type="hidden" name="schedule_id" id="schedule_id" value="">
						<a href="#" onclick="cancelBook()" class="btn btn-danger"><i class="fa fa-times-circle"> </i> Đóng</a>
						<a href="#"  class="btn btn-primary" id="cmd_save_event"><i class="fa fa-check"> </i> Lưu </a>
					</footer>
					
				</form>		
            </div>
        </div>
    </div>
</div>

<!-- Popup change avatar -->
<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_send_multi_sms" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Gửi tin nhắn qua hệ thống eSMS
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
            	<span><strong style="color: red;">Chú ý: Nội dung tin nhắn này sẽ được gửi tới một hoặc nhiều khách hàng</strong></span>
				<form class="smart-form" id="frm-send-sms" method="POST" novalidate="novalidate">
					<fieldset>
						<section>
							<label class="label">Nội dung gửi SMS</label>
							<label class="textarea">
								<i class="icon-append fa fa-check-square-o"></i>
								<textarea name="sms_content"  id="sms_content" placeholder="Vi du: Opavn xin thông báo: Chieu nay 2h chi co lich hen qua Trung tam dieu trị vet nam, chi nho den dung gio chi nhe."></textarea>
							</label>
						</section>
						<input type="hidden" name="schedule_id" value="" id="schedule_id" placeholder="">
					</fieldset>
					<footer>
						<a href="#" onclick="cancelSendSms()" class="btn btn-danger"><i class="fa fa-times-circle"></i>Hủy</a>

						<a href="#" class="btn btn-primary" onclick="sendMultipleSms(<?php echo $GLOBALS['MEM_ID'];?>)"><i class="fa fa-check"></i>Send SMS by eSMS </a>
						<!-- <a href="#" class="btn btn-primary" onclick="sendSMSUsb3G(<?php echo $GLOBALS['MEM_ID'];?>)"><i class="fa fa-check"></i>Send USB 3G</a> -->

					</footer>
				</form>		
            </div>
        </div>
    </div>
</div>
<!-- end widget grid -->

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
		// START AND FINISH DATE
		$('#event_start').datetimepicker({
			dateFormat : 'dd-mm-yy HH:mm',
			viewDate:'23-04-2015 23:00',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#event_start').datetimepicker('option', 'minDate', selectedDate);
			}
		}); 

		// START AND FINISH DATE
		$('#event_end').datetimepicker({
			dateFormat : 'dd-mm-yy HH:mm',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#event_end').datetimepicker('option', 'minDate', selectedDate);
			}
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
		var $frmEditSchedule = $("#frm-edit-schedule").validate({
			
			rules : {
				cbo_user_id: {
					required : true
				},
				event_subject: {
					required : true				
				},
				event_description : {
					required : true
				},
				service_name : {
					required : true
				},
				event_start : {
					required : true
				},
				event_end : {
					required : true
				}

			},

			// Messages for form validation
		
			messages : {
				event_subject: {
					required : "Nhập tên lịch hẹn"	
				},
				
				event_description : {
					required : "Nhập nội dung lịch hẹn"
				},
				cbo_user_id : {
					required : "Lựa chọn khách hàng"
				},
				service_name : {
					required : "Chọn dịch vụ sử dụng"
				},
				event_start : {
					required : "Chọn thời gian bắt đầu"
				},
				event_end : {
					required : "Chọn thời gian kết thúc"
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});

		// START AND FINISH DATE
		$('#txt_birthday').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
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
	$("#cbo_status_schedule").select2();

	$(".cmd_change").click(function() {
		var status = $(this).attr("status");
		var id = $(this).attr("scheduleId");
		$("#dialog_change_status").modal("show");
		$("#schedule_id").val(id);	
		$("#cbo_status_schedule").select2("val", status);
	})

	function cancelChangeStatus() {
		$("#dialog_change_status").modal("hide");
	}	

	function cancelBook() {
		$("#dialog_edit_schedule").modal("hide");
	} 

	/*Change status schedule*/
	$("#cmd_save_change_status").click(function() {
		var status = $("#cbo_status_schedule").val();
		var schedule_id = $("#schedule_id").val();
		$.post("<?php echo ROOTHOST?>ajaxs/processActionSchedule.php", {
				action: "change_status", 
				schedule_id: schedule_id, 
				status_change: status				
			}, function($rep) {
			if($rep == 'success') {
				$("#dialog_change_status").modal("hide");
				smartInfoMsg('Thông báo', 'Cập nhật thành công!', 3000);
				setTimeout(function(){
					location.reload();
				}, 3000)
			} else {
				smartErrorMsg('Thông báo', 'Không thành công', 3000);
			}
		})
	})

	/*Event delete schedule*/
	$(".cmd_del_schedule").click(function() {
		var scheduleId = $(this).attr("schedule_id");
		smartConfirm('Thông báo', 'Bạn có muốn xóa lịch hẹn này không?', function() {
				var url = "<?php echo ROOTHOST;?>/ajaxs/processActionSchedule.php";
				$.post(url, {action: "delete", schedule_id: scheduleId }, function(data) {
					if(data == 'success') {
						smartInfoMsg('Thông báo', 'Xóa lịch thành công!', 3000);
						setTimeout(function(){
							location.reload();
						}, 3000)
					} else {
						smartErrorMsg('Thông báo', 'Xóa không thành công', 3000);
					}
				})
			})
	});

	/*Event edit schedule of customer*/
	$(".cmd_edit_schedule").click(function() {
		var scheduleId = $(this).attr('schedule_id');
		$.post('<?php echo ROOTHOST;?>ajaxs/getInfoSchedule.php', {scheduleId : scheduleId}, function($rep) {
    		var obj = jQuery.parseJSON($rep);	
    		if(obj[0]['rep']=='yes') {
    			
				$("#ed_fullname").val(obj[0]['fullname']);
				$("#event_subject").val(obj[0]['evtSub']);
				$("#event_description").val(obj[0]['evtDes']);
				$("#service_price").val(obj[0]['servicePrice']);
				$("#service_name").val(obj[0]['serviceName']);
				$("#event_start").val(obj[0]['evtStart']);
				$("#event_end").val(obj[0]['evtEnd']);        		
        		$("#schedule_id").val(scheduleId);
				
				$("#dialog_edit_schedule").modal("show");
			}

    	})		

	});

	/*Event save info event*/
	$("#cmd_save_event").click(function() {
		var invalid = validateFrmEdit();
		if (invalid == false) {
			var _evt_sub = $("#event_subject").val();
        	var _evt_des = $("#event_description").val();
        	var _evt_start = $("#event_start").val();
    		var _evt_end = $("#event_end").val();
        	var serviceName = $("#service_name").val();
        	var servicePrice = $("#service_price").val();
        	var schedule_id = $("#schedule_id").val();

        	var url = "<?php echo ROOTHOST;?>/ajaxs/processActionSchedule.php";
        	$.post(url, { action: "edit",
        				  evt_sub: _evt_sub, 
        				  evt_des: _evt_des, 
        				  evt_start: _evt_start, 
        				  evt_end: _evt_end, 
        				  service_name: serviceName,
        				  service_price: servicePrice,
        				  schedule_id: schedule_id
        				}, function(data) {

				if(data == 'success') {				
            		$("#dialog_edit_schedule").modal("hide");
					smartInfoMsg('Thông báo', 'Cập nhật thành công!', 3000);
					setTimeout(function(){
						location.reload();
					}, 1500);


				} else {
					smartErrorMsg('Thông báo', 'Không thành công', 3000);
				}
			})

		} else {
			$("#frm-edit-schedule").submit();
		}
	})

	/*Event click button send sms each user on row by eSMS*/
	$(".cmd_send_sms").click(function() {
		var scheduleId = $(this).attr('scheduleId');
		var status = $(this).attr('status');
		var memId = $(this).attr('memId');
		smartConfirm('Thông báo', 'Bạn có chắc gửi tin nhắn cho khách hàng này không?', function() {
			console.log(scheduleId);
			$.post('<?php echo ROOTHOST;?>cronjob/send_sms_schedule.php', {scheduleId : scheduleId, status: status, memId: memId}, function(data) {
	    		
	    		if(data=='success') {
	    			smartInfoMsg('Thông báo', 'Gửi tin nhắn thành công!', 3000);
				} else {
					smartErrorMsg('Thông báo', 'Gửi không thành công, bạn có thể kiểm tra số dư tài khoản trên hệ thống eSMS của mình.', 5000);
				}

	    	})		
		})
		
	});

	/*get price of service*/
	function getServicePrice() {
		var id = $("#service_name").val();		
		$.post('<?php echo ROOTHOST;?>ajaxs/getServicePrice.php', {ServiceId: id}, function(data) {
			$("#service_price").val(data);
		})
	}

	function popupSendSms() {
		$("#dialog_send_multi_sms").modal("show");
	}

	/*Function send sms by eSMS*/
	function sendMultipleSms(memId) {
		var lstPhone = $("#txtids").val();			
		if (lstPhone == '' || lstPhone == null) {
			smartErrorMsg('Thông báo', 'Bạn phải chọn khách hàng muốn gửi tin nhắn trước!', 5000);
			return;
		} 

		var sms_content = $("#sms_content").val();			
		$.post('<?php echo ROOTHOST;?>cronjob/send_sms_schedule.php', {lstPhone: lstPhone, memId: memId, SmsContent: sms_content}, function(data) {
			if (data=='success') {
				smartInfoMsg('Thông báo', 'Gửi tin nhắn thành công!', 3000);
				$("#dialog_send_multi_sms").modal("hide");
			} else {				
				smartErrorMsg('Thông báo', 'Gửi không thành công, bạn có thể kiểm tra số dư tài khoản trên hệ thống eSMS của mình.', 5000);
			}
		})
	} 

	/*Function do send sms by usb 3G*/
	function sendSMSUsb3G(memId) {
		var lstIds = $("#txtids").val();	
		if (lstIds == '' || lstIds == null) {
			smartErrorMsg('Thông báo', 'Bạn phải chọn khách hàng muốn gửi tin nhắn trước!', 5000);
			return;
		} 

		$(".img_loading").css("display","block");
		var smsContent = $("#sms_content").val();

		$.post('<?php echo ROOTHOST;?>api/CallApiWebService.php', {lstIds: lstIds, memId: memId, smsContent: smsContent}, function(data) {
			smartInfoMsg('Thông báo', 'Gửi tin nhắn thành công!', 3000);
			$(".img_loading").css("display","none");
			$("#dialog_send_multi_sms").modal("hide");
		})
	}

	/*Cancel form send sms */
	function cancelSendSms () {
		$("#dialog_send_multi_sms").modal("hide");	
	}

	/*Export data to file excels*/
	function exportDataToExcel(memId) {
		var lstIds = $("#txtids").val();
		if (lstIds == '' || lstIds == null) {
			smartErrorMsg('Thông báo', 'Bạn phải chọn khách hàng trước khi trích xuất thông tin!', 3000);
			return;
		}
		window.location.href = "<?php echo ROOTHOST;?>ajaxs/ExportDataUserToExcels.php?lstIds="+lstIds+"&memId="+memId;

	}
	/*end*/

	/*Validate form*/
	function validateFrmEdit () {
		var invalid = false;
		if ($("#ed_fullname").val()=="") {
			invalid = true;
		}
		if ($("#event_subject").val()=="") {
			invalid = true;
		}
		if ($("#event_description").val()=="") {
			invalid = true;
		}
		if ($("#service_name").val()=="") {
			invalid = true;
		}
		if ($("#event_start").val()=="") {
			invalid = true;
		}
		if ($("#event_end").val()=="") {
			invalid = true;
		}

		return invalid;
	}


</script>

<?php 
unset($objschedule);
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

