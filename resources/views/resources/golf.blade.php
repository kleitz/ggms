@extends('layouts.master')

@section('title', 'Tee-time')

@section('header')
@parent
<script src="/js/bootstrap3-typeahead.min.js"></script>
@endsection

@section('content')
<div class="page-header">
	<h1>Reserve Golf Tee-time</h1>
  @include('partials.error', ['title' => 'Event creation failed'])
  @if ($user->hasRole('golf_ops_manager'))
  <p class="help-block">As the golf operations manager, you may allow a user to use a flight. You can 
    <a href="{{ action('ResourceController@index') }}">click here to view the list of facilities</a>, including flights.
  </p>
  @else
  <p class="help-block">As a member, you may request to use a flight. You can 
    <a href="{{ action('ResourceController@index') }}">click here to view the list of facilities</a>, including flights.
  </p>
  @endif
</div>

{!! Form::open(array('action' => 'ResourceController@store_rent')) !!}
<div class="row">
  <div class="form-group form-height-sm col-md-4">
    <label for="resource_name">Name of Flight</label>
    <input type="text" class="form-control" id="resource_name" name="resource" placeholder="e.g. Flight 3" data-provide="typeahead" autocomplete="off">
  </div>

@if ($user->hasRole('user'))
  <div class="form-group form-height-sm col-md-8">
    <label for="client_name">Name of client</label>
    <p>{{ $user->display_name }}</p>
    <input type="hidden" class="form-control" id="client_name" name="client" value="{{ $user->name }}" data-provide="typeahead" autocomplete="off">
  </div>
  @else
  <div class="form-group form-height-sm col-md-8">
    <label for="client_name">Name of client</label>
    <input type="text" class="form-control" id="client_name" name="client" placeholder="Name of client" data-provide="typeahead" autocomplete="off">
  </div>
  @endif
</div>

<div class="row">
  <div class="form-group form-height-md col-md-4">
    <label for="date">Rent start time</label>
          <div class='input-group date' id='datetimepicker1'>
            <input type='text' class="form-control" name="start" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
      <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          minDate: moment(),
          useCurrent: false,
          sideBySide: true
        });
      });
      </script>
    </div>
  </div>

  <div class="form-group form-height-md col-md-8">
    <label for="date">Rent end time</label>
          <div class='input-group date' id='datetimepicker2'>
            <input type='text' class="form-control" name="end" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
      <script type="text/javascript">
      $(function () {
        $('#datetimepicker2').datetimepicker({
          useCurrent: false,
          sideBySide: true,
          minDate: moment()
        });


      $('#30m').on("click", function (e) {
            e.preventDefault();
            var text = $('#datetimepicker1').data("DateTimePicker").date();
            var time = moment(text).add(30, 'm');
            $('#datetimepicker2').data("DateTimePicker").date(time);
          });

      $('#1h').on("click", function (e) {
            e.preventDefault();
            var text = $('#datetimepicker1').data("DateTimePicker").date();
            var time = moment(text).add(1, 'h');
            $('#datetimepicker2').data("DateTimePicker").date(time);
          });

      $('#2h').on("click", function (e) {
            e.preventDefault();
            var text = $('#datetimepicker1').data("DateTimePicker").date();
            var time = moment(text).add(2, 'h');
            $('#datetimepicker2').data("DateTimePicker").date(time);
          });

      $('#3h').on("click", function (e) {
            e.preventDefault();
            var text = $('#datetimepicker1').data("DateTimePicker").date();
            var time = moment(text).add(3, 'h');
            $('#datetimepicker2').data("DateTimePicker").date(time);
          });

      $('#datetimepicker1').data("DateTimePicker").date(moment());

      });

      

      $("#datetimepicker1").on("dp.change", function (e) {
        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        $('#datetimepicker2').data("DateTimePicker").maxDate(moment(e.date).add(1, 'Day'));
      });
      $("#datetimepicker2").on("dp.change", function (e) {
        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
      });
      
      </script>
    </div>
    <div style="margin-top: 10px">
      <a class="btn btn-default btn-sm" href="#" id="30m">30m</a> &nbsp
      <a class="btn btn-default btn-sm" href="#" id="1h">1h</a> &nbsp
      <a class="btn btn-default btn-sm" href="#" id="2h">2h</a> &nbsp
      <a class="btn btn-default btn-sm" href="#" id="3h">3h</a> &nbsp
    </div>
  </div>
</div>


  <hr>
  <p>Once the form is submitted, the renting of that facility will be posted and GGMS employees can view it.
    As the golf operations manager, you can modify the status of this rental afterwards.</p>
  <button type="submit" class="btn btn-primary">Set tee time</button>
{!! Form::close() !!}

<script type="text/javascript">
  $.get('/config/resources_golf.json', function(data){
    $("#resource_name").typeahead({ source:data });
  },'json');

  $.get('/users.json', function(data){
    $("#client_name").typeahead({ source:data });
  },'json');
</script>
@stop