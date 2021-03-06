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
Route::post('/admin/users/save-create-ajax', array('before' => 'auth', 'uses' => 'UsersController@save_create_ajax'));
Route::get('/admin/users/update/{num}', array('before' => 'auth', 'uses' => 'UsersController@update'));
Route::post('/admin/users/save-update', array('before' => 'auth', 'uses' => 'UsersController@save_update'));
Route::get('/admin/users/details/{num}', array('before' => 'auth', 'uses' => 'UsersController@details'));
Route::get('/admin/users/delete/{num}', array('before' => 'auth', 'uses' => 'UsersController@delete'));
Route::post('/admin/users/delete', array('before' => 'auth', 'uses' => 'UsersController@delete_user'));


Route::get('/admin/projects', array('before' => 'auth', 'uses' => 'ProjectsController@index'));

Route::get('/admin/questionaries/{num}', array('before' => 'auth', 'uses' => 'QuestionariesController@index'));

Route::get('/admin/questions/{num}', array('before' => 'auth', 'uses' => 'QuestionsController@index'));

Route::get('/admin/surveys/{num}', array('before' => 'auth', 'uses' => 'SurveysController@index'));
Route::get('/admin/surveys/export/{num}', array('before' => 'auth', 'uses' => 'SurveysController@export'));
Route::get('/admin/surveys/new_survey/{num}', array('before' => 'auth', 'uses' => 'SurveysController@new_survey'));
Route::post('/admin/surveys/get_district', array('before' => 'auth', 'uses' => 'SurveysController@get_district'));
Route::post('/admin/surveys/get_township', array('before' => 'auth', 'uses' => 'SurveysController@get_township'));
Route::post('/admin/surveys/get_suburbs', array('before' => 'auth', 'uses' => 'SurveysController@get_suburbs'));
Route::post('/admin/surveys/get_neighborhoods', array('before' => 'auth', 'uses' => 'SurveysController@get_neighborhoods'));
Route::get('/admin/surveys/answer/{num}/{questionary_made_id}', array('before' => 'auth', 'uses' => 'SurveysController@answer'));
Route::post('/admin/surveys/save-create-made', array('before' => 'auth', 'uses' => 'SurveysController@save_create_made'));
Route::post('/admin/surveys/save-create-made-answers', array('before' => 'auth', 'uses' => 'SurveysController@save_create_made_answers'));
Route::post('/admin/surveys/save-create-respondents', array('before' => 'auth', 'uses' => 'SurveysController@save_create_respondents'));
Route::post('/admin/surveys/get-respondent-identity', array('before' => 'auth', 'uses' => 'SurveysController@get_respondent_identity'));
Route::get('/admin/surveys/new-respondent/{num}/{questionary_made_id}', array('before' => 'auth', 'uses' => 'SurveysController@new_respondent'));
Route::post('/admin/surveys/get-child-users', array('before' => 'auth', 'uses' => 'SurveysController@get_child_users'));
Route::post('/admin/surveys/get-validation-questions', array('before' => 'auth', 'uses' => 'SurveysController@get_validation_questions'));

