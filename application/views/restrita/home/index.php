

    <div class="main-wrapper main-wrapper-1">

   

     <?php $this->load->view('restrita/layout/navbar'); ?>


     
     <?php $this->load->view('restrita/layout/sidebar'); ?>



      <!-- Main Content -->
      <div class="main-content">



        <section class="section">
          <div class="section-body">
            <H1>Home da area restrita</H1>

            <?php
            echo '<pre>';
            print_r($this->session->userdata());
            echo '</pre>';
            ?>


            
          </div>
        </section>


        <?php $this->load->view('restrita/layout/sidebar_configuracoes'); ?>

      </div>


      