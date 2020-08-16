<!DOCTYPE html>
<html>
<head>
  <title>Appointment</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!--stye-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

<!--js-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js" integrity="sha256-2JRzNxMJiS0aHOJjG+liqsEOuBb6++9cY4dSOyiijX4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

<!--navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="col-xs-9">
    </div>
    <div class="col-xs-3">
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
            Create Appointments
        </button>
    </div>
</nav>

<!--validation error-->
@if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>
     @if ($errors->has('email'))
     @endif
  </div>
@endif
<!-- flash error-->

@foreach (['danger', 'warning', 'success', 'info'] as $key)
 @if(Session::has($key))
     <p class="alert alert-{{ $key }} " id="erralrt">{{ Session::get($key) }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
 @endif
@endforeach

<!--Modal-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Take Appointment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container center">
                <form method="post" action="/appointment/create"  autocomplete="off" id="appform">
                @csrf
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="Title">Name:</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="Title">Email id:</label>
                            <input type="text" class="form-control" name="email_id" id="email_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                        <strong> Start Time : </strong> 
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"  name="start_date" id="start_date" data-target="#datetimepicker1" />
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <strong> End Time : </strong>  
                            <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="end_date" id="end_date" data-target="#datetimepicker2" />
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="Title">Appointment Title:</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-sm">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="save">Save</button>
                    </div>
                    </div>
                </form>
                <script type="text/javascript">
                    
                </script>
            </div>
        </div>
        </div>
    </div>
 </div>
<!--Modal End-->

<!--Appointment Delete Modal Start-->
<div id="classModal" class="modal fade bs-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="classModalLabel">
              Appointment Details
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
      </div>
      <div class="modal-body" style="overflow-x:auto;">
        <table id="classTable" class="table table-bordered">
          <thead>
          </thead>
          <tbody>
          <tr>
            <th> Title</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Actions</th>
            </tr>
            <tr>
            <td id="tl"></td>
            <td id="nm"></td>
            <td id="em"></td>
            <td id="strt"></td>
            <td id=""><a id="del"><i class="fa fa-trash red" aria-hidden="true"></i></a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<!--Delete Modal End-->

<!--Calendar-->
  <div class="container" style ="margin-top:25px;">
      <div class="response"></div>
      <div id='calendar'></div>  
  </div>
 
 
</body>
</html>

<!--stye-->

<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>

<!--stye-->

<!--jQuery-->
<script>

//datetimepicker js
$(function () {
    $('#datetimepicker1').datetimepicker(
        {   
            dateFormat: 'dd, mm, yy',
            daysOfWeekDisabled: [0,6],
            minDate:new Date()
        }
    );
    $('#datetimepicker2').datetimepicker(
        {
            dateFormat: 'dd, mm, yy',
            daysOfWeekDisabled: [0,6],
            minDate:new Date()
        }
    );
});

//disabe keys for start time and end time
$("#start_date").keydown(function(event) { 
    return false;
});

//validation
$("#save").click(function(e){

    
    var name = $('#name').val();
    var email_id=$('#email_id').val();
    var start_time=$('#start_date').val();
    var end_time=$('#end_date').val();
    var title = $('#title').val();

    var err=msg='';
    //textbox validation
    $('#name').removeClass('border-danger');
    $('#email_id').removeClass('border-danger');
    $('#title').removeClass('border-danger');
    
    var msg='Please fill all the fields';
    if(name == '' || name == "null"){
        var err='1';
        $('#name').addClass('border-danger');
    }
    if(email_id == '' || email_id == "null"){
        var err='1';
        $('#email_id').addClass('border-danger');
        
    }
    if(title == '' || title == 'null'){
        var err='1';
        $('#title').addClass('border-danger');
    }
    if(start_time == '' || start_time == 'null'){
        var err='1';
        $('#start_date').addClass('border-danger');
    }
    if(end_time == '' || end_time == 'null'){
        var err='1';
        $('#end_date').addClass('border-danger');
    }
    
    //date vaidation
    dt1=moment(start_time).format("YYYY-MM-DD") 
    dt2=moment(end_time).format("YYYY-MM-DD") 

    // end - start returns difference in milliseconds 
    var diff = new Date(Date.parse(dt2) - Date.parse(dt1));

    // get days
    var days = diff/(1000 * 60 * 60 * 24);

    if(days>=1){
        var msg='Please select a Single Day';
        $('#start_date').addClass('border-danger');
        $('#end_date').addClass('border-danger');
        var err='2';
    }
    
    //time functionality
    min = moment(start_time).format("HH:mm:ss")  
    min2 = moment(end_time).format("HH:mm:ss")

    var time1 = min.split(':');
    var time2 = min2.split(':');

    var sec1=time1[1]*60*1000;
    var sec2=time2[1]*60*1000;
    
    var val_min=30*60*1000;
    var diff= sec2-sec1;
    
    if(diff !== val_min && -(diff)!== val_min){
        var err='2';
        var msg='Take appointment only for 30 mins';
        $('#start_date').addClass('border-danger');
        $('#end_date').addClass('border-danger');
    }

    var hr1=time1[0];
    var hr2=time2[0];

    if(hr1<9 || hr1>=18){
        var msg='Appointment shoud be taken between 9 am to 6 pm';
        $('#start_date').addClass('border-danger');
        $('#end_date').addClass('border-danger');
        var err='2';
    }else if(hr2<9 || hr2>18){
        var msg='Appointment shoud be taken between 9 am to 6 pm';
        $('#start_date').addClass('border-danger');
        $('#end_date').addClass('border-danger');
        var err='3';
    }
    
    if(err == '1' || err == '2' || err == '3'){
        bootbox.alert(msg);
        return false;
    }else{
        $( "#appform" ).submit();
    }
});

var SITEURL = "{{url('/')}}";

$(document).ready(function () {
         
        
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
 
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/appointment",
            displayEventTime: true,
            editable: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            default: false,
            eventClick: function (event) {
                $('#classModal').modal("toggle");
                $('#tl').text(event.title);
                $('#nm').text(event.name);
                $('#em').text(event.email_id);
                var formDate = $.fullCalendar.formatDate(event.start, 'YYYY-MMMM-dddd hh:mm:ss');
                $('#strt').text(formDate);

                $("#del").click(function(){
                    bootbox.confirm("Are You Sure?", function(result){
                        if(result){
                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/appointment/delete',
                                data: '[{"id" : '+event.id+'}]',
                                dataType:"json",
                                success: function (response) {
                                    if(parseInt(response) > 0) {
                                        $('#calendar').fullCalendar('removeEvents', event.id);
                                        $('#classModal').modal('toggle'); 
                                        bootbox.alert("Appointment Deleted")
                                        $('#erralrt').text("");
                                    }
                                },
                                error:function(err){
                                    console.log(err)
                                }
                            });
                        }    
                    });
                });
            }
 
        });
  });
</script>
</body>
</html>