Route::get('/admin/reports/users-surveys', array('before' => 'auth', 'uses' => 'ReportsController@users_surveys'));
Route::post('/admin/reports/users-surveys', array('before' => 'auth', 'uses' => 'ReportsController@users_surveys'));
Route::get('/admin/reports/pollster-surveys', array('before' => 'auth', 'uses' => 'ReportsController@pollster_surveys'));
Route::post('/admin/reports/pollster-surveys', array('before' => 'auth', 'uses' => 'ReportsController@pollster_surveys'));

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
	$questionary_made->estimated_age = $data_decoded->more->estimatedAge;
	$questionary_made->incomming = $data_decoded->more->incomming;
	$questionary_made->latitude = $data_decoded->location->latitude;
	$questionary_made->longitude = $data_decoded->location->longitude;
	$questionary_made->country_id = 1;
	$questionary_made->state_id = $data_decoded->more->id_state;
	$questionary_made->district_id = $data_decoded->more->id_district;
	$questionary_made->township_id = $data_decoded->more->id_town;
	// $questionary_made->suburb_id = $data_decoded->location->id_cologne;
	$questionary_made->suburb_id = $data_decoded->more->id_cologne;
	$questionary_made->area = $data_decoded->more->area;
	$questionary_made->zone = $data_decoded->more->zone;
	$questionary_made->age = $data_decoded->more->age;
	$questionary_made->folio = $data_decoded->more->folio;
	$questionary_made->user_id = $data_decoded->more->id_user;
	$questionary_made->user_create = $data_decoded->mode->id_user;

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
		$respondent->exterior_number = $data_decoded->respondent->domicile->noExt;
		$respondent->interior_number = $data_decoded->respondent->domicile->noInt;
		$respondent->section = $data_decoded->respondent->domicile->section;
		$respondent->identity_document = $data_decoded->respondent->documentoIdentidad;
		$respondent->location_reference = $data_decoded->respondent->reference;

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
			$answer_temp->answer_text = $answer->value;
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

Route::post('/ws-content/json/ws-where', function(){

	$data = Input::get('data');

	$data_decoded = json_decode($data);

	$country = Country::find($data_decoded->id_country);

	$data_array = array();

	foreach($country->states as $state):
		$state_districts = array();

		foreach($state->districts as $district):
			$district_towns = array();

			foreach($district->townships as $township):
				$township_suburbs = array();

				foreach($township->suburbs as $suburb):
					$cologne = array(
						'id' => $suburb->id,
						'name' => $suburb->name,
						'id_country' => $suburb->country_id,
						'id_state' => $suburb->state_id,
						'id_district' => $suburb->district_id,
						'id_town' => $suburb->township_id
					);

					array_push($township_suburbs, $cologne);
				endforeach;

				$town = array(
					'id' => $township->id,
					'name' => $township->name,
					'id_country' => $township->country_id,
					'id_state' => $township->state_id,
					'cologne' => $township_suburbs
				);

				array_push($district_towns, $town);
			endforeach;

			array_push($state_districts, array(
				'id' => $district->id,
				'name' => $district->name,
				'id_country' => $district->country_id,
				'id_state' => $district->state_id,
				'town' => $district_towns
			));

		endforeach;

		$state_array = array(
			'id' => $state->id,
			'name' => $state->name,
			'id_country' => $state->country_id,
			'district' => $state_districts
		);

		array_push($data_array, $state_array);
	endforeach;

	return array(
		'states' => $data_array
	);

});

Route::post('/ws-content/json/ws-cologne', function(){

	$data = Input::get('data');

	$data_decoded = json_decode($data);

	$suburbs = Suburb::where('country_id', '=', $data_decoded->id_country)->get();

	$suburbs_array = array();

	foreach($suburbs as $suburb):
		array_push($suburbs_array, array(
			'id' => $suburb->id,
			'name' => $suburb->name,
			'id_country' => $suburb->country_id,
			'id_state' => $suburb->state_id,
			'id_district' => $suburb->district_id,
			'id_town' => $suburb->township_id
		));
	endforeach;

	return array(
		'cologne' => $suburbs_array
	);

});

Route::post('/ws-content/json/ws-register', function(){

	$data = Input::get('data');

	$data_decoded = json_decode($data);

	$suburb = new Suburb;

	$suburb->name = $data_decoded->name;
	$suburb->country_id = $data_decoded->id_country;
	$suburb->state_id = $data_decoded->id_state;
	$suburb->district_id = $data_decoded->id_district;
	$suburb->township_id = $data_decoded->id_town;

	$suburb->save();

	return array(
		'code' => 1,
		'cologne' => $suburb->toArray()
	);

});

Route::get('/hash', function(){
	return Hash::make('password123');
});