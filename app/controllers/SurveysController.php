<?php
	
class SurveysController extends BaseController
{

	public function index($id_questionary)
	{
            return View::make('admin.questionary.index')
                    ->with('section', 'Selección de Encuestas')
                    ->with('questionaries', Questionary::find($id_questionary));
	}
        
        public function view_surveys($id_survey)
        {
            $surveys = QuestionaryMade::where('questionary_id', '=', $id_survey)
                    ->get();
            return View::make('admin.surveys.index')
                    ->with('section', 'Encuestas de ')
                    ->with('surveys', $surveys);
        }

	public function create()
	{
            return View::make('admin.users.form')
                    ->with('section', 'Nuevo Usuario')
                    ->with('action', 'save-create')
                    ->with('user', new User)
                    ->with('user_type', UserType::all());
	}

	public function save_create()
	{

		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'patern_name' => 'required',
				'matern_name' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed',
                                'user_type' => 'required'
			)
		);

		if($validator->fails())
		{
			return Redirect::to('/admin/users/create')->withInput()->withErrors($validator);
		}

		$user = new User;

		$user->name = Input::get('name');
		$user->patern_name = Input::get('patern_name');
		$user->matern_name = Input::get('matern_name');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->active = 1;
                $user->user_type = Input::get('user_type');

		$user->save();

		return Redirect::to('/admin/users')->with('message', array(
			'type' => 'success',
			'message' => 'Usuario creado.'
		));
	}

	public function update($id)
	{
		return View::make('admin.users.form')
			->with('section', 'Modificar Usuario')
			->with('action', 'save-update')
			->with('user', User::find($id))
                        ->with('user_type', UserType::all());
	}

	public function save_update()
	{

		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'patern_name' => 'required',
				'matern_name' => 'required',
				'email' => 'required|email',
				'password' => 'required|confirmed'
			)
		);

		if($validator->fails())
		{
			return Redirect::to('/admin/users/update/'.Input::get('id'))->withInput()->withErrors($validator);
		}

		$user = User::find(Input::get('id'));

		$user->name = Input::get('name');
		$user->patern_name = Input::get('patern_name');
		$user->matern_name = Input::get('matern_name');
		$user->email = Input::get('email');
		
		if(Input::get('password'))
			$user->password = Hash::make(Input::get('password'));

		$user->active = 1;

		$user->save();

		return Redirect::to('/admin/users')->with('message', array(
			'type' => 'success',
			'message' => 'Usuario modificado.'
		));
	}

	public function details($id)
	{
            $users = User::find($id);
            $user_type = UserType::find($users->user_type);
		return View::make('admin.users.view')
			->with('section', 'Detalle de Usuario')
			->with('user', $users)
                        ->with('user_type', $user_type)
                ;
	}

	public function delete($id)
	{
		return View::make('admin.users.delete')
			->with('section', 'Eliminar Usuario')
			->with('user', User::find($id));
	}

	public function delete_user()
	{
		$user = User::find(Input::get('id'));

		$user->active = 0;
		$user->save();

		return Redirect::to('/admin/users')->with('message', array(
			'type' => 'success',
			'message' => 'Usuario eliminado.'
		));
	}

	public function profile()
	{
		return View::make('admin.users.profile')
			->with('section', 'Perfil')
			->with('user', Auth::user());
	}

	public function save_profile()
	{

		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'patern_name' => 'required',
				'matern_name' => 'required',
				'email' => 'required|email',
				'password' => 'confirmed'
			)
		);

		if($validator->fails())
		{
			return Redirect::to('/admin/profile')->withInput()->withErrors($validator);
		}

		$user = Auth::user();

		$user->name = Input::get('name');
		$user->patern_name = Input::get('patern_name');
		$user->matern_name = Input::get('matern_name');
		$user->email = Input::get('email');
		
		if(Input::get('password'))
			$user->password = Hash::make(Input::get('password'));

		$user->active = 1;

		$user->save();

		return Redirect::to('/admin/profile')->with('message', array(
			'type' => 'success',
			'message' => 'Perfil actualizado.'
		));
	}

}