@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">
<link rel="stylesheet" href="{{asset('js/jquery.js')}}">
<script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
<script type="text/javascript">
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "inputField",
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
        window.location.href="{{ URL::to('admin/surveys/'.$id_questionary) }}"
    }

</script>

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="inputField" name="inputField" onclick="" class="form-control" />
                @if($errors->has('date'))
                    <span class="help-block">{{$errors->first('date')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('actitude') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Actitud</label>
            <div class="col-sm-6">
                {{Form::text('actitude', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('actitude'))
                    <span class="help-block">{{$errors->first('actitude')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('incomming') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Ingreso</label>
            <div class="col-sm-6">
                {{Form::text('incomming', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('incomming'))
                    <span class="help-block">{{$errors->first('incomming')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('estimated_age') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Edad Estimada</label>
            <div class="col-sm-6">
                {{Form::text('estimated_age', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('estimated_age'))
                    <span class="help-block">{{$errors->first('estimated_age')}}</span>
                @endif
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
            <label for="" class="col-sm-2 control-label">Fachada</label>
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