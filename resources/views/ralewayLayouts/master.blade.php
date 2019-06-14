<!DOCTYPE html>

<html lang="en">

	@include ('ralewayLayouts.head')

	<body class="royal_preloader scrollreveal">

		<div id="royal_preloader"></div>

		<!-- Begin Boxed or Fullwidth Layout -->
		<div id="bg-boxed">
			<div class="boxed">

				<!-- Begin Header -->
				@include ('ralewayLayouts.header')
				<!-- End Header -->

				<!-- Begin Content Section -->
				@yield ('content')
				<!-- End Content Section -->

				<!-- Begin Footer -->
				@include ('ralewayLayouts.footer')
				<!-- End Footer -->

			</div><!-- /boxed -->
		</div><!-- /bg boxed-->
		<!-- End Boxed or Fullwidth Layout -->

		<!--  layouts.foot -->
		@include ('ralewayLayouts.foot')

		@yield ('pageVendorsAndScripts')

	</body>
</html>