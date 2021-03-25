<header id="header-wrap">

	<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-5 col-xs-12">

					<ul class="list-inline">
						<li><i class="lni-phone"></i> +0123 456 789</li>
						<li><i class="lni-envelope"></i> <a href="http://preview.uideck.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3d4e484d4d524f497d5a505c5451135e5250">[email&#160;protected]</a></li>
					</ul>

				</div>
				<div class="col-lg-5 col-md-7 col-xs-12">
					<div class="header-top-right float-right">

						<?php $logado = $this->ion_auth->logged_in(); ?>

						<?php if (!$logado): ?>

							<a href="<?php echo base_url('login'); ?>" class="header-top-button"><i class="lni-lock"></i> Log In</a> |

						<?php else: ?>


							<?php $anunciante = $this->ion_auth->user()->row(); ?>


								<a href="<?php echo base_url('login/logout'); ?>" class="header-top-button"><i class="lni-shift-left"></i> Sair</a> |

								<a title="ola <?php echo $anunciante->first_name ?>, Gerenciar sua conta" href="<?php echo base_url('conta'); ?>" class="header-top-button"><img class="rounded-circle" width="30" src="<?php echo base_url('uploads/usuarios/small/' . $anunciante->user_foto); ?>"> Minha conta</a>

						<?php endif; ?>

                       
					</div>
				</div>
			</div>
		</div>
	</div>


	<nav class="navbar navbar-expand-lg bg-white fixed-top scrolling-navbar">
		<div class="container">

			<div class="navbar-header">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					<span class="lni-menu"></span>
					<span class="lni-menu"></span>
					<span class="lni-menu"></span>
				</button>
				<a href="<?php echo base_url('/'); ?>" class="navbar-brand"><img src="<?php echo base_url('public/web/assets/img/logo.PNG'); ?>" alt=""></a>
			</div>
			<div class="collapse navbar-collapse" id="main-navbar">
				<ul class="navbar-nav mr-auto w-100 justify-content-center">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Home
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="index-2.html">Home 1</a>
							<a class="dropdown-item" href="index-3.html">Home 2</a>
						</div>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="category.html">
							Categorias
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Listings
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="adlistinggrid.html">Ad Grid</a>
							<a class="dropdown-item" href="adlistinglist.html">Ad Listing</a>
							<a class="dropdown-item" href="ads-details.html">Listing Detail</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Pages
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="about.html">About Us</a>
							<a class="dropdown-item" href="services.html">Services</a>
							<a class="dropdown-item" href="ads-details.html">Ads Details</a>
							<a class="dropdown-item" href="post-ads.html">Ads Post</a>
							<a class="dropdown-item" href="pricing.html">Packages</a>
							<a class="dropdown-item" href="testimonial.html">Testimonial</a>
							<a class="dropdown-item" href="faq.html">FAQ</a>
							<a class="dropdown-item" href="404.html">404</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Blog
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="blog.html">Blog - Right Sidebar</a>
							<a class="dropdown-item" href="blog-left-sidebar.html">Blog - Left Sidebar</a>
							<a class="dropdown-item" href="blog-grid-full-width.html"> Blog full width </a>
							<a class="dropdown-item" href="single-post.html">Blog Details</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contact.html">
							Contact
						</a>
					</li>
				</ul>
				<div class="post-btn">
					<a class="btn btn-common" href="post-ads.html"><i class="lni-pencil-alt"></i> Post an Ad</a>
				</div>
			</div>
		</div>

		<ul class="mobile-menu">
			<li>
				<a href="#">
					Home
				</a>
				<ul class="dropdown">
					<li><a href="index-2.html">Home 1</a></li>
					<li><a href="index-3.html">Home 2</a></li>
				</ul>
			</li>
			<li>
				<a class="active" href="category.html">Categories</a>
			</li>
			<li>
				<a href="#">
					Listings
				</a>
				<ul class="dropdown">
					<li><a href="adlistinggrid.html">Ad Grid</a></li>
					<li><a href="adlistinglist.html">Ad Listing</a></li>
					<li><a href="ads-details.html">Listing Detail</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Pages</a>
				<ul class="dropdown">
					<li><a href="about.html">About Us</a></li>
					<li><a href="services.html">Services</a></li>
					<li><a href="ads-details.html">Ads Details</a></li>
					<li><a href="post-ads.html">Ads Post</a></li>
					<li><a href="pricing.html">Packages</a></li>
					<li><a href="testimonial.html">Testimonial</a></li>
					<li><a href="faq.html">FAQ</a></li>
					<li><a href="404.html">404</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Blog</a>
				<ul class="dropdown">
					<li><a href="blog.html">Blog - Right Sidebar</a></li>
					<li><a href="blog-left-sidebar.html">Blog - Left Sidebar</a></li>
					<li><a href="blog-grid-full-width.html"> Blog full width </a></li>
					<li><a href="single-post.html">Blog Details</a></li>
				</ul>
			</li>
			<li>
				<a href="contact.html">Contact Us</a>
			</li>
		</ul>

	</nav>


	<div id="hero-area">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 text-center">
					<div class="contents-ctg">
						<div class="search-bar">
							<div class="search-inner ui-widget">
								<form class="search-form" method="post" action="<?php echo base_url('busca'); ?>">
									<div class="form-group inputwithicon" style="width: 80%">
										<input type="text" id="busca" name="Busca" class="form-control" placeholder="O que está procurando?">
									</div>
									
									<button class="btn btn-common" type="submit"><i class="lni-search"></i> Pesquisar</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</header>