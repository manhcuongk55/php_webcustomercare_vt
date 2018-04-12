<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once("includes/groupjs.php");
defined('ISHOME') or die("Can't acess this page, please come back!");
$objschedule = new CLS_SCHEDULE;


$where = " and mem_id='".$GLOBALS['MEM_ID']."' ";
$objschedule->getList($where, "LIMIT 1000");
while ($rs = $objschedule->Fetch_Assoc()) {
	$obj = array(
		'id' => $rs['id'], 
		'title' => $rs['event_subject'],
		'start' => $rs['event_start'],
		'end' => $rs['event_end']
	);
	$data [] = $obj;
}

if (isset($data)) {
	$jsonEvent = json_encode($data);	
} else {
	$jsonEvent =  "null";
}

$userId = "-1";
if (isset($_GET['userid'])) {
	$userId = $_GET['userid'];
}

// echo date("Y-m-d H:i:s", 1488670200);
// echo date("Y-m-d H:i:s", 1488679256.577);

?>
<!-- widget grid -->
<section id="widget-grid" class="">


	<!-- row -->

	<div class="row">
		<div class="alert alert-info fade in" style="margin-bottom: 10px;">
			<button class="close" data-dismiss="alert">
				×
			</button>
			<i class="fa-fw fa fa-info"></i>
			<strong> CHÚ Ý: HỆ THỐNG TỰ ĐỘNG GỬI TIN NHẮN TỚI KHÁCH HÀNG CÓ LỊCH HẸN TRƯỚC 1 NGÀY SO VỚI NGÀY HIỆN TẠI. Ví dụ (7h30 sáng nay, sẽ gửi tới toàn bộ khách hàng có lịch hẹn vào ngày mai)</strong>
		</div>
		<article class="col-sm-12 col-md-12 col-lg-12">


			<div class="jarviswidget jarviswidget-color-teal" id="wid-id-3" data-widget-colorbutton="false">

				<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

				data-widget-colorbutton="false"
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true"
				data-widget-sortable="false"

				-->
				<header>
					<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
					<h2> Đặt lịch hẹn cho khách hàng </h2>
					<div class="widget-toolbar">
						<!-- add: non-hidden - to disable auto hide -->
						<div class="btn-group">
							<button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
								Hiển thị theo <i class="fa fa-caret-down"></i>
							</button>
							<ul class="dropdown-menu js-status-update pull-right">
								<li>
									<a href="javascript:void(0);" id="mt">Ngày trong tháng</a>
								</li>
								<li>
									<a href="javascript:void(0);" id="ag">Ngày trong tuần</a>
								</li>
								<li>
									<a href="javascript:void(0);" id="td">Hôm nay</a>
								</li>
							</ul>
						</div>
					</div>
				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">

						<input class="form-control" type="text">

					</div>
					<!-- end widget edit box -->

					<div class="widget-body no-padding">
						<!-- content goes here -->
						<div class="widget-body-toolbar">

							<div id="calendar-buttons">

								<div class="btn-group">
									<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
									<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
								</div>
							</div>
						</div>
						<div id="calendar"></div>

						<!-- end content -->
					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>
	</div>

	<!-- end row -->

</section>

