<footer>


	<section class="footer-Content">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
					<div class="widget">
						<div class="footer-logo"><img src="<?php echo base_url('public/web/assets/img/logo.png') ?>" alt=""></div>
						<div class="textwidget">
							<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt consectetur, adipisci velit.</p>
						</div>
						<ul class="mt-3 footer-social">
							<li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
							<li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
							<li><a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a></li>
							<li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
					<div class="widget">
						<h3 class="block-title">Quick Link</h3>
						<ul class="menu">
							<li><a href="#">- About Us</a></li>
							<li><a href="#">- Blog</a></li>
							<li><a href="#">- Events</a></li>
							<li><a href="#">- Shop</a></li>
							<li><a href="#">- FAQ's</a></li>
							<li><a href="#">- About Us</a></li>
							<li><a href="#">- Blog</a></li>
							<li><a href="#">- Events</a></li>
							<li><a href="#">- Shop</a></li>
							<li><a href="#">- FAQ's</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-6 col-mb-12">
					<div class="widget">
						<h3 class="block-title">Contact Info</h3>
						<ul class="contact-footer">
							<li>
								<strong><i class="lni-phone"></i></strong><span>+1 555 444 66647 <br> +1 555 444 66647</span>
							</li>
							<li>
								<strong><i class="lni-envelope"></i></strong><span><a href="http://preview.uideck.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="98fbf7f6ecf9fbecd8f5f9f1f4b6fbf7f5">[email&#160;protected]</a> <br> <a href="http://preview.uideck.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="582b2d2828372a2c1835393134763b3735">[email&#160;protected]</a></span>
							</li>
							<li>
								<strong><i class="lni-map-marker"></i></strong><span><a href="#">9870 St Vincent Place, Glasgow, DC 45 <br>Fr 45</a></span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>


	<div id="copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="site-info text-center">
						<p><a target="_blank" href="https://templateshub.net">Templates Hub</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

</footer>


<a href="#" class="back-to-top">
	<i class="lni-chevron-up"></i>
</a>

<div id="preloader">
	<div class="loader" id="loader-1"></div>
</div>


<script src="<?php echo base_url('public/web/'); ?>assets/js/jquery-min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/jquery.counterup.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/waypoints.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/wow.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/jquery.slicknav.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/main.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/form-validator.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/contact-form-script.min.js"></script>
<script src="<?php echo base_url('public/web/'); ?>assets/js/summernote.js"></script>

<script src="<?php echo base_url('public/restrita/assets/js/util.js'); ?>"></script>

<script src="<?php echo base_url('public/restrita/assets/bootbox/bootbox.min.js'); ?>"></script>

<script src="<?php echo base_url('public/web/assets/autocomplete/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('public/web/assets/autocomplete/pesquisa-ajax.js'); ?>"></script>



<?php if (isset($scripts)): ?>

	<?php foreach ($scripts as $script): ?>

		<script src="<?php echo base_url('public/restrita/' . $script); ?>"></script>

	<?php  endforeach; ?>

<?php  endif; ?>


<script>


	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});


      $('.delete').on("click", function (event) {


          event.preventDefault();


          var redirect = $(this).attr('href');

          bootbox.confirm({
            title: $(this).attr('data-confirm'),
            centerVertical: true,
            message: "<p class-'text-danger'>Esta ação não poderá ser desfeita</p>",
            buttons: {
              confirm: {
                label: 'Sim, pode excluir',
                className: 'btn-danger'
              },
              cancel: {
                label: 'Não, cancelar',
                className: 'btn-primary'
              }
            },
            callback: function (result) {
              
                if (result){
                  window.location.href = redirect;
                }

            }
          });

        });


  </script>


</body>


</html>