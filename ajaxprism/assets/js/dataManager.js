//global data manager
var DataManager=null;
var BindDOM=null;
var Panel=null;
(function(){

Panel={
  registration:{
    id:"#spot-panel-group",
    personal:{
      id:"#spot-tab-form",
      control:[
        "#spot-tab-form-next"
      ]
    },
    events:{
      id:"#spot-tab-events",
      control:[
        "#spot-tab-events-next"
      ]
    },
    print:{
      id:"#spot-tab-print",
      control:[
        "#spot-tab-print-save",
        "#spot-tab-print-print"
      ]
    }
  },
  grouping:{
    id:"#group-panel-group",
    create:{
      id:"#group-tab-create",
      control:[
        "#group-tab-create-btn"
      ]
    },
    edit:{
      id:"#group-tab-edit",
      control:[
        "#group-tab-edit-evntbtn",

      ]
    }
  },
  lists:{
    id:"#tab-lists",
    control:["#tab-lists-print"]
  },
  findUser:{
    id:"#findUserModal",
    search:{
      id:"#findUserModal-search"
    },
    history:{
      id:"#findUserModal-history"
    },
    control:["#findUserModal-proceed"]
  }
}
BindDOM={
  registration:{
    email:Panel.registration.personal.id + "-email",
    check:Panel.registration.personal.id + "-check",
    advanced:Panel.registration.personal.id + "-advanced",
    name:[
          Panel.registration.personal.id + "-fname",
          Panel.registration.personal.id + "-lname"
    ],
    college:Panel.registration.personal.id + "-college",
    phone:Panel.registration.personal.id + "-phone",
    extra:{
      gender:Panel.registration.personal.id + "-extra-gender",
      acco:Panel.registration.personal.id + "-extra-acco",
      food:Panel.registration.personal.id + "-extra-food",
    },
    events:{
      table:Panel.registration.events.id+"-table",
      class:"[type=checkbox]",
      parent:Panel.registration.events.id
    },
    print:{
      email:Panel.registration.print.id + "-email",
      name:[
            Panel.registration.print.id + "-fname",
            Panel.registration.print.id + "-lname"
      ],
      college:Panel.registration.print.id + "-college",
      phone:Panel.registration.print.id + "-phone",
      extra:{
        gender:Panel.registration.print.id + "-extra-gender",
        acco:Panel.registration.print.id + "-extra-acco",
        food:Panel.registration.print.id + "-extra-food",
      },
      events:{
        class:"li",
        parent:Panel.registration.print.id+"-eventlist"
      },
      modal:"#printModal",
      modalPrint:"#printable"
    }
  },
  grouping:{
    newTeam:{
      event:Panel.grouping.create.id+"-eventlist",
      table:Panel.grouping.create.id+"-table"
    },
    editTeam:{


    }
  },
  lists:{
    form:Panel.lists.id+"-form",
    primary:Panel.lists.id+"-filter-primary",
    secondary:Panel.lists.id+"-filter-secondary",
    result:Panel.lists.id+"-result",
    table:Panel.lists.id+"-table-tab",
    go:Panel.lists.id+"-go"
  },
  findUser:{
    search:{
      filter:Panel.findUser.search.id+"-filter",
      key:Panel.findUser.search.id+"-key",
      btn:Panel.findUser.search.id+"-btn",
      list:Panel.findUser.search.id+"-list"
    },
    history:{
      refresh:Panel.findUser.history.id,
      list:Panel.findUser.history.id+"-list"
    }

  }
}
DataManager={
  registration:{
    id:"#tab-registration",
    state:{
      data:{
        userID:"",
        name:["",""],
        email:"",
        collegeID:"COL",
        phone:"",
        events:[],
        extra:{
          acco:false,
          food:false,
          gender:"",
        }
      },
      flag:{
        fresh:true,
        step:0,
        commit:false
      }
    },
    url:{
      query:"http://localhost/asthra/ajaxprism/ref/adv/action.php",
      check:"http://localhost/asthra/ajaxprism/ref/adv/action.php"
    },
    bindDOM:BindDOM.registration,
    panel:Panel.registration

  },
  grouping:{
    id:"#tab-group-user",
    newTeam:{
      state:{
        data:{
          eventID:"",
          selection:[]
        },
        flag:{
          selected:false
        }
      }
    },
    url:{
      query:"http://localhost/asthra/ajaxprism/ref/adv/action.php"
    }
  },
  lists:{
    filter:{
      primary:"",
      secondary:""
    },
    url:{
      query:"http://localhost/asthra/ajaxprism/ref/adv/find.php"
    }


  },
  static:Static

};
DataManager.global={
  history:[],
  findUser:{
    key:"",
    filter:"FIL",
    result:[],
    activeIndex:-1,
    initiator:null,
    method:"SEARCH",
    target:"REGIN",
    url:{
      search:"http://localhost/asthra/ajaxprism/ref/adv/find.php"
    }
  }
}

})();
