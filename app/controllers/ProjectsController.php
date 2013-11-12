<?php
	
class ProjectsController extends BaseController
{

	public function index()
	{
            return View::make('admin.projects.index')
                    ->with('section', 'Selección de Proyectos')
                    ->with('projects', Project::all());
	}
        
        public function view_projects($id_survey)
        {
            $users = User::where('active', '=', 1)
                    ->select('users.*', 'users_type.description')
                    ->join('users_type', 'users.user_type', '=', 'users_type.id')
                    ->get();
            return View::make('admin.index-surveys.blade.php')
                    ->with('section', 'Encuestas de ')
                    ->with('projects', Project::all());
        }

}