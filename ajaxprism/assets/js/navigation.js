DataManager.registration.action={
  jqXHR:null,
  //syncDataWithForm
  syncDF:function(){
    var controls=BindDOM.registration;
    var data=DataManager.registration.state.data;
    data.email=$(controls.email).val();
    data.name[0]=$(controls.name[0]).val();
    data.name[1]=$(controls.name[1]).val();
    data.phone=$(controls.phone).val();
    data.collegeID=$(controls.college).val();
    data.events=Array();
    $(controls.events.class, controls.events.parent).each(function () {
      if($(this).is(":checked")){
        data.events.push($(this).attr('eventID'));
      }
    });
    data.extra.acco=($(controls.extra.acco).is(':checked'))?true:false;
    data.extra.food=($(controls.extra.food).is(':checked'))?true:false;
    data.extra.gender=$(controls.extra.gender).val();
    DataManager.registration.state.flag.commit=true;
  },
  //syncFormWithData
   syncFD:function () {
    var controls=BindDOM.registration;
    var data=DataManager.registration.state.data;
    $(controls.email).val(data.email);
    $(controls.name[0]).val(data.name[0]);
    $(controls.name[1]).val(data.name[1]);
    $(controls.phone).val(data.phone);
    $(controls.college).val(data.collegeID);
    $(controls.events.class, controls.events.parent).prop("checked",false);
    for(i=0;i < data.events.length;i++){
      $( "[eventID=" + data.events[i] + "]",controls.events.parent).prop("checked",true);
    }
    $(controls.extra.acco).prop({"checked":data.extra.acco});
    $(controls.extra.food).prop({"checked":data.extra.food});
    $(controls.extra.gender).val(data.extra.gender);
  },
  //syncReportWithData
  syncRD:function(){
    var controls=BindDOM.registration.print;
    var data=DataManager.registration.state.data;
    $(controls.email).text(data.email);
    $(controls.name[0]).text(data.name[0]);
    $(controls.name[1]).text(data.name[1]);
    $(controls.phone).text(data.phone);
    $(controls.college).text(Static.colleges.content[data.collegeID][0]);
    var j=0,comma="";
    $(controls.events.parent).empty().append($("<li></li>").addClass('list-group-item'));
    for(i=0;i < data.events.length;i++){
      if(j!=0){
        comma=" | ";
      }
      $("li",controls.events.parent).text($("li",controls.events.parent).text() + comma  + Static.events.content[data.events[i]][0]);
      j++;
    }
    if(!j){
      $(controls.events.parent).text("Empty");
    }
    $(controls.extra.acco).text((data.extra.acco)?"Yes":"No");
    $(controls.extra.food).text((data.extra.food)?"Yes":"No");
    $(controls.extra.gender).text(data.extra.gender);

  },
  startup:function () {
    //Load college List
    var colOpt="";
    for (var college in Static.colleges.content) {
      if (Static.colleges.content.hasOwnProperty(college)) {
          colOpt+="\n<option value='"+ college +"'>"+ Static.colleges.content[college][0]+"</option>\n";
      }
    }
    if (colOpt!="") {
      //$(BindDOM.registration.college).empty();
      $(BindDOM.registration.college).html(colOpt);
    }
  },
  // allow passover to next step in satisfaction of the constraints
  step1:function(){
    this.syncDF();
    var data=DataManager.registration.state.data;
    var id=DataManager.registration.bindDOM;
    var status=true;
    if(!Check.email(data.email)){
      $(id.email).parent().parent().addClass('has-error');
      status=false;
    }
    if(!Check.name(data.name[0])){
      $(id.name[0]).parent().parent().addClass('has-error');
      status=false;
    }
    if(!Check.name(data.name[1])){
      $(id.name[1]).parent().parent().addClass('has-error');
      status=false;
    }
    if(data.collegeID==="COL"){
      $(id.college).parent().parent().addClass('has-error');
      status=false;
    }
    if(!Check.phone(data.phone)){
      $(id.phone).parent().parent().addClass('has-error');
      status=false;
    }
    if(status){
      DataManager.registration.state.flag.step=1;
      DataManager.registration.state.flag.commit=true;
      return true;
    }
    return false;
  },
  step2:function(){
    this.syncDF();
    var state=DataManager.registration.state;
    var panel=Panel.registration;
    if(state.flag.step>=1 && state.data.events.length>0){
      this.syncRD();
      $(".panel-footer > .status",panel.events.id).addClass('hidden');
      state.flag.step=2;
      if(!state.flag.commit){
        $(panel.print.control[0]).prop({disabled:true});
      }
      else{
        $(panel.print.control[0]).prop({disabled:false});
      }
      return true;
    }
    else{
      $(".panel-footer > .status",panel.events.id).removeClass('hidden');
      return false;
    }
  },
  step3:function(){
    var data=DataManager.registration.state.data;
    var url=DataManager.registration.url;
    var id=Panel.registration;
    this.syncDF();
    this.syncRD();
    var self=this;
    $(id.print.control[1]).prop({"disabled":true}).addClass('disabled  btn-primary');
    this.jqXHR=$.post(url.query,{action:(DataManager.registration.state.flag.fresh)?"NEW_ENTRY":"UPDATE_ENTRY",data:JSON.stringify(DataManager.registration.state.data)},function(result){
      /**
       * NOTE:unitTest
       */
       //result=unitTest.resultNew;

      if(typeof result === "object"){
        console.log("result",result);
        if(result.status==true){
          DataManager.registration.state.data=result.data;
          DataManager.registration.state.flag.fresh=false;
          //DataManager.registration.state.flag=result.flag;
          $(id.print.control[1]).text("Loading data...");
          $("#qr-image").attr({"src":"https://qrcode.online/img/?type=text&size=8&data="+DataManager.registration.state.data.userID+"&nod="+(Math.random()*1000)/1})
                          .on("load",function () {
                            $(id.print.control[1]).prop({"disabled":false}).removeClass('disabled  btn-danger').addClass('btn-success').text("Print ID Card");
                          }).
                          on("error",function () {
                            $(id.print.control[1]).text("Error occured").prop({"disabled":true}).addClass('disabled btn-danger');
                        });
          self.preparePrint();
          DataManager.global.history.action.push(result.data);
          $(id.print.control[1]).click(function () {
              $(BindDOM.registration.print.modal).modal();
          });
        }
        else {
          $(id.print.control[1]).text("Registration is Invalid").prop({"disabled":true}).addClass('disabled btn-danger');
          alert("An Error occured");
        }


      }

    });

  },
  preparePrint:function () {
      var data=DataManager.registration.state.data,i=0;
      b=[data.name[0]+" "+data.name[1]+"<br />"+Static.colleges.content[data.collegeID][0] ];
      $("table td",BindDOM.registration.print.modalPrint).each(function(){
        $(this).html(b[i]);
        i++;
      });
  },
  clear:function(){
    var controls=BindDOM.registration;
    var btn=Panel.registration;
    var data=DataManager.registration.state.data;
    data.email="";
    data.userID="";
    data.name[0]="";
    data.name[1]="";
    data.phone="";
    data.collegeID="COL";
    data.events=Array();
    data.extra.acco=false;
    data.extra.food=false;
    data.extra.gender=false;
    $('#spot-tab-events-form')[0].reset();
    $('#spot-tab-form-elem')[0].reset();
    DataManager.registration.state.flag.fresh=true;
    DataManager.registration.state.flag.step=0;
    DataManager.registration.state.flag.commit=false;
    $(btn.print.control[1]).text("Print ID Card").prop({"disabled":true}).removeClass('btn-danger btn-success').addClass('disabled btn-primary');
  },
  autoLoadUser:function(origin){
    var data=DataManager.registration.state.data;
    var controls=BindDOM.registration;
    var url=DataManager.registration.url;
    //get ajax object form server
    this.jqXHR=$.post(url.check,{action:"CHECK_ENTRY",data:JSON.stringify(data)},function(result){
      /**
       * NOTE:unitTest
       */
      //result=unitTest.result;

      if(typeof result === "object"){
        if ( result.status==true || result.flag!==null) {
          DataManager.registration.state.flag.fresh=result.flag.fresh;
          $(BindDOM.registration.email).parent().parent().removeClass("has-success has-warning");
          $(".form-control-feedback",$(BindDOM.registration.email).parent()).remove();
          if(result.flag.fresh==false){
            DataManager.registration.state.data=result.data;
            DataManager.registration.action.syncFD();
            $("<span></span>").addClass("glyphicon glyphicon-ok form-control-feedback").appendTo($(BindDOM.registration.email).parent());
            $(BindDOM.registration.email).parent().parent().addClass("has-success");

          }
          else{
            $("<span></span>").addClass("glyphicon glyphicon-warning-sign form-control-feedback").appendTo($(BindDOM.registration.email).parent());
            $(BindDOM.registration.email).parent().parent().addClass("has-warning");
          }
        }
        else {
        console.error("Error:",result);
        }

      }
    });


  }
};

