@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
<script type="text/javascript">
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "birth_date",
            dateFormat: "%Y/%m/%d"
                    /*selectedDate:{                                                           This is an example of what the full configuration offers.
                     day:5,                                                                                  For full documentation about these settings please see the full version of the code.
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
    
    function cancel () {
        window.location.href="{{ URL::to('admin/surveys/'.$id_questionary) }}";
    }

</script>

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <div class="form-group {{($errors->has('name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-6">
                {{Form::text('name', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('name'))
                    <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Apellido Paterno</label>
            <div class="col-sm-6">
                {{Form::text('patern_name', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('patern_name'))
                    <span class="help-block">{{$errors->first('patern_name')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('matern_name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Apellido Materno</label>
            <div class="col-sm-6">
                {{Form::text('matern_name', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('matern_name'))
                    <span class="help-block">{{$errors->first('matern_name')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('birth_date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha de Nacimiento</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="birth_date" name="birth_date" onclick="" class="form-control" />
                @if($errors->has('birth_date'))
                    <span class="help-block">{{$errors->first('birth_date')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('sex') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Sexo</label>
            <div class="col-sm-6">
                <input type="radio" name="sex" value="Masculino">&nbsp;Masculino
                &nbsp;&nbsp;&nbsp;
                <input type="radio" name="sex" value="Femenino">&nbsp;Femenino
            </div>
        </div>
        
        <div class="form-group {{($errors->has('phone') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Tel&eacute;fono</label>
            <div class="col-sm-6">
                {{Form::text('phone', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('phone'))
                    <span class="help-block">{{$errors->first('phone')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('cellphone') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Celular</label>
            <div class="col-sm-6">
                {{Form::text('cellphone', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('cellphone'))
                    <span class="help-block">{{$errors->first('cellphone')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('state') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Provincia</label>
            <div class="col-sm-6">
                {{Form::text('state', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('state'))
                    <span class="help-block">{{$errors->first('state')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('district') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Distrito</label>
            <div class="col-sm-6">
                {{Form::text('district', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('district'))
                    <span class="help-block">{{$errors->first('district')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('township') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Corregimiento</label>
            <div class="col-sm-6">
                {{Form::text('township', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('township'))
                    <span class="help-block">{{$errors->first('township')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('section') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Secci&oacute;n</label>
            <div class="col-sm-6">
                {{Form::text('section', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('section'))
                    <span class="help-block">{{$errors->first('section')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Colonia</label>
            <div class="col-sm-6">
                {{Form::text('cologne', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('cologne'))
                    <span class="help-block">{{$errors->first('cologne')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">El Encuestado es</label>
            <div class="col-sm-6">
                <select name="type" id="type" class="form-control">
                    <option value="1">Jefe de Familia</option>
                    <option value="2">Cónyugue del jefe de familia</option>
                    <option value="3">Miembro de la familia</option>
                </select>
            </div>
        </div>

        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Documento de Identidad</label>
            <div class="col-sm-6">
                {{Form::text('identity_document', $value = null, array('class' => 'form-control', 'maxlength' => 8) )}}
                @if($errors->has('identity_document'))
                    <span class="help-block">{{$errors->first('identity_document')}}</span>
                @endif
            </div>
        </div>
        
        {{Form::submit('Guardar', array('class' => 'btn btn-success'))}}
        
    </fieldset>
    {{Form::close()}}

@endsection