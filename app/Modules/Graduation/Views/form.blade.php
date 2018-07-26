@include('components.header', ['head' => [ 'title' => 'University-Graduation' ]])
<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
	   	<li style="background-image: url('/css/images/img_bg_3.jpg');">
	   		<div class="overlay-gradient"></div>
	   		<div class="container-fluids">
	   			<div class="row">
		   			<div class="col-md-6 col-md-offset-3 slider-text slider-text-bg">
		   				<div class="slider-text-inner text-center">
							<h1>{{ $formTitle }}</h1>
		   				</div>
		   			</div>
		   		</div>
	   		</div>
	   	</li>
	  	</ul>
  	</div>
</aside>
<div class="clear"></div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(isset($student))
    {{ Form::model($student, ['route' => ['graduationEdit', $student['id']], 'method' => 'patch', 'class' => 'pad_20']) }}
@else
    {{ Form::open(['route' => 'graduationNew', 'method' => 'post', 'class' => 'pad_20']) }}
@endif
{!! Form::token() !!}
<div class="row">
	<div class="form-group col-md-6">
	    {!! Form::label('name', 'Your Name:') !!}
	    {!! Form::text('name', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group col-md-6">
	    {!! Form::label('work', 'Work Title:') !!}
	    {!! Form::text('work', null, ['class' => 'form-control']) !!}
	</div>
</div>
<div class="row">
	<div class="form-group col-md-4">
	    {!! Form::label('exam', 'Exam:') !!}
	    {!! Form::select('exam', $form['exam'], null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group col-md-4">
	    {!! Form::label('degree', 'Degree:') !!}
	    {!! Form::select('degree', $form['degree'], null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group col-md-4">
	    {!! Form::label('professor', 'Professor:') !!}
	    {!! Form::select('professor', $form['professor'], null, ['class' => 'form-control']) !!}
	</div>
</div>

{!! Form::submit('Add Graduation', ['class' => 'btn btn-info']) !!}

{!! Form::close() !!}
@include('components.footer')