DataManager.global.history.action={
  push :function(dataIn){
    var data=Object.assign({},dataIn);
    data['name']=Object.assign({},dataIn['name']);
    var res=true,index=-1;
    for (var i = 0; i < DataManager.global.history.length; i++) {
      if (DataManager.global.history[i].userID==data.userID) {
        index=i;
        res=false;
        break;
      }
    }
    if (res==true && data !=null) {
      DataManager.global.history.push(data);
    }
    else{
      var swap=DataManager.global.history[index];
      DataManager.global.history.splice(index,1);
      DataManager.global.history.unshift(swap);
      //console.log("swap:",swap,"all:",DataManager.global.history);
    }

  },
  pop:function () {
    return DataManager.global.history.pop();
  },
  shift:function () {
    return DataManager.global.history.shift();
  },
  getRecent:function () {
    return DataManager.global.history[DataManager.global.history[target].length-1];
  },
  getAll:function(){
    return DataManager.global.history;
  },
  getByUId:function(key){
    for (var i = 0; i < DataManager.global.history.length; i++) {
      if(DataManager.global.history[i].userID===key){
        return DataManager.global.history[i];
      }
    }
  }
};
DataManager.global.findUser.action={
  syncDF:function(){
      var ctrl=BindDOM.findUser;
      var data=DataManager.global.findUser;
      data.key=$(ctrl.search.key).val();
      data.filter=$(ctrl.search.filter).val();
  },
  setup:function(opts){
    if (typeof opts !== 'object') {
      return;
    }
    if(opts.target){
      DataManager.global.findUser.target=opts.target;
    }
    if(opts.initiator){
      DataManager.global.findUser.initiator=opts.initiator;
    }
    this.setHistory();
    $(Panel.findUser.control[0]).text("Proceed").removeClass("btn-danger");
    $(Panel.findUser.id).modal();

  },
  fetch:function (callback) {
      var ctrl=BindDOM.findUser;
      var data=DataManager.global.findUser;
    if(typeof callback !== 'function'){
      callback=function (r){};
    }
    var jqXHR=$.post(data.url.search,{action:"SEARCH",filter:data.filter,key:data.key},function(result){
      /**
       * NOTE:unitTest
       */
      //result=unitTest.search;

      if(result.status==true){
        callback.call(null,result);
        return true;
      }
      else{
        return false;
      }
    });

  },
  search:function(){
    var self=DataManager.global;
    this.syncDF();
    this.fetch(this.setResult);
  },
  setResult:function (result) {
    var self=DataManager.global.findUser.result;
    var id=BindDOM.findUser;
    self=result.result;
    var list="";
    if(self.length>0){
      DataManager.global.findUser.result=self;
      for (var i = 0; i < self.length; i++) {
        var name=self[i].name[0]+" "+self[i]. name[1];
        var college=Static.colleges.content[self[i].collegeID];
        var mail=self[i].email;
        var uId=self[i].userID;
        list+= "\n<li class=\"list-group-item\" userID=\""+ uId +"\"><b>"+name+"</b> | "+college+" | "+ mail +" </li>\n";
      }

    }
    else{
      list="<div class=\"well\">No Result Found</div>"
    }
    $(id.search.list).html(list);
    var listFinal=$('.list-group-item',id.search.list);

    $(".list-group-item",id.search.list).click(function () {

      $(listFinal).removeClass('active').children(".glyphicon").remove();
      $(this).addClass("active").append("<i class=\"glyphicon glyphicon-ok pull-right\"></i>");
      for (var i = 0; i < listFinal.length; i++) {
        if($(this).is(listFinal[i])){
          DataManager.global.findUser.method="SEARCH";
          DataManager.global.findUser.action.setIndex(i);
          break;
        }
      }

    });

    return true;
  },
  setHistory:function () {

    var id=BindDOM.findUser;
    self=DataManager.global.history;
    var list="";
    if(self.length>0){
      for (var i = 0; i < self.length; i++) {
        var name=self[i].name[0]+" "+self[i]. name[1];
        var college=Static.colleges.content[self[i].collegeID];
        var mail=self[i].email;
        var uId=self[i].userID;
        list+= "\n<li class=\"list-group-item\" userID=\""+ uId +"\"><b>"+name+"</b> | "+college+" | "+ mail +" </li>\n";
      }

    }
    else{
      list="<div class=\"well\">Nothing found! Once you have added few users you'll get to use it</div>"
    }
    $(id.history.list).html(list);
    var listFinal=$('.list-group-item',id.history.list);
    $(".list-group-item",id.history.list).click(function () {

      $(listFinal).removeClass('active').children(".glyphicon").remove();
      $(this).addClass("active").append("<i class=\"glyphicon glyphicon-ok pull-right\"></i>");
      for (var i = 0; i < listFinal.length; i++) {
        if($(this).is(listFinal[i])){
          DataManager.global.findUser.method="HISTORY";
          DataManager.global.findUser.action.setIndex(i);
          break;
        }
      }

    });

    return true;

  },
  setIndex:function (index) {
    DataManager.global.findUser.activeIndex=index;
  },
  fireOnTarget:function (target) {
    var tgData=null;

    if (target==undefined || target== null) {
      target=DataManager.global.findUser.target;
    }
    if(DataManager.global.findUser.method=="SEARCH"){
      tgData=DataManager.global.findUser.result[DataManager.global.findUser.activeIndex];
    }
    else{
      tgData=DataManager.global.history[DataManager.global.findUser.activeIndex];
    }
    var stat=true;
    switch (target) {
      case "REGIN":
        DataManager.registration.state.data=tgData;
        DataManager.registration.state.flag.fresh=false;
        DataManager.registration.action.syncFD();
        break;
      case "NEW_GROUP":

        if (!DataManager.grouping.newTeam.action.fireOnTarget(tgData,DataManager.global.findUser.initiator)) {
          stat=false;
        }
        break;
      default:console.warn("Exception: No  target specified");
    }
    if(stat){
      $(Panel.findUser.id).modal("hide");
      DataManager.global.history.action.push(tgData);
    }

  },
  pushToHistory:function(target,data){
    DataManager.global.history.push(target,data);
  }
};

