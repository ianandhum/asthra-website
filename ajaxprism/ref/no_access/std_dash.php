<?php
if(!defined('STD_DASH')){
	exit;
}
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title>Asthra 2k18</title>
      <link href="assets/vendor/bootstrap/css/bootstrap.flatly.min.css" rel="stylesheet" />
      <link href="assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet" />
      <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet" />
      <link href="assets/css/loaderStyle.css" rel="stylesheet" />
      <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="assets/vendor/printjs/css/print.min.css" rel="stylesheet" />
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div id="cover" style="padding:100px;text-align:center;color:#fff;font-size:20px;"><b>Loading...</b></div>
      <div id="wrapper">

         <!-- Navigation -->
         <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0;background:#f8f8f8">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="index.html" style="color:#333">ASTHRA 2K18</a>
            </div>

            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <!-- /.dropdown -->
               <li class="dropdown">
                  <a data-toggle="dropdown" href="#">
                  <i class="fa fa-gear fa-" style="font-size:1.3em"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                     <li id="dropdown-fullscreen"><a href="#"><i class="glyphicon glyphicon-resize-full fa-fw"></i>Fullscreen</a>
                     </li>
                     
                     <li class="divider"></li>
                     <li><a href="ref/std/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                     </li>
                  </ul>
                  <!-- /.dropdown-user -->
               </li>
               <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation" style="background-color:#f8f8f8">
               <div class="sidebar-nav navbar-collapse">
                  <ul class="nav nav-tabs nav-stacked" id="side-menu">
                     <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                           <input type="text" class="form-control" id="navbar-search" placeholder="Search..." />
                           <span class="input-group-btn" onclick="$('#navbar-search').val('');searchFunc($('#navbar-search'),'#side-menu > li:not(.sidebar-search)');">
                           <button class="btn btn-default" type="button">
                           <i class="fa fa-search"></i>
                           </button>
                           </span>
                        </div>
                     </li>
		     <li class="active">
                        <a  id="link-home"  data-toggle="tab" href="#tab-dashboard" data-parent="#page-wrapper" keywords="status messages" ><i class="fa fa-home fa-fw"></i><span>Home</span></a>
                     </li>
                     <li>
                        <a id="link-registration" data-toggle="tab" href="#tab-registration" data-parent="#page-wrapper"  keywords="new add"><i class="fa fa-edit fa-fw"></i><span>Registration</span></a>
                     </li>
                     <li>
                        <a id="link-group-user" data-toggle="tab" href="#tab-group-user" data-parent="#page-wrapper" keywords="team events"><i class="fa fa-sitemap fa-fw"></i><span>Teams</span></a>
                     </li>
                     <li>
                        <a id="link-lists" data-toggle="tab" href="#tab-lists" data-parent="#page-wrapper" keywords="show all"><i class="fa fa-list fa-fw"></i><span>Lists</span></a>
                     </li>

                  </ul>
               </div>
               <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            <div class="progress top-progress">
              <div class="progress-bar progress-bar-primary top-progress-bar"  id="ajax-progress"></div>
            </div>
         </nav>
         <!-- Page Content -->
         <div id="page-wrapper" class="tab-content">
	    <div class="container-fluid tab-pane fade in active" id="tab-dashboard">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="jumbotron">
				<h1>Home</h1>
				<p>Welcome to the spot registration panel for ASTHRA 2K18</p>
		     </div>
                     <div class="alert alert-info"><b>use the gear icon to switch to fullscreen</b></div>
                     <div class="alert alert-info"><b>Having Trouble? </b>Contact admin,Anandhu Manoj,ph:9207219425</div>
                     
                  </div>

               </div>

            </div>
            <div class="container-fluid tab-pane" id="tab-registration">
               <div class="row">
                  <div class="col-lg-12">
                     <h1 class="page-header">Registration</h1>
                     <div class="panel-group" id="spot-panel-group">
                        <div class="panel panel-primary">
                           <div class="panel-heading">
                              <h5 class="panel-title">Personal Details</h5>
                           </div>
                           <div class="panel-collapse collapse in" id="spot-tab-form">
                              <div class="panel-body">
                                 <form class="form-horizontal" id="spot-tab-form-elem">
                                    <div class=" well well-sm " style="padding-bottom:3px;">
                                       <div class="form-group has-feedback">
                                          <label class="control-label col-sm-3" for="spot-tab-form-email">Check E-mail address</label>
                                          <div class="col-sm-6"  data-toggle="tooltip" title="if mail address is already registered, other fields will be autofilled">
                                             <input type="text" class="form-control" id="spot-tab-form-email" placeholder="enter email address" >
                                          </div>
                                          <div class="col-sm-3">
                                            <div class="btn-group pull-right">
                                              <button class="btn btn-primary" type="button" id="spot-tab-form-check"><i class="glyphicon glyphicon-ok"></i></button>
                                              <button class="btn btn-default" type="button" id="spot-tab-form-advanced">Advanced</button>
                                            </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="well">
                                       <div class="form-group">
                                          <label class="control-label col-sm-3" for="spot-tab-form-fname">Name</label>
                                          <div class="col-sm-9 input-group">
                                             <div class="col-sm-6"><input type="text" class="form-control" id="spot-tab-form-fname" placeholder="First Name"></div>
                                             <div class="col-sm-6"><input type="text" class="form-control" id="spot-tab-form-lname" placeholder="Last Name"></div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="control-label col-sm-3" for="spot-tab-form-college">College</label>
                                          <div class="col-sm-9">
                                             <select class="form-control" id="spot-tab-form-college">
                                                <option value="COL" selected="selected">--select college--</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="control-label col-sm-3" for="spot-tab-form-phone">Phone Number</label>
                                          <div class="col-sm-9">
                                             <input type="text" class="form-control" id="spot-tab-form-phone" placeholder="enter phone number">
                                          </div>
                                       </div>
                                    </div>
                                    <h4 style="font-size:15px;font-weight:bold;padding:15px 5px;">Additional Details</h4>
                                    <div class="well well-sm">
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="spot-tab-form-extra-gender">Gender</label>
                                        <div class="col-sm-2">
                                           <select class="form-control" id="spot-tab-form-extra-gender">
                                              <option value="M" selected="selected">Male</option>
                                              <option value="F">Female</option>
                                           </select>
                                        </div>
                                        <label class="control-label col-sm-3" for="spot-tab-form-extra-acco" style="padding:15px initial ">Accomodation</label>
                                        <div class="col-sm-1">
                                          <input type="checkbox" class="form-control" id="spot-tab-form-extra-acco" style="margin:12px;">
                                        </div>
                                        <label class="control-label col-sm-3" for="spot-tab-form-extra-food">Food</label>
                                        <div class="col-sm-1">
                                          <input type="checkbox" class="form-control" id="spot-tab-form-extra-food" style="margin:12px;">
                                        </div>
                                      </div>
                                    </div>
                                 </form>
                              </div>
                              <div class="panel-footer text-right">
                                 <button type="reset" onclick="$('#spot-tab-form-elem')[0].reset()"  class="btn btn-md btn-default pull-left">Clear</button>
                                 <button id="spot-tab-form-next" class="btn btn-md btn-primary right" data-toggle="collapse" data-parent="#spot-panel-group" data-target="#spot-tab-events">Next</button>

                              </div>
                           </div>
                        </div>
                        <div  class="panel panel-primary">
                           <div class="panel-heading">
                              <h5 class="panel-title" >
                                 Select Events
                              </h5>
                           </div>
                           <div class="panel-collapse collapse" id="spot-tab-events">
                              <div class="panel-body">
                                 <form class="form-horizontal" id="spot-tab-events-form">
                                    <div class="well well-sm">
                                       <b>Select events from the following list</b>
                                    </div>
                                    <div>
                                       <table class="table table-striped table-hover" id="spot-tab-events-table">
                                          <tr class="default">
                                             <th>Events</th>
                                             <th>Description</th>
                                             <th>Team strength</th>
                                             <th>Select</th>
                                          </tr>
                                          <tr>
                                             <td>BAKER STREET</td>
                                             <td>The Treasure Hunt</td>
                                             <td>5</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;" eventID="EVNT01" /></td>
                                          </tr>
                                          <tr>
                                             <td>CRYP-TRICKS</td>
                                             <td>Coding and debugging</td>
                                             <td>2</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT07" /></td>
                                          </tr>
                                          <tr>
                                             <td>DIGISTHRA</td>
                                             <td>Promo Video contest</td>
                                             <td>1</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT08" /></td>
                                          </tr>
                                          <tr>
                                             <td>ILLUMINATI</td>
                                             <td>Secret event</td>
                                             <td>1</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT02" /></td>
                                          </tr>
                                          <tr>
                                             <td>KALSOPIA</td>
                                             <td>Photography Contest</td>
                                             <td>1</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT04" /></td>
                                          </tr>
                                          <tr>
                                             <td>SANS-LEXICO</td>
                                             <td>Word Hunt</td>
                                             <td>2</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT03" /></td>
                                          </tr>
                                          <tr>
                                             <td>TECHNOCRATI</td>
                                             <td>IT Quiz</td>
                                             <td>2</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT05" /></td>
                                          </tr>
                                          <tr>
                                             <td>VELO-C-DAD</td>
                                             <td>Network/LAN gaming</td>
                                             <td>1</td>
                                             <td><input type="checkbox" class="form-control" style="width:40px;"  eventID="EVNT06" /></td>
                                          </tr>
                                       </table>
                                    </div>
                                 </form>
                              </div>
                              <div class="panel-footer text-right">
                                 <button type="reset" onclick="$('#spot-tab-events-form')[0].reset()"  class="btn btn-md btn-default pull-left">Clear</button>
                                 <span class="status pull-left hidden label label-danger" style="margin:10px;font-size:15px;">Select an event from the list </span>
                                 <button class="btn btn-md btn-primary right" data-toggle="collapse" data-parent="#spot-panel-group" data-target="#spot-tab-form">Back</button>
                                 <button id="spot-tab-events-next" class="btn btn-md btn-primary right" data-toggle="collapse" data-parent="#spot-panel-group" data-target="#spot-tab-print">Next</button>
                              </div>
                           </div>
                        </div>
                        <div  class="panel panel-primary">
                           <div class="panel-heading">
                              <h5 class="panel-title" >
                                 Confirm
                              </h5>
                           </div>
                           <div class="panel-collapse collapse" id="spot-tab-print">
                              <div class="panel-body">
                                 <div class="well">
                                    <b>Verify the details again</b>
                                 </div>
                                 <table class="table table-striped">
                                    <tr>
                                       <th>First Name</th>
                                       <td id="spot-tab-print-fname">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Last Name</th>
                                       <td id="spot-tab-print-lname">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Gender</th>
                                       <td id="spot-tab-print-extra-gender">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>College</th>
                                       <td id="spot-tab-print-college">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>E-mail</th>
                                       <td id="spot-tab-print-email">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Phone Number</th>
                                       <td id="spot-tab-print-phone">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Accomodation</th>
                                       <td id="spot-tab-print-extra-acco">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Food</th>
                                       <td id="spot-tab-print-extra-food">Empty</td>
                                    </tr>
                                    <tr>
                                       <th>Events</th>
                                       <td>
                                          <ul class="list-group" id="spot-tab-print-eventlist">
                                            Empty
                                          </ul>
                                       </td>
                                    </tr>
                                 </table>
                              </div>

                              <div class="panel-footer text-right">
                                 <button class="btn btn-md btn-danger right pull-left" onclick="DataManager.registration.action.clear()" data-toggle="collapse" data-parent="#spot-panel-group" data-target="#spot-tab-form">Clear all</button>
                                 <button class="btn btn-md btn-primary right"  data-toggle="collapse" data-parent="#spot-panel-group" data-target="#spot-tab-events">Back</button>
                                 <button class="btn btn-md btn-primary right" id="spot-tab-print-save">Save</button>
                                 <button class="btn btn-md btn-primary disabled"  id="spot-tab-print-print">Print Id Card</button>
                              </div>
                           </div>
                        </div>
                        <div id="printModal" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Print Preview</h4>
                                 </div>
                                 <div class="modal-body" style="text-align:center;">
                                    <div class="well" id="printable" style="width:250px;margin:0 auto;border:2px solid #123456;padding:5px;">
                                       <table class="table">

                      
                                          <tr>
                                            <th colspan="2">
                                              <div class="text-center">
                                                 <img id="qr-image" src="assets/img/download.png" height="80" width="80"/>
                                              </div>
                                            </th>
                                          </tr>
                                          <tr>
                                             <th>NAME</th>
                                             <td class="text-left">None</td>
                                          </tr>
                                       </table>

                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="printJS('printable','html')">Print</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
            </div>
            <div class="container-fluid tab-pane fade" id="tab-group-user">
               <div class="row">
                  <div class="col-lg-12">
                     <h1 class="page-header">Teams</h1>
                     <div class="panel panel-primary" id="group-panel-group">
                        <div class="panel-heading"  style="padding:0px;padding-left:30px;">
                           <ul class="nav nav-tabs nav-abs-dark text-center" style="border-width:0px;">
                              <li class="active"><a href="#group-tab-create" data-toggle="tab"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Create New Team</a></li>
                              <!--<li><a href="#group-tab-edit"  data-toggle="tab"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Edit Team</a></li>-->
                           </ul>
                        </div>
                        <div class="panel-body">
                           <div class="tab-content">
                              <div id="group-tab-create" class="tab-pane fade in active">
                                 <form class="form-horizontal">

                                    <div class="panel panel-primary" style="border-top-width:1px;border-color:#abcedf">

                                       <div class="panel-body">
                                         <div class="well well-sm">
                                            <div class="form-group">
                                               <label class="control-label col-sm-3" for="group-tab-create-eventlist">Select an event form the list</label>
                                               <div class="col-sm-9">
                                                  <select id="group-tab-create-eventlist" class="form-control">
                                                     <option value="" selected="selected">--Select Event--</option>
                                                    <option value="EVNT01">BAKER STREET--Treasure hunt</option>
                                                     <option value="EVNT07">CRYP-TRICKS--coding and debugging</option>
                                                     <option value="EVNT08">DIGISTHRA--promo video</option>
                                                     <option value="EVNT02">ILLUMINATI--secret event</option>
                                                     <option value="EVNT04">KALSOPIA--photography</option>
                                                     <option value="EVNT03">SANS-LEXICO--word hunt</option>
                                                     <option value="EVNT05">TECHNOCRATI--IT Quiz</option>
                                                     <option value="EVNT06">VELO-C-DAD--network gaming</option>
                                                  </select>
                                               </div>
                                            </div>
                                         </div>
                                          <table class="table table-hover table-striped" id="group-tab-create-table">
                                             <tbody>
                                                <tr>
                                                   <th>SL NO.</th>
                                                   <th>Name</th>
                                                   <th>College Name</th>
                                                   <th>Action</th>
                                                </tr>


                                                </tbody>
                                          </table>

                                       </div>
                                       <div class="panel-footer text-right" >
                                          <button class="btn  btn-primary" id="group-tab-create-btn">save</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>

                           </div>
                        </div>

                     </div>
                  </div>
                  <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
            </div>
            <div class="container-fluid tab-pane fade" id="tab-lists">
                     <h1 class="page-header">Lists</h1>
                     <div class="panel panel-primary">
                        <div class="panel-heading">View table data</div>
                        <div class="panel-body">
                          <form class="form-horizontal" id="tab-lists-form">
                            <div class="well">
                              <div class="form-group">
                                <div class="col-lg-3">
                                  <label for="" class="pull-right" style="padding:12px;">select filters</label>
                                </div>
                                <div class="col-lg-4">
                                  <select id="tab-lists-filter-primary" class="form-control">
                                    <option value="" selected="selected">--Select filter--</option>
                                    <option value="BYCOL">Students from college</option>
                                    <option value="BYALL">ALL STUDENTS</option>
                                    <option value="BYEVENT">Students registered for event</option>
                                    <option value="BYRESULTS">final result of the event</option>
                                    <option value="BYTEAMS">list of teams participating for </option>
                                    <option value="BYACCO">list of students Requested Accomodation </option>
                                    <option value="BYFOOD">list of students requested food</option>
                                    <option value="BYGENDER">list of students sorted by gender</option>
                                    <option value="BYDONE">list of students participated</option>

                                  </select>
                                </div>
                                <div class="col-lg-3">
                                  <select id="tab-lists-filter-secondary" class="form-control">
                                    <option value="" selected="selected">--Select filter--</option>

                                  </select>
                                </div>
                                <div class="col-lg-2">
                                  <button type="button" class="btn btn-primary pull-right" id="tab-lists-go">GO</button>
                                </div>

                              </div>
                            </div>

                          </form>
                          <div class="well" id="tab-lists-result" style="background-color:#fcfcfc">Results will appear here</div>
                        </div>
                        <div class="panel-footer text-right">
                          <button class="btn btn-primary" id="tab-lists-print">Print</button>
                        </div>

                     </div>

               <!-- /.row -->
            </div>
            <div class="container-fluid tab-pane fade" id="tab-account">
               <div class="row">
                  <div class="col-lg-12">
                     <h1 class="page-header">Blank6</h1>
                     <div class="panel panel-primary">
                        <div class="panel-heading">Spot User</div>
                        <div class="panel-body">dkddkkd</div>
                        <div class="panel-footer">fo sks</div>
                     </div>
                  </div>
                  <!-- /.col-lg-12 -->
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>
         <!-- /#page-wrapper -->
         <!--modal -->
         <!-- This modal will be used for every necessary actions -->
         <div id="findUserModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Advanced Search</h4>
                  </div>
                  <div class="modal-body">
                    <ul class="nav nav-tabs">
                       <li class="active"><a href="#findUserModal-search" data-toggle="tab">Search</a></li>
                       <li><a href="#findUserModal-history"  data-toggle="tab">History</a></li>
                    </ul>
                    <div class="tab-content" style="height:320px;padding:10px 3px">
                      <div id="findUserModal-search" class="tab-pane fade in active">
                        <div class="well well-sm">
                          <form class="form-horizontal">
                            <div class="form-group has-feedback">
                              <div class="col-lg-5">
                                <select class="form-control" id="findUserModal-search-filter">
                                   <option value="FIL" selected="selected">Select filter</option>
                                   <option value="FILNAME">By Name</option>
                                   <option value="FILMAIL">By E-mail</option>
                                   <option value="FILPHNO">By Phone number</option>
                                </select>
                              </div>
                              <div class="col-lg-6">
                                <input type="text" id="findUserModal-search-key" class="form-control" placeholder="Search...." >
                              </div>
                              <div class="col-lg-1 pull-right">
                                <button class="btn btn-primary pull-right" id="findUserModal-search-btn" type="button" ><i class="glyphicon glyphicon-search"></i></button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="outline" style="height:200px;">
                          <ul class="list-group" id="findUserModal-search-list">
                              <div class="well well-sm">Select a filter and enter search keyword...</div>
                            </ul>
                        </div>
                      </div>
                      <div id="findUserModal-history" class="tab-pane fade">
                        <div class="outline" style="height:300px;">
                          <ul class="list-group" id="findUserModal-history-list">

                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" id="findUserModal-proceed">Proceed</button>

                  </div>
               </div>
            </div>
         </div>
         <!--end-modal-->
      </div>
      <!-- /#wrapper -->
      <script src="assets/vendor/jquery/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
      <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
      <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>
      <script src="assets/vendor/printjs/js/print.min.js"></script>
      <script src="assets/js/StaticData.php"></script>
      <script src="assets/js/dataManager.js"></script>
      <script src="assets/js/navigation.js"></script>
      <script src="assets/js/loaderScript.js"></script>
   </body>
</html>
