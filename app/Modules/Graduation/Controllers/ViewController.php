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

class ViewController extends Controller
{

	/**
	 * Show the list of students with exams.
	 *
	 * @return Response
	 */

    public function index()
    {
    	$students = Student::select('id', 'name as title', 'work_title', 'professor_id', 'exam_id', 'degree_id')
    		->where('deleted_on', 1)
    		->with('professor', 'exam', 'degree')
    		->get();
        return view('Graduation::index', [
        	'students' => $students
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
     * Store a new student post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function newPost(Request $request)
    {
    	$validatedData = $request->validate([
    		'name' => 'required|max:100',
    		'work' => 'required',
    		'professor' => 'required',
    		'degree' => 'required',
    		'exam' => 'required',
    	]);

//     	$input = $request->all();
//     	$user = Student;
		$record = [];
		$record['name'] = Input::get('name');
    	$record['work_title'] = Input::get('work');
		$record['exam_id'] = Input::get('exam');
    	$record['degree_id'] = Input::get('degree');
		$record['professor_id'] = Input::get('professor');
//     	$user->save();

//     	$input = $request->all();

		Student::create($record);
    	return redirect( route('graduation') );


//     	$validator = Validator::make($request->all(), [
//     					'title' => 'required|unique:posts|max:255',
//     					'body' => 'required',
//     	]);

//     	if ($validator->fails()) {
//     		return redirect('post/create')
//     		->withErrors($validator)
//     		->withInput();
//     	}

//     	use Illuminate\Validation\Rule;

//     	Validator::make($data, [
//     		'email' => [
//     			'required',
//     			Rule::exists('staff')->where(function ($query) {
//     				$query->where('account_id', 1);
//     			}),
//     		],
//     	]);
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
    	$validatedData = $request->validate([
    		'name' => 'required|max:100',
    		'work' => 'required',
    		'professor' => 'required',
    		'degree' => 'required',
    		'exam' => 'required',
    	]);

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
//     	$validatedData = $request->validate([
//     					'id' => 'required',
//     					'work' => 'required',
//     					'professor' => 'required',
//     					'degree' => 'required',
//     					'exam' => 'required',
//     	]);

    	$record = Student::where([ ['deleted_on', 1],['id', $id] ])->first();
    	$record['deleted_on'] = date_format(new \DateTime(),"Y-m-d H:i:s");
    	$record->save();

    	return redirect()->back();
    }

    public function searchFriends($user_id = null)
    {
//         $user = User::select('user_id as id', 'real_name as title', 'country as country_id')
//         ->where('user_id', $user_id)
//         ->with('country', 'friends', 'friends2')
//         ->first();

//         $suggestedFriends = [];
//         if ($user) {
//             $userFriends1 = $this->array_value_recursive('fr1', $user['friends2']->toArray());
//             $userFriends2 = $this->array_value_recursive('fr2', $user['friends']->toArray());
//             $userFriends = [];
//             if (count($userFriends1) && count($userFriends2)) {
//                 $userFriends = array_merge($userFriends1, $userFriends2);
//             } elseif (count($userFriends1)) {
//                 $userFriends = $userFriends1;
//             } elseif (count($userFriends2)) {
//                 $userFriends = $userFriends2;
//             }

//             $suggestedFriends = User::select('user_id as id', 'real_name as title', 'country as country_id')
//             ->where([
//                 ['country', 1],
//                 ['user_id', '<>', $user_id]
//             ])
//             ->whereNotIn('user_id', $userFriends)
//             ->orderBy('real_name', 'asc')
//             ->paginate(25);
//         }
//         return view('Graduation::searchFriends', [
//                         'friends' => $suggestedFriends,
//                         'user' => $user
//         ]);
    }

    public function toSelect(array $arr)
    {
    	$transformedArr = [ '' => 'Please Choose' ];
    	foreach ($arr as $arrV) {
    		$transformedArr[$arrV['id']] = $arrV['title'];
    	}
    	return $transformedArr;
    }

    public function array_value_recursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val) {
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }
}
