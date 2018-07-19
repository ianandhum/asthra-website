 var searchFunc=null;
 var tmpTimer=null;
$(document).ready(function() {
    /*
    if($('img').length>0){
    	$('img').last().on("load",function(){
      		$('#cover').hide();
	});
    }
    else{
    */

    //handle all initializers
    var init=function(){
      $('#cover').hide();
      $('#side-menu').metisMenu();
      $('[data-toggle="tooltip"]').tooltip();
      $('body , html').animate({scrollTop:0});
      $("#ajax-progress").hide().css({width:"0%"});
      DataManager.registration.action.startup();
    }
    init();


    //Custom short functions

    //for full screen from @stack-overflow
    function requestFullScreen(element) {
    // Supports most browsers and their versions.
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    else {
        alert("Full screen not Supported press F11");
    }
    }
    function cancelFullScreen(element) {
      // Supports most browsers and their versions.
      var requestMethod = element.cancelFullScreen || element.webkitCancelFullScreen || element.mozCancelFullScreen || element.msCancelFullScreen;

      if (requestMethod) { // Native full screen.
          requestMethod.call(element);
      } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
          var wscript = new ActiveXObject("WScript.Shell");
          if (wscript !== null) {
              wscript.SendKeys("{F11}");
          }
      }
      else {
        alert("Full screen not Supported press F11");
      }
    }

      //custom search function
      searchFunc=function(elem,listSel,cKey){
        var txt=$(elem).val().toLowerCase(),count=0,match=-1;
        $(listSel).filter(function () {
          var searchSea=$(this).text().toLowerCase();
            if (cKey== undefined) {
              searchSea+=$("a",this).attr('keywords').toLowerCase();
            }
          match=(searchSea.indexOf(txt) > -1)?true:false;
          (match)?count++:null;
          if(match){
            $(this).slideDown();
          }
          else {
            $(this).slideUp();
          }
        });
        if(count==0){
            $(elem).parent().parent().removeClass('has-success').addClass("has-warning");
            $(elem).blur(function () {
              $(this).parent().parent().removeClass('has-warning');
            });
        }
        else {
            $(elem).parent().parent().removeClass('has-warning').addClass("has-success");
            $(elem).blur(function () {
              $(this).parent().parent().removeClass('has-success');
            });
        }
      }
      var eventListeners=function(){
        $(document).ajaxStart(function(){
          $("#ajax-progress").css({width:"0%"}).show().css({width:"50%"}).removeClass('progress-bar-danger').addClass('progress-bar-success');
        });
        $(document).ajaxSuccess(function(){
          $("#ajax-progress").css({width:"100%"});
          if(tmpTimer!=null){
            clearInterval(tmpTimer);
          }
          tmpTimer=setInterval(function () {
            $("#ajax-progress").fadeOut().css({width:"0%"});
            clearInterval(tmpTimer);
          },2000);

        });
        $(document).ajaxError(function(){
          $("#ajax-progress").removeClass('progress-bar-success').addClass('progress-bar-danger').css({width:"100%"});
          if(tmpTimer!=null){
            clearInterval(tmpTimer);
          }
          tmpTimer=setInterval(function () {
            $("#ajax-progress").fadeOut().css({width:"0%"});
            clearInterval(tmpTimer);
          },2000);
        });
        $.ajaxSetup({
        xhr: function(){
         var xhr = new window.XMLHttpRequest();
         //Download progress
           xhr.addEventListener("progress", function(evt){
             if (evt.lengthComputable) {
               var percentComplete = evt.loaded / evt.total;
               $("#ajax-progress").css({width:percentComplete*100+"%"});
             }
           }, false);
           return xhr;
         }
        });
        //prevent all forms from submitting
        $('form').submit(function (evt) {
          evt.preventDefault();
        });
        $("#dropdown-fullscreen").click(function(){
          if($(this).attr('screen-state')!="fullscreen"){

            requestFullScreen(document.documentElement);
            $(this).attr({'screen-state':"fullscreen"}).html("<a href='#'><i class='glyphicon glyphicon-resize-small fa-fw'></i>Exit Fullscreen</a>");
          }
          else{
            cancelFullScreen(document);
            $(this).attr({'screen-state':"off"}).html("<a href='#'><i class='glyphicon glyphicon-resize-full fa-fw'></i>Fullscreen</a>");

          }
          });
          $(window).bind("beforeunload",function(){
            return "Warning! ,Changes are not saved";
          });
          $("#navbar-search").on("keyup",function(){
            searchFunc(this,"#side-menu > li:not(.sidebar-search)");
          });
          $("#form-grouping-eventfilter").on('keyup',function () {
            searchFunc(this,"#well-grouplist > .panel",false);
          });
          $(".form-control:not(#navbar-search)").on("click focus keydown",function(){
            $(this).siblings().each(function(){
              if($(this).is(".form-control-feedback")){
                  $(this).remove();
              }
            });
            $(this).parent().parent().removeClass("has-error").removeClass("has-error").removeClass("has-warning").removeClass("has-success");
          });
          $(Panel.registration.personal.control[0]).click(function(){
            if(!DataManager.registration.action.step1()){
              $(this).attr('data-toggle',"");
            }
            else{
              $(this).attr('data-toggle',"collapse");
            }

          });
          $(BindDOM.registration.check).on("click",function(){
            if(DataManager.registration.state.data.email!=$(BindDOM.registration.email).val()){
              DataManager.registration.action.syncDF();
              DataManager.registration.action.autoLoadUser();
            }
          });
          $(BindDOM.registration.email).on("keyup",function(evnt){
            if(evnt.originalEvent.keyCode==13){
              if(DataManager.registration.state.data.email!=$(BindDOM.registration.email).val()){
                DataManager.registration.action.syncDF();
                DataManager.registration.action.autoLoadUser();
              }
            }
          });
          $(BindDOM.registration.advanced).click(function () {
            DataManager.global.findUser.action.setup({target:"REGIN"})
          });
          $(BindDOM.registration.advanced).click(function () {
            DataManager.global.findUser.action.setup({target:"REGIN"})
          });
          /*$(BindDOM.registration.email).on("blur",function(evnt){
            if(DataManager.registration.state.data.email!=$(BindDOM.registration.email).val()){
              DataManager.registration.action.syncDF();
              DataManager.registration.action.autoLoadUser();
            }
          });
          */
          $(Panel.registration.events.control[0]).click(function(){
            if(!DataManager.registration.action.step2()){
              $(this).attr('data-toggle',"");
            }
            else{
              $(this).attr('data-toggle',"collapse");
            }
          });
          $(Panel.registration.print.control[0]).click(function () {
            DataManager.registration.action.step3();
          });
          $(BindDOM.grouping.newTeam.event).on("change",function () {
            DataManager.grouping.newTeam.action.clear();
            DataManager.grouping.newTeam.action.syncDF();
            DataManager.grouping.newTeam.action.populate();
          });
          $(BindDOM.findUser.search.btn).on("click",function () {
              DataManager.global.findUser.action.search();
          });
          $(BindDOM.findUser.search.key).on("keyup",function (evnt) {
            if (evnt.originalEvent.keyCode===13) {
              DataManager.global.findUser.action.search();
            }
          });
          $(Panel.findUser.control[0]).on("click",function (evnt) {
              DataManager.global.findUser.action.fireOnTarget();
          });
          $(Panel.grouping.create.control[0]).on("click",function (evnt) {
              DataManager.grouping.newTeam.action.save(this);
          });
          $(BindDOM.lists.primary).on("change click",function () {
            DataManager.lists.action.populate();
          });
          $(BindDOM.lists.go).on("click",function () {
            DataManager.lists.action.syncDF();
            if (DataManager.lists.filter.primary !="" && DataManager.lists.filter.secondary!="") {
              DataManager.lists.action.fetch(DataManager.lists.action.setResult);
            }});

      }

      // call all event eventListeners
      eventListeners();






});


//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
