@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">
<link rel="stylesheet" href="{{asset('js/chosen/chosen.min.css')}}">
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
<script type="text/javascript">

    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y/%m/%d"
        });
    };
    
    function cancel () {
        window.location.href="{{ URL::to('admin/surveys/'.$id_questionary) }}";
    }

    jQuery(document).ready(function($) {

        $('#state').change(function(){
            var state_id = $(this).val();

            $.post("{{ URL::to('admin/surveys/get_district') }}", { state_id: state_id }, function(data){

                $('#district').empty().append('<option value="0">Selecciona un distrito</option>');

                for(var key in data) {
                    var option = $('<option></option>');

                    option.val(data[key].id);
                    option.html( data[key].number + '.- ' + data[key].name);

                    $('#district').append(option);
                }

                $('#district').removeAttr('disabled');
            });
        });

        $('#district').change(function(){
            var state_id = $('#state').val();
            var district_id = $(this).val();

            $.post("{{ URL::to('admin/surveys/get_township') }}", { state_id: state_id, district_id: district_id }, function(data) {
                $('#township').empty().append('<option value="0">Selecciona un corregimiento</option>');

                for(var key in data) {
                    var option = $('<option></option>');

                    option.val(data[key].id);
                    option.html( data[key].number + '.- ' + data[key].name);

                    $('#township').append(option);
                }

                $('#township').removeAttr('disabled');
            });
        });

        $('#township').change(function(){
            var state_id = $('#state').val();
            var district_id = $('#district').val();
            var township_id = $(this).val();

            $.post("{{ URL::to('admin/surveys/get_neighborhoods'); }}", { state_id: state_id, district_id: district_id, township_id: township_id }, function(data){

                $('#neighborhood').empty().append('<option value="0">Selecciona una barriada</option>');

                for(var key in data) {
                    var option = $('<option></option>');

                    option.val(data[key].id);
                    option.html( data[key].number + '.- ' + data[key].name);

                    $('#neighborhood').append(option);
                }

                $('#neighborhood').removeAttr('disabled');
            });
        });

        // $('#township').change(function(){
        //     var state_id = $('#state').val();
        //     var district_id = $('#district').val();
        //     var township_id = $(this).val();

        //     $.post("{{ URL::to('admin/surveys/get_suburbs'); }}", {state_id: state_id, district_id: district_id, township_id: township_id}, function(data) {
        //         $('#suburb').empty().append('<option value="0">Selecciona un lugar poblado</option>');

        //         for(var key in data) {
        //             var option = $('<option></option>');

        //             option.val(data[key].id);
        //             option.html( data[key].number + '.- ' + data[key].name);

        //             $('#suburb').append(option);
        //         }

        //         $('#suburb').removeAttr('disabled');
        //     });
        // });

        $('#suburb').change(function(){
            var state_id = $('#state').val();
            var district_id = $('#district').val();
            var township_id = $('#township').val();
            var suburb_id = $(this).val();

            $.post("{{ URL::to('admin/surveys/get_neighborhoods'); }}", { state_id: state_id, district_id: district_id, township_id: township_id, suburb_id: suburb_id }, function(data){

                $('#neighborhood').empty().append('<option value="0">Selecciona una barriada</option>');

                for(var key in data) {
                    var option = $('<option></option>');

                    option.val(data[key].id);
                    option.html( data[key].number + '.- ' + data[key].name);

                    $('#neighborhood').append(option);
                }

                $('#neighborhood').removeAttr('disabled');
            });
        });

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


        $('input.age-text').keyup(function(){
            var age = $(this).val();

            if(age < 18) {
                $(this).css('color', 'red');
            } else {
                $(this).css('color', 'black');
            }

            if(age > 18 && age<=25) {
                $('select#estimated_age').val(1);
            } else if(age > 26 && age <= 30) {
                $('select#estimated_age').val(2);                
            } else if(age > 31 && age <= 35) {
                $('select#estimated_age').val(3);                
            } else if(age > 36 && age <= 40) {
                $('select#estimated_age').val(4);
            } else if(age > 41 && age <= 45) {
                $('select#estimated_age').val(5);                
            } else if(age > 46 && age <= 50) {
                $('select#estimated_age').val(6);
            } else if(age > 51 && age <= 55) {
                $('select#estimated_age').val(7);                
            } else if(age > 56 && age <= 60) {
                $('select#estimated_age').val(8);
            } else if(age > 61 && age <= 65) {
                $('select#estimated_age').val(9);
            } else if(age > 66 && age <= 70) {
                $('select#estimated_age').val(10);                
            } else if(age > 71 && age <= 75) {
                $('select#estimated_age').val(11);                
            } else if(age > 76 && age <= 80) {
                $('select#estimated_age').val(12);                
            } else if(age > 81 && age <= 85) {
                $('select#estimated_age').val(13);                
            } else if(age > 86 && age <= 90) {
                $('select#estimated_age').val(14);                
            } else if(age > 90) {
                $('select#estimated_age').val(15);
            } else {
                $('select#estimated_age').val(1);
            }

            $('input#hidden_estimated_age').val( $('select#estimated_age').val() );

        });

        // $('#users').change(function(){

        //     $.post('{{url('/admin/surveys/get-child-users')}}', { user_id: $(this).val() }, function(data){

        //         $('#child-users').empty();

        //         for(var key in data) {
        //             var temp_option = $('<option></option>');
        //             temp_option.html(data[key].name+' '+data[key].patern_name+' '+data[key].matern_name);
        //             temp_option.val(data[key].id);
        //             $('#child-users').append(temp_option);

        //         }

        //         $('#child-users').trigger("chosen:updated");
        //     });

        // });

        $('#users').chosen();
        $('#child-users').chosen();

        $('form#main-form').submit(function(){
            return validateForm();
        });;

        $('form#main-form').submit(function(){
            return validateForm();
        });

        $('form#new-user-form').ajaxForm(function(responseText){
            $('#users').val(responseText.user_id).trigger('change');
            $('#child-users').val(responseText.id);

            $('#users, #child-users').trigger('chosen:updated');
        });
    });

