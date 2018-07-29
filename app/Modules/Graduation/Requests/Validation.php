<?php

namespace app\Modules\Graduation\Requests;

class Validation
{
	public function rules()
	{
		return [
			'name' => 'required|max:100',
			'work' => 'required',
			'professor' => 'required|exists:professors,id',
			'degree' => 'required|exists:degrees,id',
			'exam' => 'required|exists:exams,id',
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'The Your Name field is required!',
			'name.max' => 'The Your Name field can contain only 100 characters!',
			'work.required' => 'The Work Title field is required!',
			'professor.required' => 'The Professor field is required!',
			'professor.exists' => 'The selected Professor is invalid!',
			'degree.required' => 'The Degree field is required!',
			'degree.exists' => 'The selected Degree is invalid!',
			'exam.required' => 'The Exam field is required!',
			'exam.exists' => 'The selected Exam is invalid!',
		];
	}
}

