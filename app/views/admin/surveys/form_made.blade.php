@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
<script type="text/javascript" src="{{asset('js/utils.js')}}"></script>
<script type="text/javascript">

    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y/%m/%d"
            /*selectedDate:{   This is an example of what the full configuration offers.
             day:5,        For full documentation about these settings please see the full version of the code.
             month:9,
             year:2006
             },
             yearsRange:[1978,2020],
             limitToToday:false,
             cellColorScheme:"beige",
             dateFormat:"%m-%d-%Y",
             imgPath:"img/",
             weekStartDay:1*/
        });
    };
    
    function getDistricts() {
        
        var state_id = $('#state').val();
        if( state_id == 0 ){
            var district_select = '<select name="state" id="state" class="form-control" onChange="getTownships();" disabled></select>';
            document.getElementById('district_container').innerHTML=district_select;
            var township_select = '<select name="district" id="district" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        $.post("{{ URL::to('admin/surveys/get_district') }}", { state_id: state_id }, function(result){
            var district_select = "<select name=district id='district' class='form-control' onChange='getTownships();'>";
            district_select += "<option value='0'>- Seleccione un Distrito -</option>";
            $.each(result, function(key, value) {
            district_select += "<option value='"+value.id+"'>"+value.name+"</option>";
            });
            district_select += "</select>";
            document.getElementById('district_container').innerHTML=district_select;
            
            var township_select = '<select name="township" id="township" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
        });
    }
    
    function getTownships() {
        
        var state_id = $('#state').val();
        var district_id = $('#district').val();
        if( state_id == 0 ){
            var district_select = '<select name="state" id="state" class="form-control" onChange="getTownships();" disabled></select>';
            document.getElementById('district_container').innerHTML=district_select;
            var township_select = '<select name="district" id="district" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        if( district_id == 0 ){
            var township_select = '<select name="district" id="district" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        
        $.post("{{ URL::to('admin/surveys/get_township') }}", 
                { state_id: state_id, district_id: district_id }, function(result){
            var township_select = "<select name=township id='township' class='form-control' onChange='getSuburbs();'>";
            township_select += "<option value='0'>- Seleccione una Ciudad -</option>";
            $.each(result, function(key, value) {
                township_select += "<option value='"+value.id+"'>"+value.name+"</option>";
            });
            township_select += "</select>";
            document.getElementById('township_container').innerHTML=township_select;
            
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
        });
    }
    
    function getSuburbs() {
        
        var state_id = $('#state').val();
        var district_id = $('#district').val();
        var township_id = $('#township').val();
        if( state_id == 0 ){
            var district_select = '<select name="state" id="state" class="form-control" onChange="getTownships();" disabled></select>';
            document.getElementById('district_container').innerHTML=district_select;
            var township_select = '<select name="district" id="district" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        if( district_id == 0 ){
            var township_select = '<select name="district" id="district" class="form-control" onChange="getSuburbs();" disabled></select>';
            document.getElementById('township_container').innerHTML=township_select;
            var suburb_select = '<select name="suburb" id="suburb" class="form-control" disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        if( township_id == 0 ){
            var suburb_select = '<select name="suburb" id="suburb" class="form-control"disabled></select>';
            document.getElementById('suburb_container').innerHTML=suburb_select;
            return;
        }
        
        $.post("{{ URL::to('admin/surveys/get_suburbs') }}", 
                { state_id: state_id, district_id: district_id, township_id: township_id }, function(result){
            var suburb_select = "<select name='suburb' id='suburb' class='form-control'>";
            suburb_select += "<option value='0'>- Seleccione una Colonia -</option>";
            $.each(result, function(key, value) {
                suburb_select += "<option value='"+value.id+"'>"+value.name+"</option>";
            });
            suburb_select += "</select>";
            document.getElementById('suburb_container').innerHTML=suburb_select;
        });
    }
    
    function cancel () {
        window.location.href="{{ URL::to('admin/surveys/'.$id_questionary) }}";
    }

    jQuery(document).ready(function($) {
        $('#new_suburb').click(function(event) {
            if($(this).is(':checked'))
            {
                $('#new-suburb-container').show();
            }
            else
            {
                $('#new-suburb-container').hide();
            }
        });
    });

</script>
    

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>
        
        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">País</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="country" name="country" 
                       class="form-control" value="{{ $country->name }}" disabled />
            </div>
        </div>
        
        <div class="form-group {{($errors->has('state') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-6">
                <select name="state" id="state" class="form-control" onChange="getDistricts();">
                <option value='0'>- Seleccione un Estado -</option>
                    @foreach( $states as $state )
                        <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('district') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Distritos</label>
            <div class="col-sm-6" name="district_container" id="district_container">
                <select name="district" id="district" class="form-control" onChange="getTownships();" disabled>
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('township') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Ciudades</label>
            <div class="col-sm-6" name="township_container" id="township_container">
                <select name="township" id="township" class="form-control" onChange="getColognes();" disabled>
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('suburb') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Colonias</label>
            <div class="col-sm-6" name="suburb_container" id="suburb_container">
                <select name="suburb" id="suburb" class="form-control" disabled>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nueva colonia</label>
            <div class="col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="new_suburb_check" id="new_suburb" value="1">
                    </label>
                </div>
                <div id="new-suburb-container" style="display:none">
                    {{Form::text('new_suburb', '', array('placeholder' => 'Nueva colonia...', 'class' => 'form-control'))}}
                </div>                
            </div>
        </div>

        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="date" name="date" class="form-control" />
                @if($errors->has('date'))
                    <span class="help-block">{{$errors->first('date')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('actitude') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Actitud</label>
            <div class="col-sm-6">
                <select name="actitude" id="actitude" class="form-control">
                    @foreach( $actitudes as $act )
                        <option value="{{$act->value}}" @if($act->value == $actitude) selected='selected' @endif >{{$act->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('incomming') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Nivel Socioecon&oacute;mico</label>
            <div class="col-sm-6">
                <select name="incomming" id="incomming" class="form-control">
                <?php for( $i = 1; $i <= 10; $i++ ) { ?>
                    <option value="{{$i}}">{{$i}}</option>
                <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('estimated_age') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Edad Estimada</label>
            <div class="col-sm-6">
                <select name="estimated_age" id="estimated_age" class="form-control">
                    <option value="1">18 - 25</option>
                    <option value="2">26 - 30</option>
                    <option value="3">31 - 35</option>
                    <option value="4">36 - 40</option>
                    <option value="5">41 - 45</option>
                    <option value="6">46 - 50</option>
                    <option value="7">51 - 55</option>
                    <option value="8">56 - 60</option>
                    <option value="9">66 - 70</option>
                    <option value="10">76 - 80</option>
                    <option value="11">86 - 90</option>
                    <option value="12">> 90</option>
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('latitude') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Latitud</label>
            <div class="col-sm-6">
                {{Form::text('latitude', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('latitude'))
                    <span class="help-block">{{$errors->first('latitude')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('longitude') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Longitud</label>
            <div class="col-sm-6">
                {{Form::text('longitude', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('longitude'))
                    <span class="help-block">{{$errors->first('longitude')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('url_facade') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fotograf&iacute;a de la Fachada</label>
            <div class="col-sm-6">
                {{Form::file('url_facade', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('url_facade'))
                    <span class="help-block">{{$errors->first('url_facade')}}</span>
                @endif
            </div>
        </div>
        
        <input type="button" value="Cancelar" class="btn btn-default" onclick = "cancel();">
        {{Form::submit('Guardar', array('class' => 'btn btn-success'))}}
        
    </fieldset>
    {{Form::close()}}

@endsection