<!-- form return task -->
<div aria-hidden="true" aria-labelledby="remoteModalLabel" data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1" id="dialog_schedule" class="modal fade" style="display: none; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 id="myModalLabel" class="modal-title"><i class="fa fa-edit"></i><span>
                	Đặt lịch hẹn
                </span></h4>
            </div>
            <div class="modal-body" style="padding-top:0px;">
				<form class="smart-form" id="form-book-schedule" method="POST" novalidate="novalidate">
					<fieldset>
						<div class="row">
							<section class="col col-6 cls_ed_fullname" style="display: none;">
								<label class="label">Họ tên khách hàng</label>
								<label class="input">
									<i class="icon-append fa fa-user"></i>
									<input type="text" id="ed_fullname" value="" readonly="true">
								</label>
							</section>

							<section class="col col-6 cls_add_fullname" style="display: none;">
								<label class="label">Lựa chọn khách hàng</label>
								<label class="select">
									<select id="cbo_user_id" name="cbo_user_id" >
										<?php
											echo  $objschedule->getListUserByMemId($GLOBALS['MEM_ID']);
										?>
									</select><i></i>
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
									<input placeholder="" type="text" name="service_price"  id="service_price" value="">
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
						<a href="#" onclick="cancelBook()" class="btn btn-danger"><i class="fa fa-times-circle"> </i> Đóng</a>
						<a href="#"  class="btn btn-danger" id="cmd_del" style="display: none;"><i class="fa fa-trash-o"> </i> Xóa</a>
						<a href="#"  class="btn btn-primary" id="cmd_save_event"><i class="fa fa-check"> </i> Lưu </a>
					</footer>
					
				</form>		
            </div>
        </div>
    </div>
</div>
<!-- end widget grid -->

