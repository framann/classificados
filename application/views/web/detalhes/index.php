<?php $this->load->view('web/layout/navbar'); ?>


<div class="section-padding">
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumb-wrapper">
					<ol class="breadcrumb bg-white">
						<li><a href="<?php echo base_url('/'); ?>">Home&nbsp;/&nbsp;</a></li>
						<li><a href="<?php echo base_url('busca/estado/' . $anuncio->anuncio_estado); ?>">&nbsp;<?php echo $anuncio->anuncio_estado; ?>&nbsp;/&nbsp;</a></li>
						<li><a href="<?php echo base_url('busca/cidade/' . $anuncio->anuncio_cidade_meta_link); ?>">&nbsp;<?php echo $anuncio->anuncio_cidade; ?>&nbsp;/&nbsp;</a></li>
						<li><a href="<?php echo base_url('busca/master/' . $anuncio->categoria_pai_meta_link); ?>">&nbsp;<?php echo $anuncio->categoria_pai_nome; ?>&nbsp;/&nbsp;</a></li>

						<li class="current"><a href="<?php echo base_url('busca/categoria/' . $anuncio->categoria_meta_link); ?>">&nbsp;<?php echo $anuncio->categoria_nome; ?></a></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="product-info row">
			<div class="col-lg-8 col-md-12 col-xs-12">
				<div class="ads-details-wrapper">
					<div id="owl-demo" class="owl-carousel owl-theme">

						<?php foreach ($anuncios_fotos as $foto): ?>

							<div class="item">
								<div class="product-img text-center">

									<img class="img-fluid" style="max-height: 400px" src="<?php echo base_url('uploads/anuncios/' . $foto->foto_nome); ?>" alt="<?php echo $anuncio->anuncio_titulo; ?>">

								</div>
								<span class="<?php echo ($anuncio->anuncio_preco > 0 ? 'price' : ''); ?>"><?php echo ($anuncio->anuncio_preco > 0 ? 'R$ ' . number_format($anuncio->anuncio_preco, 2) : ''); ?></span>
							</div>

						<?php endforeach; ?>
					</div>
				</div>
				<div class="details-box">
					<div class="ads-details-info">
						<h2><?php echo $anuncio->anuncio_titulo; ?></h2>
						<div class="details-meta">
							<span><i class="lni-alarm-clock"></i> <?php echo formata_data_banco_com_hora($anuncio->anuncio_data_criacao); ?></span>
							<span><i class="lni-map-marker"></i> CEP <?php echo $anuncio->anuncio_localizacao_cep . ', ' . $anuncio->anuncio_logradouro . ', '. $anuncio->anuncio_cidade . ' - '. $anuncio->anuncio_estado; ?></span>
						</div>
					</div>
					<div class="tag-bottom">
						<div class="float-left">
							<ul class="advertisement">
								<li>
									<p><strong><i class="lni-folder"></i> Categorias:</strong> 
										<a href="<?php echo base_url('busca/master/' . $anuncio->categoria_pai_meta_link); ?>"><?php echo $anuncio->categoria_pai_nome; ?></a></p>
									    &
									    <a href="<?php echo base_url('busca/categoria/' . $anuncio->categoria_meta_link); ?>"><?php echo $anuncio->categoria_pai_nome; ?></a>
									</p>
								</li>
								<li>
									<p><strong><i class="lni-archive"></i> Condição:</strong> <?php echo ($anuncio->anuncio_situacao == 1 ? 'Novo' : 'Usado'); ?></p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-xs-12">

				<aside class="details-sidebar">
					<div class="widget">
						<h4 class="widget-title">Anunciante</h4>
						<div class="agent-inner">
							<div class="agent-title">
								<div class="agent-photo">
									<img src="<?php echo base_url('uploads/uauarios/small' . $anuncio->user_foto);  ?>" alt="<?php echo $anuncio->nome_anunciante; ?>">
								<div class="agent-details">
									<h3><?php echo $anuncio->nome_anunciante; ?></h3>
									<span><i class="ini-alarm-clock"></i>Desde:&nbsp<?php date('d/m/y'. strtotime($anuncio->anunciante_desde)); ?> </span>
								</div>
							</div>
						</div>
					</div>

					<div class="widget">
						<h4 class="widget-title">Todos os anuncios de <?php echo $anuncio->nome_anunciante; ?></h4>
						<ul class="posts-list">

							<?php foreach ($todos_anuncios_anunciante as $anuncio):  ?>

							<li>
								<div class="widget-thumb">
									<a href="<?php echo base_url('detalhes'/ . $anuncio->anuncio_codigo); ?>">< style="max-width: 30px" img src="<?php echo base_url('uploads/anuncios/small/'. $anuncio->foto_nome); ?>" alt="<?php $anuncio->anuncio_titulo; ?>" /></a>
								</div>
								<div class="widget-content">
									<h4><a href="<?php echo base_url('detalhes'/ . $anuncio->anuncio_codigo); ?>"><?php $anuncio->anuncio_titulo; ?></a></h4>
									<div class="meta-tag">
										<span>
											<i class="lni-user"></i> <i class="lni-user"></i> <?php echo $anuncio->first_name .' ' . $anuncio->last_name; ?>
										</span>
										<span>
											<a href="#"><i class="lni-map-marker"></i> <i class="lni-map-marker"></i> <?php echo $anuncio->anuncio_bairro . ', ' . $anuncio->anuncio_cidade . ' - ' . $anuncio->anuncio_estado; ?></a>
										</span>
									</div>
									<h4 class="price"><?php echo ($anuncio->anuncio_preco > 0 ? 'R$' . number_format($anuncio->anuncio_preco, 2) : ''); ?></h4>
								</div>
								<div class="clearfix"></div>
							</li>

                            <?php endforeach; ?>
						</ul>
					</div>
				</aside>

			</div>
		</div>

	</div>
</div>