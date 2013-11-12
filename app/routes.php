<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('/admin');
});

Route::get('/admin', function(){

	if(Auth::check())
	{
		return Redirect::to('/admin/home');
	}
	else
	{
		return Redirect::to('/admin/login');
	}

});

Route::get('/admin/login', 'LoginController@index');
Route::post('/admin/logon', 'LoginController@logon');
Route::get('/admin/login/logout', 'LoginController@logout');

Route::get('/admin/profile', array('before' => 'auth', 'uses' => 'UsersController@profile'));
Route::post('/admin/save-profile', array('before' => 'auth', 'uses' => 'UsersController@save_profile'));

Route::get('/admin/home', array('before' => 'auth', 'uses' => 'HomeController@index'));

Route::get('/admin/users', array('before' => 'auth', 'uses' => 'UsersController@index'));
Route::get('/admin/users/create', array('before' => 'auth', 'uses' => 'UsersController@create'));
Route::post('/admin/users/save-create', array('before' => 'auth', 'uses' => 'UsersController@save_create'));
Route::get('/admin/users/update/{num}', array('before' => 'auth', 'uses' => 'UsersController@update'));
Route::post('/admin/users/save-update', array('before' => 'auth', 'uses' => 'UsersController@save_update'));
Route::get('/admin/users/details/{num}', array('before' => 'auth', 'uses' => 'UsersController@details'));
Route::get('/admin/users/delete/{num}', array('before' => 'auth', 'uses' => 'UsersController@delete'));
Route::post('/admin/users/delete', array('before' => 'auth', 'uses' => 'UsersController@delete_user'));


Route::get('/admin/projects', array('before' => 'auth', 'uses' => 'ProjectsController@index'));

Route::get('/admin/questionaries/{num}', array('before' => 'auth', 'uses' => 'QuestionariesController@index'));

Route::get('/admin/surveys/{num}', array('before' => 'auth', 'uses' => 'SurveysController@index'));
Route::get('/admin/surveys/create', array('before' => 'auth', 'uses' => 'SurveysController@create'));
Route::get('/admin/surveys/save-create', array('before' => 'auth', 'uses' => 'SurveysController@save_create'));
Route::get('/admin/surveys/view-surveys/{num}', array('before' => 'auth', 'uses' => 'SurveysController@view_surveys'));
Route::get('/admin/surveys/details/{num}', array('before' => 'auth', 'uses' => 'SurveysController@details_surveys'));

//Webservices

Route::post('/ws-content/json/ws-login', function(){
	$data = Input::get('data');
	$data_decoded = json_decode($data);

	$username = $data_decoded->user;
	$password = $data_decoded->password;

	if(Auth::validate( array('email' => $username, 'password' => $password) ))
	{
		$user = User::where('email', '=', $username)->first();

		if(Hash::check($password, $user->password))
		{
			return array(
				'code' => 1,
				'message' => 'exito',
				'id_questionary' => 1,
				'name' => $user->name,
				'id_user' => $user->id
			);
		}
		else 
		{
			return array(
				'code' => 2,
				'message' => 'No válido'
			);
		}
	}
	else 
	{
		return array(
			'code' => 2,
			'message' => 'No válido'
		);
	}

});

Route::post('/ws-content/json/ws-recovery', function(){
	$data = Input::get('data');
	$data_decoded = json_decode($data);

	$email = $data_decoded->email;

	$user = User::where('email', '=', $email)->first();

	if($user)
	{
		$new_password = str_random(8);

		$user->password = Hash::make($new_password);
		$user->save();

		$data = array(
			'password' => $new_password
		);

		Mail::send('emails.recovery', $data, function($message) use($user){
			$message->to($user->email, $user->name)->subject('Recuperación de contraseña');
		});

		return array(
			'code' => 1,
			'message' => 'Contraseña restablecida.'
		);
	}
	else
	{
		return array(
			'code' => 2,
			'message' => 'El correo no existe.'
		);
	}

});

