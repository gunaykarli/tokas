@extends('ralewayLayouts.master')

<!-- Page Header is yielded in the header.blade.php-->
@section('pageHeader')
	<!-- Begin Page Header -->
	<div class="header">
		<div class="container">
			<div class="row">
				<!-- Page Title -->
				<div class="col-sm-6 col-xs-12">
					<h1>Services</h1>
				</div>

				<!-- Breadcrumbs -->
				<div class="col-sm-6">
					<ol class="breadcrumb">
						<li><span class="ion-home breadcrumb-home"></span><a href="/home">Home</a></li>
						<li>Pages</li>
						<li>Services</li>
					</ol>
				</div><!-- /column -->
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /page header -->
	<!-- End Page Header -->
@endsection

@section ('content')
	<!-- Begin Content Section -->
	<section class="mt40 mb30">
		<div class="container">

			<p class="lead text-center">The <b><mark>Goods</mark></b></p>

			<hr class="double-hr" style="width:400px">

			<!-- Begin Services Row 1 -->
			<div class="row">
				<!-- Content 1 -->
				<div class="col-sm-4 text-center">
					<span class="ion-beaker bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We do parallax.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
				<!-- Content 2 -->
				<div class="col-sm-4 text-center mt20-xs">
					<span class="ion-beer bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We do animations.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
				<!-- Content 3 -->
				<div class="col-sm-4 text-center mt20-xs">
					<span class="ion-help-buoy bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We do responsive.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
			</div><!-- /row -->
			<!-- End Services Row 1 -->

			<!-- Begin Services Row 2 -->
			<div class="row mt15">
				<!-- Content 1 -->
				<div class="col-sm-4 text-center mt15-xs">
					<span class="ion-android-lightbulb bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We like a ideas.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
				<!-- Content 2 -->
				<div class="col-sm-4 text-center mt20-xs">
					<span class="ion-android-star bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We have starships.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
				<!-- Content 3 -->
				<div class="col-sm-4 text-center mt20-xs">
					<span class="ion-code-working bordered-icon-sm zoomIn-animated"></span>
					<h4 class="pt15">We love coding.</h4>
					<p class="p15xs">Lorem ipsum dolor sit amet, consec tetur adipiscing elit. Integer a elit turpis. Phasellus non varius mi. Nam bibendum in mauris at sollicitudin lacinia.</p>
				</div>
			</div><!-- /row -->
			<!-- End Services Row 2 -->

		</div><!-- /container -->
	</section><!-- /section -->
	<!-- End Members -->

	<!-- Begin Content Section -->
	<section class="background-light-grey border-top">
		<div class="container">

			<div class="row mt40 mb40">

				<!-- Begin Carousel -->
				<div class="col-sm-4">
					<div id="aboutCarousel" class="carousel carousel-fade slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#aboutCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#aboutCarousel" data-slide-to="1"></li>
							<li data-target="#aboutCarousel" data-slide-to="2"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<div style="background-image:url('images/backgrounds/stock4.jpg'); height:255px;" data-0="background-position: 50% 0px;" data-500="background-position: 50% -70px;"></div>
							</div>
							<div class="item">
								<div style="background-image:url('images/backgrounds/stock5.jpg'); height:255px" data-0="background-position: 50% 0px;" data-500="background-position: 50% -70px;"></div>
							</div>
							<div class="item">
								<div style="background-image:url('images/backgrounds/stock6.jpg'); height:255px" data-0="background-position: 50% 0px;" data-500="background-position: 50% -70px;"></div>
							</div>
						</div>

						<!-- Controls -->
						<a class="left carousel-control" href="#aboutCarousel" data-slide="prev">
							<span class="ion-ios7-arrow-left carousel-arrow-left no-lineheight"></span>
						</a>
						<a class="right carousel-control" href="#aboutCarousel" data-slide="next">
							<span class="ion-ios7-arrow-right carousel-arrow-right no-lineheight"></span>
						</a>
					</div><!-- /carousel -->
				</div><!-- /column -->
				<!-- End Carousel -->

				<!-- Content 1 -->
				<div class="col-sm-8 mt30-xs">
					<div class="heading"><h4>The Illustration</h4></div>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu risus libero. Donec et lorem lacinia, adipiscing nunc nec, hendrerit sapien. Sed in scelerisque tortor. Praesent porttitor odio non ullamcorper gravida.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu risus libero. Donec et lorem lacinisent porttitor odio non ullamcorper gravida.</p>
					<!-- List -->
					<ul class="list-arrow mt10">
						<li><small>Etiam mollis pharetra adipiscing. Etiam porta in sem vitae suscipit. </small></li>
						<li><small>Consectetur adipiscing elit. Maecenas tempsam suscipit sagittis vestibulum.</small></li>
						<li><small>Nulla volutpat aliquam velit</small></li>
						<li><small>Faucibus porta lacus fringilla vel</small></li>
					</ul>
				</div><!-- /column -->
				<!-- End Content 1 -->

			</div><!-- /row -->

		</div><!-- /container -->
	</section><!-- /section -->
	<!-- End Content Section -->

	<!-- Begin Clients -->
	<section class="border-top pt40 mb40">
		<div class="container">

			<div class="heading mb30 text-center"><h4><span class="ion-android-social-user mr15"></span>The Clients</h4></div>

			<!-- Begin We Are Dedicated -->
			<div class="row mb20">
				<div class="col-sm-12">
					<p class="lead mb10" data-sr="enter right over .8s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu risus libero. Donec et lorem lacinia, adipiscing.</p>
					<p data-sr="enter right over 1s">Praesent porttitor odio non ullamcorper gravida. Donec bibendum risus risus, eu luctus mauris ullamcorper sagittis. Cras pretium pretium ligula, a adipiscing metus facilisis ac. Etiam ut orci a tortor tincidunt sollicitudin. Ut malesuada gravida enim in condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet vulputate arcu, eu pulvinar neque. Aliquam erat volutpat. Aenean euismod nisl sed justo pharetra, et pretium mauris porttitor. Mauris luctus justo eget tempus ornare. Pellentesque vitae sollicitudin ante.</p>
				</div>
			</div>
			<!-- End We Are Dedicated -->

			<div class="row">
				<!-- Client 1 -->
				<div class="col-sm-2 col-xs-4 mb30-xs" data-sr="enter left" >
					<a href="#"><img src="images/logos/boomerang.png" class="img-responsive clients-img" alt="Client 1"></a>
				</div>

				<!-- Client 2 -->
				<div class="col-sm-2 col-xs-4 mb30-xs" data-sr="enter left">
					<a href="#"><img src="images/logos/backlight.png" class="img-responsive clients-img" alt="Client 2"></a>
				</div>

				<!-- Client 3 -->
				<div class="col-sm-2 col-xs-4 mb30-xs" data-sr="enter left">
					<a href="#"><img src="images/logos/equi.png" class="img-responsive clients-img" alt="Client 3"></a>
				</div>

				<!-- Client 4 -->
				<div class="col-sm-2 col-xs-4" data-sr="enter left">
					<a href="#"><img src="images/logos/ome.png" class="img-responsive clients-img" alt="Client 4"></a>
				</div>

				<!-- Client 5 -->
				<div class="col-sm-2 col-xs-4" data-sr="enter left">
					<a href="#"><img src="images/logos/euro.png" class="img-responsive clients-img" alt="Client 5"></a>
				</div>

				<!-- Client 6 -->
				<div class="col-sm-2 col-xs-4" data-sr="enter left">
					<a href="#"><img src="images/logos/micro.png" class="img-responsive clients-img" alt="Client 6"></a>
				</div>
			</div><!-- /row -->

		</div><!-- /container -->
	</section><!-- /section -->
	<!-- End Clients -->
@endsection

@section ('pageVendorsAndScripts')

@endsection