@extends('Layouts.master')

@section('content')


<div class="container">
					<div class="row">
						<div class="col-lg-8 offset-lg-2 text-center">
							<div class="error-text">
								<i class="far fa-sad-cry"></i>
								<h1>Oops! Not Found.</h1>
								<p>The page you requested for is not found.</p>
								<a href="{{ route('mainpage') }}" class="boxed-btn">Back to Home</a>
							</div>
						</div>
					</div>
				</div>


@endsection
