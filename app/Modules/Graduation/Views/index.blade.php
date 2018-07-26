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
							<h1>Graduations</h1>
		   				</div>
		   			</div>
		   		</div>
	   		</div>
	   	</li>
	  	</ul>
  	</div>
</aside>
<div class="fh5co-blog animate-box pad_20">
	@if (count($students))
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col" class="text-right">#</th>
	      <th scope="col">Name:</th>
	      <th scope="col">Work:</th>
	      <th scope="col">Type:</th>
	      <th scope="col">Degree:</th>
	      <th scope="col">Professor:</th>
	      <th scope="col"></th>
	    </tr>
	  </thead>
	  <tbody>
		@foreach ($students as $student)
	    <tr>
	      <th scope="row" class="text-right">{{ $loop->iteration }}</th>
	      <td>{{ $student['title'] }}</td>
	      <td>{{ $student['work_title'] }}</td>
	      <td>{{ $student['exam']['name'] }}</td>
	      <td>{{ $student['degree']['name'] }}</td>
	      <td>{{ $student['professor']['name'] }}</td>
	      <td class="text-center">
	      	<a href={{ route('graduationEdit', [ 'id' => $student['id'] ]) }} class="btn btn-sm btn-info">Edit</a>
		    {{ Form::open(['url' => route('graduationDelete', [ 'id' => $student['id'] ]), 'method' => 'put']) }}
			    {!! Form::hidden('id', $student['id']) !!}
				{!! Form::submit('Delete', ['class' => 'btn btn-sm btn-warning']) !!}
			{!! Form::close() !!}
		  </td>
		@endforeach
	  </tbody>
	</table>
	@else
	<p class="p_10">No Graduations</p>
	@endif
</div>
@include('components.footer')
