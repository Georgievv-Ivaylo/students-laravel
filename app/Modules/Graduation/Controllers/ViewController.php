<?php

namespace app\Modules\Graduation\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use app\Modules\Graduation\Models\Degree;
use app\Modules\Graduation\Models\Student;
use app\Modules\Graduation\Models\Exam;
use app\Modules\Graduation\Models\Professor;
use app\Modules\Graduation\Requests\Validation;

class ViewController extends Controller
{
	const TO_SORT = [
		'1' => 'title',
		'2' => 'work_title',
		'3' => 'examName',
		'4' => 'degreeName',
		'5' => 'professorName',
	];

	/**
	 * Show the list of students with exams.
	 *
     * @param  Request  $request
	 * @return Response
	 */

	public function index(Request $request)
    {
    	$order = $request->input('order');
    	$orderBy = 'title';
    	if ($order && !empty(self::TO_SORT[$order]) ) $orderBy = self::TO_SORT[$order];

    	$students = Student::select(
	    		'students.id', 'students.name as title', 'students.work_title',
    			'students.professor_id', 'students.exam_id', 'students.degree_id',
    			'exams.name as examName', 'degrees.name as degreeName', 'professors.name as professorName'
	    	)
	    	->leftJoin('exams', 'students.exam_id', '=', 'exams.id')
	    	->leftJoin('degrees', 'students.degree_id', '=', 'degrees.id')
	    	->leftJoin('professors', 'students.professor_id', '=', 'professors.id')
	    	->where('students.deleted_on', '1')
	    	->orderBy($orderBy)
    		->paginate(5);

        return view('Graduation::index', [
        	'students' => $students->appends(Input::except('page'))
        ]);
    }

    /**
     * Show the form to create a new student post.
     *
     * @return Response
     */

    public function new()
    {
    	$form = [];
    	$form['degree'] = $this->toSelect(
    		Degree::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['exam'] = $this->toSelect(
    		Exam::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['professor'] = $this->toSelect(
    		Professor::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);

    	return view('Graduation::form', [
    		'formTitle' => 'Add Graduation Exam',
			'form' => $form
    	]);
    }

    /**
     * Set validation data.
     *
     * @return Response
     */

    public function validationForm()
    {
    	$form = [];
    	$form['formRules']['degree'] = $this->toValidationSelect(
    		Degree::select('id')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['formRules']['exam'] = $this->toValidationSelect(
    		Exam::select('id')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['formRules']['professor'] = $this->toValidationSelect(
    		Professor::select('id')->where('deleted_on', 1)->get()->toArray()
    	);

    	return json_encode($form);
    }

    /**
     * Store a new student post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function newPost(Request $request)
    {
    	$validation = new Validation();
    	$validatedData = $this->validate($request, $validation->rules(), $validation->messages());

		$record = [];
		$record['name'] = Input::get('name');
    	$record['work_title'] = Input::get('work');
		$record['exam_id'] = Input::get('exam');
    	$record['degree_id'] = Input::get('degree');
		$record['professor_id'] = Input::get('professor');

		Student::create($record);
    	return redirect( route('graduation') );
    }

    public function edit($id = null)
    {
    	$student = Student::select('id', 'name', 'work_title as work', 'professor_id as professor', 'exam_id as exam', 'degree_id as degree')
    	->where([
    		['deleted_on', 1],
    		['id', $id]
    	])
    	->with('professor', 'exam', 'degree')
    	->first();

    	$form = [];
    	$form['degree'] = $this->toSelect(
    	Degree::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['exam'] = $this->toSelect(
    	Exam::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);
    	$form['professor'] = $this->toSelect(
    	Professor::select('id', 'name as title')->where('deleted_on', 1)->get()->toArray()
    	);
    	return view('Graduation::form', [
    		'formTitle' => 'Edit Graduation Exam',
    		'form' => $form,
    		'student' => $student
    	]);
    }

    /**
     * Edit student.
     *
     * @param  Request  $request
     * @return Response
     */
    public function editPatch(Request $request, $id = null)
    {
    	$validation = new Validation();
    	$validatedData = $this->validate($request, $validation->rules(), $validation->messages());

    	$record = Student::where([ ['deleted_on', 1],['id', $id] ])->first();
    	$record['name'] = Input::get('name');
    	$record['work_title'] = Input::get('work');
    	$record['exam_id'] = Input::get('exam');
    	$record['degree_id'] = Input::get('degree');
    	$record['professor_id'] = Input::get('professor');
    	$record->save();

    	return redirect( route('graduation') );
    }

    /**
     * Delete student.
     *
     * @param  Request  $request
     * @return Response
     */
    public function editDelete(Request $request, $id = null)
    {

    	$record = Student::where([ ['deleted_on', 1],['id', $id] ])->first();
    	$record['deleted_on'] = date_format(new \DateTime(),"Y-m-d H:i:s");
    	$record->save();

    	return redirect()->back();
    }

    public function toSelect(array $arr)
    {
    	$transformedArr = [ '' => 'Please Choose' ];
    	foreach ($arr as $arrV) {
    		$transformedArr[$arrV['id']] = $arrV['title'];
    	}
    	return $transformedArr;
    }

    public function toValidationSelect(array $arr)
    {
    	$transformedArr = [ 'values' => [] ];
    	foreach ($arr as $arrV) {
    		$transformedArr['values'][$arrV['id']] = $arrV['id'];
    	}
    	return $transformedArr;
    }
}
