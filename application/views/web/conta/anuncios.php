<?php $this->load->view('web/layout/navbar'); ?>


<div id="content" class="section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
				
				<?php $this->load->view('web/conta/sidebar'); ?>


			</div>

			<?php if (isset($anuncios)): ?>


			<div class="col-sm-12 col-md-8 col-lg-9">

				<?php if ($mensagem = $this->session->flashdata('sucesso')): ?>

					<div class="alert alert-success bg-success text-white alert-dismissible show fade">
						<div class="alert-body" style="color: white ! important">
							<button class="close" data-dismiss="alert">
								<span>&times;</span>
							</button>
							<?php echo $mensagem; ?>
						</div>
					</div>

				<?php endif; ?>


				<?php if($mensagem = $this->session->flashdata('erro')): ?>

					<div class="alert alert-danger bg-danger text-white alert-dismissible show fade">
						<div class="alert-body" style="color: white !important">
							<button class="close" data-dismiss="alert">
								<span>&times;</span>
							</button>
							<?php echo $mensagem; ?>
						</div>
					</div>

				<?php endif; ?>

				<div class="page-content">
					<div class="inner-box">
						<div class="dashboard-box">
							<h2 class="dashbord-title"><?php echo $titulo; ?></h2>
							<a class="btn btn-common log-btn float-right" href="<?php echo base_url($this->router->fetch_class() . '/core/'); ?>">Novo anúncio</a>
						</div>
						<div class="dashboard-wrapper">
							<table class="table table-responsive dashboardtable table-anuncios">
								<thead>
									<tr>
										<th>Imagem</th>
										<th>Titulo</th>
										<th>Categorias</th>
										<th>Preço</th>
										<th>Publicado</th>
										<th class="nosort">Ações</th>
									</tr>
								</thead>
								<tbody>

									<?php foreach ($anuncios as $anuncio): ?>

									<tr data-category="active">

										<td class="photo"><img class="img-fluid" src="<?php echo base_url('uploads/anuncios/small/' . $anuncio->foto_nome); ?>" alt="<?php echo $anuncio->anuncio_titulo; ?>"></td>

										<td data-title="Title">
											<h3><?php echo word_limiter($anuncio->anuncio_titulo, 5); ?></h3>
										</td>

										<td data-title="Category"><span class="adcategories"><?php echo $anuncio->categoria_pai_nome . ' & ' . $anuncio->categoria_nome; ?></span></td>

										<td data-title="Price">
											<h3>R$&nbsp;<?php echo number_format($anuncio->anuncio_preco, 2);  ?></h3>
										</td>

										<td data-title="Ad Status"><?php echo ($anuncio->anuncio_publicado == 1 ? '<span class="adstatus adstatusactive">Sim</span>' : '<span class="adstatus adstatusexpired">Não</span>'); ?></td>
										
										<td data-title="Action">
											<div class="btns-actions">
												<a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
												<a class="btn-action btn-edit" href="<?php echo base_url($this->router->fetch_class() . '/core/' . $anuncio->anuncio_id); ?>"><i class="lni-pencil"></i></a>
												<a class="btn-action btn-delete delete" href="<?php echo base_url($this->router->fetch_class() . 'conta/delete/' . $anuncio->anuncio_id); ?>" data-confirm="Tem certeza da exclusão do registro?"><i class="lni-trash"></i></a>
											</div>
										</td>
									</tr>


								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>




			<?php else: ?>


				<div class="col-md-9">

					<div class="container text-center">

						<h3 class="mb-5">Voçe não tem anuncios cadastrados</h3>

				        <img width="300" src="<?php echo base_url('public/web/assets/img/sem_anuncios.svg'); ?>">


						
					</div>


					<div class="container text-center mt-5">

						<a class="btn btn-common log-btn" href="<?php echo base_url($this->router->fetch_class() . '/core/'); ?>">Novo anúncio</a>
		
					</div>
					

				</div>

			<?php endif; ?>

	

		</div>
	</div>
</div>

