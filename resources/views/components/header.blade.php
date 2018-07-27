<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>{{ $head['title'] }}</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Oxygen:300,400" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">

		<link rel="stylesheet" href="/css/custome/animate.css">
		<link rel="stylesheet" href="/css/custome/bootstrap.css">
		<link rel="stylesheet" href="/css/custome/flexslider.css">
		<link rel="stylesheet" href="/css/custome/style.css">

    </head>
    <body>
	<div class="fh5co-loader"></div>

	<div id="page">
		<nav class="fh5co-nav" role="navigation">
			<div class="container-wrap">
				<div class="top-menu">
					<div class="row">
						<div class="col-xs-2">
							<div id="fh5co-logo"><a href={{ route('home') }}>University</a></div>
						</div>
						<div class="col-xs-10 text-right menu-1">
							<ul>
								<li class="{{ setActive( route('home', [], false) ) }}"><a href="{{ route('home') }}">Home</a></li>
								<li class="has-dropdown{{ setActiveParent( route('graduation', [], false) ) }}">
									<a href={{ route('graduation') }}>Graduation</a>
									<ul class="dropdown">
										<li><a href={{ route('graduationNew') }} class="{{ setActiveParent( route('graduationNew', [], false) ) }}">New</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</nav>
		<div class="container-wrap">