DataManager.grouping.newTeam.action={
  syncDF:function () {
    DataManager.grouping.newTeam.state.data.eventID=$(BindDOM.grouping.newTeam.event).val();
  },
  syncData:function (data) {
    if(typeof data !== "object"){
      return;
    }
    DataManager.grouping.newTeam.state.data=data;
  },
  populate:function () {
    var colList="<tbody><tr><th>SL NO.</th><th>Name</th><th>College Name</th><th>Action</th></tr>";
    var data=DataManager.grouping.newTeam.state.data;
    for (var i = 0; i < Static.events.content[data.eventID][2]; i++) {
      colList+="\n<tr><th>"+(i+1)+"</th><td>Empty&nbsp;&nbsp;<span class=\"label label-primary\">none selected</span></td><td>Empty&nbsp;&nbsp;<span class=\"label label-primary\">none selected</span></td><td><button type=\"button\" class=\"btn btn-xs btn-primary\">&nbsp;<i class=\" glyphicon glyphicon-search\"></i>&nbsp;</button></td></tr>\n";
    }
    colList+="</tbody>";
    $(BindDOM.grouping.newTeam.table).html(colList);
    $(".btn",BindDOM.grouping.newTeam.table).off("click").click(function () {
      DataManager.global.findUser.action.setup({target:"NEW_GROUP",initiator:$(this).parent().parent()});
    });
  },
  releaseTarget:function (obj) {

    var data=$(obj).attr("userID");
    for (var i = 0; i < DataManager.grouping.newTeam.state.data.selection.length; i++) {
      if(DataManager.grouping.newTeam.state.data.selection[i]===data){
        DataManager.grouping.newTeam.state.data.selection.splice(i,1);
        $("td:eq(0)",obj).html("Empty&nbsp;&nbsp;").append($("<span class=\"label label-primary\">none selected</span>"));
        $("td:eq(1)",obj).html("Empty&nbsp;&nbsp;").append($("<span class=\"label label-primary\">none selected</span>"));
        $("td:eq(2) > .btn",obj).removeClass('btn-danger').addClass('btn-primary').children('i').removeClass('glyphicon-remove').addClass('glyphicon-search');

      }
    }

  },
  fireOnTarget:function(data,targetItem){
    if (typeof targetItem !== 'object' || typeof data !== "object") {
      return;
    }
    var dataIn=DataManager.grouping.newTeam.state.data;
    if (data.eventID!=="" && (dataIn.selection.length < Static.events.content[dataIn.eventID][2])) {
      var res=true;
      for (var i = 0; i < dataIn.selection.length; i++) {
        if(dataIn.selection[i]===data.userID){
          res=false;break;
        }
      }
      if (res) {
        DataManager.grouping.newTeam.state.data.selection.push(data.userID);
        $(targetItem).attr({"userID":data.userID});
        $("td:eq(0)",targetItem).text(data.name[0]+" "+data.name[1]);
        $("td:eq(1)",targetItem).text(Static.colleges.content[data.collegeID][0]);
        $("td:eq(2) > .btn",targetItem).removeClass('btn-primary').addClass('btn-danger').children('i').removeClass('glyphicon-search').addClass('glyphicon-remove');
        $("td:eq(2) > .btn",targetItem).off("click").click(function () {
          DataManager.grouping.newTeam.action.releaseTarget($(targetItem));
          $(this).off("click").click(function () {
            DataManager.global.findUser.action.setup({target:"NEW_GROUP",initiator:$(this).parent().parent()});
          });
        });
        return true;
      }
      else {
        $(Panel.findUser.control[0]).text("Redundant Data").addClass("btn-danger");
        return false;
      }
    }
    else {
      console.error("Illegal Condition!");
      return false;
    }
  },
  clear:function () {
    DataManager.grouping.newTeam.state.data.eventID="";
    DataManager.grouping.newTeam.state.data.selection=Array();
  },
  save:function(){
    var dataG=DataManager.grouping,self=this;
    if(dataG.newTeam.state.data.eventID==="" || dataG.newTeam.state.data.selection.length<1){
      $(Panel.grouping.create.control[0]).removeClass('btn-primary').addClass('btn-danger').text("Error");
      return;
    }
    else{
      var jqXHR=$.post(dataG.url.query,{action:"NEW_GROUP",data:JSON.stringify(dataG.newTeam.state.data)},function(result){
       

        if(result.status==true){
          //handle the Response
          self.clear();
          $("tr:not(0)",BindDOM.grouping.newTeam.table).remove();
          $(BindDOM.grouping.newTeam.table).append($("<div class=\"alert alert-success\">Group Created</div>"));
          $(Panel.grouping.create.control[0]).removeClass('btn-danger').addClass('btn-success').text("Ok");
          return true;
        }
        else{
          alert("Error: GROUP NOT CREATED");
          return false;
        }
      });
    }
  }


};
DataManager.lists.action={
  syncDF:function () {
    DataManager.lists.filter.primary=$(BindDOM.lists.primary).val();
    DataManager.lists.filter.secondary=$(BindDOM.lists.secondary).val();
  },
  fetch:function (callback) {
      var ctrl=BindDOM.lists;
      var data=DataManager.lists;
    if(typeof callback !== 'function'){
      callback=function (r){};
    }
    console.log("data:",data);
    var jqXHR=$.post(data.url.query ,{action:"LISTS",filter:{primary:data.filter.primary,secondary:data.filter.secondary}},function(result){
      /**
       * NOTE:unitTest
       */
      //result=unitTest.lists;

      if(result.status==true){
        callback.call(null,result);
        return true;
      }
      else{
        return false;
      }
    });
  },
  populate:function () {
    this.syncDF();
    var colOpt="";
    switch (DataManager.lists.filter.primary) {
      case "BYCOL":
      for (var college in Static.colleges.content) {
        if (Static.colleges.content.hasOwnProperty(college)) {
            colOpt+="\n<option value='"+ college +"'>"+ Static.colleges.content[college][0]+"</option>\n";
        }
      }
        break;
      case "BYEVENT":
      case "BYRESULTS":
      case "BYTEAMS":
      
      case "BYDONE":
      colOpt="<option value=\"\" selected>--Select Event--</option>";
      for (var event in Static.events.content) {
        if (Static.events.content.hasOwnProperty(event)) {
            colOpt+="\n<option value='"+ event +"'>"+ Static.events.content[event][0]+"</option>\n";
        }
      }
        break;
      case "BYACCO":
        colOpt="<option value=\"acco\" selected>--Select Filter--</option>";
        break;
      case "BYFOOD":
        colOpt="<option value=\"food\" selected>--Select Filter--</option>";
        break;
	case "BYALL":
        colOpt="<option value=\"food\" selected>--Select Filter--</option>";
        break;

      case "BYGENDER":
        colOpt="<option value=\"\" selected>--Select Filter--</option>";
        colOpt+="<option value=\"M\">Male</option>";
        colOpt+="<option value=\"F\">Female</option>";
        break;
      default:
      colOpt="<option value=\"\" selected>--Select Filter--</option>";
    }
    if (colOpt!="") {
      $(BindDOM.lists.secondary).html(colOpt);
    }
  },
  setResult:function (res) {
    $(BindDOM.lists.result).html(res.data);
    if(DataManager.lists.filter.primary!=='BYRESULTS' && DataManager.lists.filter.primary!=='BYTEAMS'){
      $(BindDOM.lists.table).dataTable();
    }
    $(Panel.lists.control[0]).click(function () {

      var header="";
      if(DataManager.lists.filter.primary=='BYCOL'){
        header="College:"+Static.colleges.content[DataManager.lists.filter.secondary][0];
      }
      else if (DataManager.lists.filter.primary=='BYEVENT') {
        header="Event:"+Static.events.content[DataManager.lists.filter.secondary][0];
      }
      else if (DataManager.lists.filter.primary=='BYTEAMS') {
        header="Teams:"+Static.events.content[DataManager.lists.filter.secondary][0];
      }
      else if (DataManager.lists.filter.primary=='BYRESULTS') {
        header="Final result of "+Static.events.content[DataManager.lists.filter.secondary][0];
      }
      printJS({printable:'tab-lists-table-tab',type:'html',header:header})
    });
  }
};
var Check={
  regMail:"^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\\.([a-zA-Z]{2,4})$",
  regName:"^[a-zA-Z ]{1,40}$",
  regPhone:"^[0-9]{10}$",
  regPass:"^[A-Za-z0-9!@#$%^&*()_]{6,20}$",
  regExp:function(ptn,str){
    Exp=new RegExp(ptn);
    if (Exp.test(str)) {
      return true;
    }
    return false;
  },
  email:function (email) {
    if (this.regExp(this.regMail,email)) {
      return true;

    }
    return false;
  },
  name:function (uName) {
    if (this.regExp(this.regName,uName)) {
      return true;

    }
    return false;
  },
  phone:function (uPhone) {
    if (this.regExp(this.regPhone,uPhone)) {
      return true;

    }
    return false;
  }
};