<script type="text/javascript">	

	pageSetUp();
	
	/*
	 * PAGE RELATED SCRIPTS
	 */

	// pagefunction
	
	var pagefunction = function() {				
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

		/* END BASIC */
		var $frmBookSchedule = $("#form-book-schedule").validate({
			
			// Rules for form validation
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
		
			// submitHandler : function(form) {
			// 	$(form).ajaxSubmit({
			// 		success : function() {												
			// 			smartInfoMsg('Thông báo', 'Đặt lịch thành công!', 5000);	
			// 		}
			// 	});
			// },

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
		/*
		 * FULL CALENDAR JS
		 */
		
		// Load Calendar dependency then setup calendar
		
		loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/moment/moment.min.js", function(){
			loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/fullcalendar/jquery.fullcalendar.min.js", setupCalendar);
		});


		
		function setupCalendar() {
		
		    if ($("#calendar").length) {
		        var date = new Date();
		        var d = date.getDate();
		        var m = date.getMonth();
		        var y = date.getFullYear();

		        calendar = $('#calendar').fullCalendar({
		
		            editable: false, // true co the thay doi thoi gian bang cach keo chuot
		            draggable: false, // di chuyen event
		            selectable: true, // click chuot vao event
		            selectHelper: true, // show time
		            unselectAuto: true, 
		            disableResizing: false,
		            timeFormat: 'H:mm' ,
		            // defaultView: 'agendaDay',		            
		
		            header: {
		                left: 'title', //,today
		                center: 'prev, next, today',
		                right: 'month, agendaWeek, agenDay' //month, agendaDay,
		            },
					

		            select: function (start, end, allDay) {
		            	
		            	var userIdRedirect = <?php echo $userId;?>;
		            	var now = Number(new Date());
		            	var longStart = Number(new Date(moment(start).format('YYYY-MM-DD HH:mm')));

		            	// if (longStart/1000 < now/1000) {
		            	// 	smartErrorMsg('Thông báo', 'Bạn phải chọn thời gian lớn hơn hoặc bằng thời gian hiện tại', 5000);
		            	// 	return;
		            	// }

		            	$("#dialog_schedule .modal-title span").html("Đặt lịch hẹn");
		            	$(".cls_add_fullname").css("display","block");
		            	$(".cls_ed_fullname").css("display","none");
		            	$("#cmd_del").css("display","none");
		            	
						$("#event_subject").val('');
						$("#event_description").val('');
						$("#service_price").val('');
						$("#event_start").val('');
						$("#event_end").val('');						
		                $("#cbo_user_id").val('');
		                $("#service_name").val('');

		                if (userIdRedirect != "-1") {
		                	$("#cbo_user_id").select2("val", userIdRedirect);
		                } else {
		                	$("#cbo_user_id").select2("val", "");	
		                }		               
						$("#dialog_schedule").modal("show");

		            	var _evt_start = moment(start).format('YYYY-MM-DD HH:mm');
		            	var _evt_end = moment(end).format('YYYY-MM-DD HH:mm');
		            	$("#event_start").val(_evt_start);
		            	$("#event_end").val(_evt_end);		            	

		            	$( "#cmd_save_event" ).click( function() {
		            		$(this).prop('disabled', false);
		            		var invalid = validateFrm();
		            		if (invalid == false) {
    			        		var memId = $("#mem_id").val();
			                	var userId = $("#cbo_user_id").val();
			                	var serviceName = $("#service_name").val();
			                	var servicePrice = $("#service_price").val();
							    var _evt_sub = $("#event_subject").val();
			                	var _evt_des = $("#event_description").val();
			                	_evt_start = moment($("#event_start").val()).format('YYYY-MM-DD HH:mm');
			            		_evt_end = moment($("#event_end").val()).format('YYYY-MM-DD HH:mm');

			            		// if (moment($("#event_start").val()) >= moment($("#event_end").val())) {
			            		// 	smartErrorMsg("Thông báo", "Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc", 3000);
			            		// 	return;
			            		// }

			                	var url = "<?php echo ROOTHOST;?>/ajaxs/processActionSchedule.php";
			                	$.post(url, { action: "add",
			                				  evt_sub: _evt_sub, 
			                				  evt_des: _evt_des, 
			                				  evt_start: _evt_start, 
			                				  evt_end: _evt_end, 
			                				  mem_id: memId, 
			                				  user_id: userId,
			                				  service_name: serviceName,
			                				  service_price: servicePrice
			                				}, function(data) {

									if(data == 'success') {

										calendar.fullCalendar('renderEvent', {
				                            title: _evt_sub,
				                            start: moment($("#event_start").val()),
				                            end: moment($("#event_end").val()),
				                            allDay: false,
				                            editable: false,
				                        	}, true // make the event "stick"
				                   		 );
				                		calendar.fullCalendar('unselect');

				                		$("#dialog_schedule").modal("hide");
										smartInfoMsg('Thông báo', 'Đặt lịch thành công!', 3000);
										setTimeout(function(){
											location.reload();
										}, 1500);


									} else {
										smartErrorMsg('Thông báo', 'Đặt lịch không thành công', 3000);
									}
								})

		            		} else {
		            			$("#form-book-schedule").submit();
		            		}
		    

		            	})
		                
		            },
					
					// generate event to calendar
					events : <?php echo $jsonEvent;?>,
		
		            eventRender: function (event, element, icon) {
		                if (!event.description == "") {
		                    element.find('.fc-event-title').append("<br/><span class='ultra-light'>" + event.description +
		                        "</span>");
		                }
		                if (!event.icon == "") {
		                    element.find('.fc-event-title').append("<i class='air air-top-right fa " + event.icon +
		                        " '></i>");
		                }
		            },

				    eventClick: function(calEvent, jsEvent, view) {
				    	var scheduleId = calEvent.id;
				    	$("#dialog_schedule .modal-title span").html("Chỉnh sửa lịch hẹn");
				    	$(".cls_ed_fullname").css("display","block");
				    	$(".cls_add_fullname").css("display","none");
				    	$("#cmd_del").css("display","block");
				    		
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
		                		$("#service_name").val(obj[0]['serviceName']);
								
								$("#dialog_schedule").modal("show");
							}

				    	})

				    	$( "#cmd_save_event" ).click(function() {
				    		$(this).prop('disabled', false);
	            			var invalid = validateFrmEdit();	            			
		            		if (invalid == false) {
		            			var _evt_sub = $("#event_subject").val();
			                	var _evt_des = $("#event_description").val();
			            		var serviceName = $("#service_name").val();
			            		var servicePrice = $("#service_price").val();
			            		var scheduleId = $("#schedule_id").val();

			            		var _evt_start = moment($("#event_start").val()).format('YYYY-MM-DD HH:mm');
			            		var _evt_end = moment($("#event_end").val()).format('YYYY-MM-DD HH:mm');
			            		// if (moment($("#event_start").val()) >= moment($("#event_end").val())) {
			            		// 	smartErrorMsg("Thông báo", "Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc", 3000);
			            		// 	return;
			            		// }
			            		
			            		var url = "<?php echo ROOTHOST;?>ajaxs/processActionSchedule.php";
			                	$.post(url, { action: "edit",
			                				  evt_sub: _evt_sub, 
			                				  evt_des: _evt_des, 
			                				  evt_start: _evt_start, 
			                				  evt_end: _evt_end, 
			                				  service_name: serviceName,
			                				  service_price: servicePrice,
			                				  schedule_id: calEvent.id

			                				}, function(data) {

									if(data == 'success') {
										smartInfoMsg('Thông báo', 'Cập nhật lịch thành công!', 3000);
										setTimeout(function(){
											location.reload();
										}, 1500);
										$("#dialog_schedule").modal("hide");

									} else {
										smartErrorMsg('Thông báo', 'Cập nhật không thành công', 3000);
									}
								})
		            		} else {
		            			$("#form-book-schedule").submit();		            			
		            		}
							
					 	});
						

				    	// delete schedule
						$("#cmd_del").click(function() {
							smartConfirm('Thông báo', 'Bạn có muốn xóa lịch hẹn này không?', function() {
								var url = "<?php echo ROOTHOST;?>/ajaxs/processActionSchedule.php";
								$.post(url, {action: "delete", schedule_id: scheduleId}, function(data) {
									if(data == 'success') {
										smartInfoMsg('Thông báo', 'Xóa lịch thành công!', 3000);
										$("#dialog_schedule").modal("hide");
										
										setTimeout(function(){
											location.reload();
										}, 1500);

									} else {
										smartErrorMsg('Thông báo', 'Xóa không thành công', 3000);
									}
								})
							})
							
						})
				    }


		        });
		
		    };
		
		    /* hide default buttons */
		    $('.fc-header-right, .fc-header-center').hide();
		
		}
		
		// calendar prev
		$('#calendar-buttons #btn-prev').click(function () {
		    $('.fc-button-prev').click();
		    return false;
		});
		
		// calendar next
		$('#calendar-buttons #btn-next').click(function () {
		    $('.fc-button-next').click();
		    return false;
		});
		
		// calendar today
		$('#calendar-buttons #btn-today').click(function () {
		    $('.fc-button-today').click();
		    return false;
		});
		
		// calendar month
		$('#mt').click(function () {
		    $('#calendar').fullCalendar('changeView', 'month');
		});
		
		// calendar agenda week
		$('#ag').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaWeek');
		});
		
		// calendar agenda day
		$('#td').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaDay');
		});
		
		function validateFrm () {
			var invalid = false;
			if ($("#cbo_user_id").val()=="") {
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
		
	
	};
	
	// end pagefunction
	
	// run pagefunction on load
	//pagefunction();
	loadScript("<?php echo ROOTHOST.THIS_TEM_PATH; ?>js/plugin/jquery-form/jquery-form.min.js", pagefunction);
	
	
</script>
<script type="text/javascript">
	$("#cbo_user_id").select2();

	function cancelBook() {
		$("#dialog_schedule").modal("hide");
	}

	function getServicePrice() {
		var id = $("#service_name").val();		
		$.post('<?php echo ROOTHOST;?>ajaxs/getServicePrice.php', {ServiceId: id}, function(data) {
			$("#service_price").val(data);
		})
	}

	
</script>

<?php 
unset($objschedule);
?>
<style type="text/css">
	#dt_basic thead th {
		text-align: center;
	}
	.error {color: red;}
	.fc-agenda-slots td {
		height: 35px !important;
	}

	.fc-agenda-allday {
		display: none;
	}
</style>