</script>

    <!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Nuevo encuestador</h4>
          </div>
          <div class="modal-body">
            {{Form::open( array('url' => 'admin/users/save-create-ajax', 'method' => 'POST', 'id' => 'new-user-form', 'class' => 'form-horizontal') )}}

            <div class="form-group {{($errors->has('name') ? 'has-error' : '')}} ">
                <label for="" class="col-sm-4 control-label">Nombre</label>
                <div class="col-sm-6">
                    {{Form::text('name', '', array('class' => 'form-control') )}}
                </div>
            </div>

            <div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
                <label for="" class="col-sm-4 control-label">Apellido Paterno</label>
                <div class="col-sm-6">
                    {{Form::text('patern_name', '', array('class' => 'form-control') )}}
                </div>
            </div>

            <div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
                <label for="" class="col-sm-4 control-label">Apellido Materno</label>
                <div class="col-sm-6">
                    {{Form::text('matern_name', '', array('class' => 'form-control') )}}
                </div>
            </div>

            <div class="form-group {{($errors->has('email') ? 'has-error' : '')}} ">
                <label for="" class="col-sm-4 control-label">Correo</label>
                <div class="col-sm-6">
                    {{Form::text('email', '', array('class' => 'form-control') )}}
                </div>
            </div>

            <div class="form-group {{($errors->has('password') ? 'has-error' : '')}} ">
                <label for="" class="col-sm-4 control-label">Contraseña</label>
                <div class="col-sm-6">
                    {{Form::password('password', array('class' => 'form-control') )}}
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-4 control-label">Confirmar contraseña</label>
                <div class="col-sm-6">
                    {{Form::password('password_confirmation', array('class' => 'form-control') )}}
                </div>
            </div>

            {{Form::hidden('user_type', 4)}}

            <div id="users-select" class="form-group">
                <label for="" class="col-sm-4 control-label">Nombre Supervisor</label>
                <div class="col-sm-6">
                    <select name="user_id" class="form-control" id="users-control">
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name.' '.$user->patern_name.' '.$user->matern_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            {{Form::submit('Guardar', array('class' => 'btn btn-primary'))}}
            {{Form::close()}}
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'files' => true, 'method' => 'POST', 'role' => 'form', 'id' => 'main-form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Supervisor</label>
            <div class="col-sm-6">
                <select name="" id="users" class="form-control" data-placeholder="Selecciona un supervisor...">
                    <option value="0">Selecciona un supervisor...</option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name.' '.$user->patern_name.' '.$user->matern_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Encuestador</label>
            <div class="col-sm-6">
                <select name="user_id" id="child-users" class="form-control validate-input" data-placeholder="Selecciona un encuestador..." >
                    <option value="0">Selecciona un encuestador...</option>
                    @foreach($sub_users as $user)
                    <option value="{{$user->id}}">{{$user->name.' '.$user->patern_name.' '.$user->matern_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <img src="{{asset('img/add_user_24_24.png')}}" alt="" data-toggle="modal" data-target="#addUser" style="cursor:pointer">
            </div>
        </div>

        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Folio</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="folio" name="folio" 
                       class="form-control validate-input" value="" maxlength="7" />
            </div>
        </div>
        
        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">País</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="country" name="country" 
                       class="form-control" value="{{ $country->name }}" disabled />
            </div>
        </div>
        
        <div class="form-group {{($errors->has('state') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Provincia</label>
            <div class="col-sm-6">
                <select name="state" id="state" class="form-control validate-input">
                <option value='0'>- Seleccione una Provincia -</option>
                    @foreach( $states as $state )
                        <option value="{{$state->id}}">{{$state->number}}.- {{$state->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('district') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Distrito</label>
            <div class="col-sm-6" name="district_container" id="district_container">
                <select name="district" id="district" class="form-control validate-input" disabled>
                </select>
            </div>
        </div>
        
        <div class="form-group {{($errors->has('township') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Corregimiento</label>
            <div class="col-sm-6" name="township_container" id="township_container">
                <select name="township" id="township" class="form-control validate-input" disabled>
                </select>
            </div>
        </div>
        
        <!-- <div class="form-group {{($errors->has('suburb') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Lugar Poblado</label>
            <div class="col-sm-6" name="suburb_container" id="suburb_container">
                <select name="suburb" id="suburb" class="form-control validate-input" disabled>
                </select>
            </div>
        </div> -->

        <!-- <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nuevo Lugar Poblado</label>
            <div class="col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="new_suburb_check" id="new_suburb" value="1">
                    </label>
                </div>
                <div id="new-suburb-container" style="display:none">
                    {{Form::text('new_suburb', '', array('placeholder' => 'Nuevo Lugar Poblado...', 'class' => 'form-control'))}}
                </div>                
            </div>
        </div> -->

        <div class="form-group {{($errors->has('neighborhood') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Barriada</label>
            <div class="col-sm-6" name="neighborhood_container" id="suburb_container">
                <select name="neighborhood" id="neighborhood" class="form-control validate-input" disabled>
                </select>
            </div>
        </div>

        <div class="form-group {{($errors->has('zone') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Zona</label>
            <div class="col-sm-6" name="suburb_container" id="suburb_container">
                {{Form::text('zone', '', array('class' => 'form-control validate-input', 'maxlength' => 2))}}
            </div>
        </div>

        <div class="form-group {{($errors->has('suburb') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Área</label>
            <div class="col-sm-6" name="suburb_container" id="suburb_container">
                <select name="area" id="area" class="form-control">
                    <option value="0">Selecciona un área</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
                <!--
                {{Form::text('area', '', array('class' => 'form-control validate-input', 'maxlength' => 2))}}
                -->
            </div>
        </div>

        <!-- <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="date" name="date" class="form-control validate-input" />
                @if($errors->has('date'))
                    <span class="help-block">{{$errors->first('date')}}</span>
                @endif
            </div>
        </div> -->
        
        <!-- <div class="form-group {{($errors->has('actitude') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Actitud</label>
            <div class="col-sm-6">
                <select name="actitude" id="actitude" class="form-control">
                    @foreach( $actitudes as $act )
                        <option value="{{$act->value}}" @if($act->value == $actitude) selected='selected' @endif >{{$act->name}}</option>
                    @endforeach
                </select>
            </div>
        </div> -->
        
        <!-- <div class="form-group {{($errors->has('incomming') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Nivel Socioecon&oacute;mico</label>
            <div class="col-sm-6">
                <select name="incomming" id="incomming" class="form-control">
                <?php for( $i = 1; $i <= 10; $i++ ) { ?>
                    <option value="{{$i}}">{{$i}}</option>
                <?php } ?>
                </select>
            </div>
        </div> -->        

        <div class="form-group {{($errors->has('age') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Edad</label>
            <div class="col-sm-6">
                {{Form::text('age', '', array('class' => 'form-control age-text validate-input', 'maxlength' => 2))}}
            </div>
        </div>
        
        <div class="form-group {{($errors->has('estimated_age') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Rango de edad</label>
            <div class="col-sm-6">
                <select name="estimated_age_select" id="estimated_age" class="form-control" disabled>
                    <option value="1">18 - 25</option>
                    <option value="2">26 - 30</option>
                    <option value="3">31 - 35</option>
                    <option value="4">36 - 40</option>
                    <option value="5">41 - 45</option>
                    <option value="6">46 - 50</option>
                    <option value="7">51 - 55</option>
                    <option value="8">56 - 60</option>
                    <option value="9">61 - 65</option>
                    <option value="10">66 - 70</option>
                    <option value="11">71 - 75</option>
                    <option value="12">76 - 80</option>
                    <option value="13">81 - 85</option>
                    <option value="14">86 - 90</option>
                    <option value="15">> 90</option>
                </select>
                <input type="hidden" name="estimated_age" id="hidden_estimated_age" value="1">
            </div>
        </div>

        <!-- <div class="form-group {{($errors->has('latitude') ? 'has-error' : '')}} ">
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
        </div> -->

        <div class="form-group {{($errors->has('response_type') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Tipo de respuesta</label>
            <div class="col-sm-6">
                <select name="response_type" id="" class="form-control validate-input">
                    <option value="2">Personal</option>
                    <option value="1">Telefónica</option>
                </select>
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