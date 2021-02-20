
<div class="main-wrapper main-wrapper-1">


<?php $this->load->view('restrita/layout/navbar'); ?>


<?php $this->load->view('restrita/layout/sidebar'); ?>


<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">

          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">

              <div class="card">
               
                  <form method="post" name="form_core">

                <div class="card-header">
                  <h4><?php echo $titulo; ?></h4>
                </div>
                <div class="card-body">

                  <form method="post" name="form_core">

                    <div class="card-body">

                      <?php if(isset($categoria)) : ?>
                       
                        <dv class="form-row">

                          <div class="form-group col-md-8">
                            <label>Meta link da categoria</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text">
                                  <i class="fas fa-link text info"></i>
                                </div>
                              </div>
                              <input type="text" class="form-control" value="<?php echo $categoria->categoria_meta_link; ?>" readonly="">
                            </div>

                          </div> 
                          

                        </div>

                      <?php endif; ?>

                    <div class="form-row">

                     <div class="form-group col-md-4">
                      <label>Nome da categoria</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-cube text info"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control" name="categoria_nome" value="<?php echo (isset($categoria) ? $categoria->categoria_nome : set_value('categoria_nome')); ?>">
                      </div>
                       <?php echo form_error('categoria_nome', '<div class="text-danger">', '</div>'); ?>
                    </div>


                    <div class="form-group col-md-4">
                    <label>Ativa</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-check-circle text-info"></i>
                        </div>
                      </div>
                      <select class="custom-select" name="categoria_ativa">

                        <?php if(isset($categoria)): ?>

                          <option value="0" <?php echo ($categoria->categoria_ativa == 0 ? 'selected' : ''); ?>>Não</option>
                          <option value="1" <?php echo ($categoria->categoria_ativa == 1 ? 'selected' : ''); ?>>Sim</option>

                          <?php else : ?>

                            <option value="0">Não</option>
                            <option value="1">Sim</option>

                          <?php endif; ?>
                        </select>
                      </div>
                    </div>


                    <div class="form-group col-md-4">
                      <label>Categoria pai</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-check-circle text-info"></i>
                          </div>
                        </div>
                        <select class="form-control select2" name="categoria_pai_id">


                            <option value="">Escolha uma categoria pai</option>

                          <?php foreach ($masters as $master):  ?>


                            <?php if(isset($categoria)): ?>

                              <option value="<?php echo $master->categoria_pai_id; ?>" <?php echo ($categoria->categoria_pai_id == $master->categoria_pai_id ? 'selected' : ''); ?>><?php echo $master->categoria_pai_nome; ?></option>
                              

                              <?php else : ?>

                                  <option value="<?php echo $master->categoria_pai_id; ?>"><?php echo $master->categoria_pai_nome; ?></option>

                              <?php endif; ?>

                            <?php endforeach; ?>

                          </select>
                        </div>
                        <?php echo form_error('categoria_pai_id', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  

                    <?php if (isset($categoria)): ?>

                      <input type="hidden" name="categoria_id" value="<?php echo $categoria->categoria_id; ?>">

                    <?php endif; ?>

                    
                   </div>
                  </div>
                  <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <a href="<?php echo base_url ('restrita/' . $this->router->fetch_class()); ?>" class="btn btn-dark">Voltar</a>
                  </div>
                </form>
              </div>
            </div>
        </div>

      </div>
    </section>

    <?php $this->load->view('restrita/layout/sidebar_configuracoes'); ?>

</div>      