<?php

class P4PController extends \BaseController {

    public function getP4Pindex(){

        return View::make('Prog4/index');

    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $projects = P4Project::orderBy('id', 'DESC')->get();
        return $projects;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        // todo Validation
        $project = P4Project::create(array(
            'title' => Input::get('title'),
            'student' => Input::get('student'),
            'done' => 0
        ));

        if($project){
            return $project->id;
        }
        else {
            return Response::json(['message'=>'Error while adding new user']);
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $project = P4Project::find($id);

        if($project){
            return $project;
        }
        else {
            return Response::json(['message'=>'Invalid project number']);
        }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $input = Input::get('done');
        $project = P4Project::find($id);

        if(!$project)
            return false;

        $project->done = $input;
        $project->save();

        if($project)
            return $project->id;
        else
            return 0;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $project = P4Project::find($id);

        if(!$project)
            return false;

        $project->delete();
	}


}
