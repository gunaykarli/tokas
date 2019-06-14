<!DOCTYPE html>

<html lang="en">

	@include ('layouts.head')

	<body class="royal_preloader scrollreveal">

		<div id="royal_preloader"></div>

			<!-- Begin Boxed or Fullwidth Layout -->
			<div id="bg-boxed">
				<div class="boxed">

					<!-- Begin Header -->
					@include ('layouts.header')
					<!-- End Header -->

					<!-- Begin Content Section -->
					<section class="content-bordered background-light-grey pt40 pb40">

						<div class="container">

							@yield ('content')

						</div><!-- /container -->

					</section><!-- /section -->
					<!-- End Content Section -->

					<!-- Begin Footer -->
					@include ('layouts.footer')
					<!-- End Footer -->

				</div><!-- /boxed -->
			</div><!-- /bg boxed-->
			<!-- End Boxed or Fullwidth Layout -->

		<!--  layouts.foot -->
		@include ('layouts.foot')

		@yield ('pageVendorsAndScripts')

	</body>
</html>