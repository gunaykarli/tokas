<!DOCTYPE html>

<html lang="en">

	@include ('partials.head')

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside-left-offcanvas-default">


		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			@include ('partials.header')

			@include ('partials.body') <!-- body has "include ('partials.sidebar')" and "yield ('content')" -->

			@include ('partials.footer')

		</div>
		<!-- end:: Page -->

		@include ('partials.foot')

		@yield ('pageVendorsAndScripts')


	</body>
	<!-- end::Body -->

</html>