Route::post('/ws-content/json/ws-questionary', function(){
	$data = Input::get('data');
	$data_decoded = json_decode($data);

	$id_encuestador = $data_decoded->id_encuestador;
	$id_encuesta = $data_decoded->id_encuesta;
	$user = User::find($id_encuestador);

	if($user)
	{
		$questionary = $user->questionnaires()->find($id_encuesta);

		if($questionary)
		{
			$questions = array();

			foreach($questionary->questions as $question):
				array_push($questions, array(
					'id' => $question->id,
					'question' => $question->question,
					'type' => $question->type,
					'answer' => $question->answers->toArray()
				));
			endforeach;

			return array(
				'questionary' => $questions
			);
		}
		else
		{
			return array(
				'code' => 2,
				'message' => 'No válido'
			);
		}
	}
	else 
	{
		return array(
			'code' => 2,
			'message' => 'No válido'
		);
	}

});

Route::post('/ws-content/json/ws-send', function(){

	$data = Input::get('data');

	$data_decoded = json_decode($data);

	$questionary_made = new QuestionaryMade;

	$questionary_made->questionary_id = $data_decoded->id_encuesta;
	$questionary_made->date = date('Y-m-d H:i:s');
	$questionary_made->actitude = $data_decoded->more->actitude;
	$questionary_made->estimated_age = $data_decoded->more->age;
	$questionary_made->incomming = $data_decoded->more->incomming;
	$questionary_made->latitude = $data_decoded->location->latitude;
	$questionary_made->longitude = $data_decoded->location->longitude;

	if( !empty($data_decoded->respondent->name) )
	{
		$respondent = new Respondent;

		$respondent->name = $data_decoded->respondent->name;
		$respondent->patern_name = $data_decoded->respondent->paternal;
		$respondent->matern_name = $data_decoded->respondent->maternal;
		$respondent->birth_date = $data_decoded->respondent->date_of_birth;
		$respondent->sex = $data_decoded->respondent->sex;
		$respondent->phone = $data_decoded->respondent->phone;
		$respondent->cellphone = $data_decoded->respondent->cellphone;
		$respondent->state = $data_decoded->respondent->domicile->state;
		$respondent->district = $data_decoded->respondent->domicile->district;
		$respondent->township = $data_decoded->respondent->domicile->township;
		$respondent->section = $data_decoded->respondent->domicile->section;
		$respondent->cologne = $data_decoded->respondent->domicile->cologne;

		$respondent->save();

		$questionary_made->respondent_id = $respondent->id;
	}

	if(Input::hasFile('facade'))
	{
		$image = Image::make( Input::file('facade')->getRealPath() );

		// $image->grab(150, 150);
		$image->save( 'img/facades/'.md5(Input::file('facade')->getClientOriginalName().date('Y-m-d H:i:s')).'.'.Input::file('facade')->getClientOriginalExtension()  );

		$questionary_made->url_facade = asset(str_replace(' ', '%20', 'img/facades/'.md5(Input::file('facade')->getClientOriginalName().date('Y-m-d H:i:s')).'.'.Input::file('facade')->getClientOriginalExtension()));
	}

	$questionary_made->save();

	foreach($data_decoded->questionary as $question):
		foreach($question->answer as $answer):
			$answer_temp = new QuestionaryMadeAnswers;

			$answer_temp->questionary_made_id = $questionary_made->id;
			$answer_temp->answer_id = $answer->id;
			$answer_temp->answer = $answer->value;
			$answer_temp->which = $question->which;
			$answer_temp->question_id = $question->id;

			$answer_temp->save();
		endforeach;
	endforeach;

	return array(
		'code' => 1,
		'message' => 'Datos guardados.',
		'questionary_made' => $questionary_made->toArray()
	);

});

Route::get('/hash', function(){
	return Hash::make('password123');
});