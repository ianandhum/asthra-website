$(document).ready(function () {
	$("#cover").css({bakground:"rgba(0,0,0,0.5)"}).hide();
	$('.page').hide();
	$('#home').show();
	$("#home-ico").addClass('active');
	if ($(window).width()>700) {
		$('.page-slide').css({height : $(window).height(),width: $("#content").width()});
	}
	else {
		$('.page-slide').css({height : 200,width: $("#content").width()});

	}
	$('.page-slide').first().css({height:150});
	
	$('#home-ico').click(function () {
		$('.panel-elem').removeClass('active');
		$(this).addClass('active');
		$('.page').hide();
		$('#home').fadeIn();
		$(document).scrollTop(0);
	});
	$("#challenge-bt").click(function () {
		$('.panel-elem').removeClass('active');
		$("#panel-events").addClass('active');
		$('.page').hide();
		$('#events').fadeIn();
		$(document).scrollTop(0);
		adjustElements("#events");
	});
	$('#panel-events').click(function () {

		if ($("#user-events").attr("commit")=="1") {
			//add
			$("#user-events > .event").each(function () {
				if ($(this).attr("state")=="UNSET") {
					$(this).remove();
					eventItemdeInflate($(this));
					$(".rm_event_bt",this).removeClass('rm_event_bt bt-red').css({background:""}).text("Register").attr({"state":"UNSET"}).addClass("add_event_bt bt-green");
					$("#events").append(this);
				}
			});
			addListeners();
		}
		$('.panel-elem').removeClass('active');
		$(this).addClass('active');
		$('.page').hide();
		$('#events').fadeIn();
		adjustElements("#events");
		if ($(".event","#events").length<1) {
			$('.empty-sym',"#events").show();
		}
		else {

			$('.empty-sym',"#events").hide();
		}
	});
	$('#panel-user-events').click(function () {
		if ($("#events").attr("commit")=="1") {
			//add
			$("#events > .event").each(function () {
				if ($(this).attr("state")=="SET") {
					$(this).remove();
					eventItemdeInflate($(this));
					$(".add_event_bt",this).removeClass('add_event_bt bt-green').css({background:""}).text("Remove").attr({"state":"SET"}).addClass("rm_event_bt bt-red");
					$("#user-events").append(this);
				}
			});
			addListeners();
		}
		$('.panel-elem').removeClass('active');
		$(this).addClass('active');
		$('.page').hide();
		$('#user-events').fadeIn();
		$(document).scrollTop(0);
		adjustElements("#user-events");
		if ($(".event","#user-events").length<1) {
			$('.empty-sym',"#user-events").show();
		}
		else {

			$('.empty-sym',"#user-events").hide();
		}

	});
	$('#panel-user-info').click(function () {
		$('.panel-elem').removeClass('active');
		$(this).addClass('active');
		$('.page').hide();
		$('#user-info').fadeIn();
		$(document).scrollTop(0);
		adjustElements("#user-events");
	});

	$('#panel-user-logout').click(function () {
		$("#cover").append($("<div>logging out</div>").css({color:"#fff",margin:"100px 0","font-variant":"small-caps","font-size":"20px"})).show();
		location.replace("ref/std/logout.php");
	});
	addListeners();
});
function addListeners() {
		$('.add_event_bt').click(function () {
		if ($(this).attr('state')!="SET") {
			$(this).css({"background-color":"#960"}).text("Requesting...");
			//ajax script for adding new event
			//on success
			var self=this;
			jQuery.post("ref/std/user_events.php",{action:"add_event",response:"JSON",id:$(self).attr('data')},function (data,status) {
						//console.log(data);
						//var dataJSON=JSON(data);
						if (data.status==0) {
							//$(self).css({"background-color":"#d22"}).text("Failed!");

							eventItemInflate($(self).parent(),data.msg,false);
						}
						else {
							//$(self).css({"background-color":"#09c"}).text("APPLIED!");
							//hide .event class
							eventItemInflate($(self).parent(),data.msg);
							$(self).parent().attr({"state":"SET"});
							$('#events').attr({'commit':'1'});
							$(self).off("click");
						}
			});
			}
	});
	$('.rm_event_bt').click(function () {
		if ($(this).parent().attr('state')=="SET") {
			$(this).css({"background-color":"#c60"}).text("Requesting...");
			//ajax script for adding new event
			//on success
			var self=this;
			jQuery.post("ref/std/user_events.php",{ action :"rm_event",response:"JSON",id:$(self).attr('data')},function (data,status) {
						if (data.status==0) {
							//$(self).css({"background-color":"#d22"}).text("Failed!");
							eventItemInflate($(self).parent(),data.msg,false);
							$(self).parent().click(function () {
								$(self).click();
							});
						}
						else {
							//$(self).css({"background-color":"#09c"}).text("REMOVED!");
							//hide .event class
							eventItemInflate($(self).parent(),data.msg);
							$(self).parent().attr({"state":"UNSET"});
							$('#user-events').attr({'commit':'1'});
							$(self).off("click");
						}
			});
		}
	});
	$(document).ajaxError(function (evnt,xhr) {
		$("#cover").empty().append($("<div>Request failed click here to reload the page</div>").css({color:"#fff",margin:"200px 0","font-variant":"small-caps","font-size":"24px"})).show().click(function () {
			location.reload();
		});
	});
	$(document).ajaxSend(function () {
		$("#cover").empty().append($("<img src='assets/img/throbber-full.gif'/>").css({margin:"20% auto 10px auto"})).append($("<div>Loading...</div>").addClass("msg")).show();
	});
	$(document).ajaxSuccess(function () {
		$("#cover").empty().fadeOut();
	});
}
function getClassNames(obj) {
		var str=String($(obj).attr('class'));
		return str.split(" ");
}
	//the space is adjusted
	function adjustElements(sel) {
		var boxes=["event-short"],pos=0;
		$(".event",sel).each(function () {
			$(this).attr({"class":"event"}).addClass(boxes[pos]).removeClass("event-margin");
			pos=(pos+1)%boxes.length;
		});
		//suspected but allowed:override
		//need modification ::  remove-the following and TODO:add something worthwhile in the space
		if (($('.event',sel).length)%2==1) {
			$('.event',sel).last().addClass("event-margin");
		}
	}
	//to be triggered on each AJAX request
	function eventItemInflate(evnt,msg,res) {
			var evntH=$(evnt).height(),evntW=$(evnt).width();
			$(".event-perm",evnt).hide();
			$(".event-img",evnt).css({height:"300px"}).show();
			if($(".event-tmp",evnt).length){
				$(".event-tmp",evnt).remove();
			}
				var new_elem=$("<div></div>").css({height:evntH,width:evntW,background:"rgba(0,0,0,0.8)",position:"absolute"}).addClass("event-tmp");
				$(new_elem).prepend($(".event-img > .title-small",evnt).clone().show());
				var stat_img=$("<img src=\"assets/img/checklist.png\"></div>").css({height:90,width:100});
				if (res==false) {
					stat_img.attr({src:"assets/img/checkerror.png"});
				}
				$(stat_img).css({margin:"20px " + ((evntW-100)/2)*100/evntW +"% 0 "+ ((evntW-100)/2)*100/evntW +"%"});
				$(new_elem).append(stat_img);
				$(new_elem).append($("<div>"+msg+"</div>").addClass("msg"));
				$(evnt).prepend(new_elem);
	}
	//to be triggered on before execute of event:click on .panel-elem
	function eventItemdeInflate(evnt) {
			$(".event-img",evnt).css({height:"200px"});
			$(".event-tmp",evnt).remove();
			$(".event-perm",evnt).show();
	}
