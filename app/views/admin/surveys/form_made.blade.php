@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">
<link rel="stylesheet" href="{{asset('js/jquery.js')}}">
<script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
<script type="text/javascript">
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "date",
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

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'files' => true, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <div class="form-group {{($errors->has('date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="date" name="date" onclick="" class="form-control" />
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
            <label for="" class="col-sm-2 control-label">Ingreso</label>
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