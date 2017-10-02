<section class="hero is-medium" style="background:url(<?= $urlHelper->baseUrl() ?>/img/bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-header">
    <?= $renderer->render('navbar') ?>
  </div>
  <div class="hero-body">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column">
          <p class="title has-text-white">
            Administration
          </p>
          <?php if(isset($header->subtitle)): ?>
          <h1 class="subtitle has-text-white">
            <?= $header->subtitle ?>
          </h1>
          <?php endif ?>       
        </div>
        <?php if(isset($header->btnTxt)): ?>
          <div class="column is-narrow">
              <a class="button is-info is-medium" href="<?= $router->generateUri($prefixName.'#Create') ?>" style="box-shadow: 0 2px 3px rgba(10, 10, 10, .1), 0 0 0 1px rgba(10, 10, 10, .1);">
                <?= $header->btnTxt ?>
              </a>
          </div>
        <?php endif ?> 
        <?php if($header->typePage === 'update'): ?>
          <?php if(isset($header->name)): ?>
            <div class="column is-narrow has-text-white" >
              <div class="title has-text-white" data-editable data-name="name">
                <p><?= $header->name ?></p>
              </div>
            </div> 
          <?php endif ?>  
          <?php if(isset($header->email)): ?>
            <div class="column is-narrow has-text-white" >
              <div class="title has-text-white">
                <p><?= $header->email ?></p>
              </div>
            </div>   
          <?php endif ?>  
        <?php endif ?>
        <?php if($header->typePage === 'create'): ?>
          <div class="column is-narrow has-text-white" >
            <div class="title has-text-white" data-editable data-name="name">
              <p>Entrez le titre du chapitre</p>
            </div>
          </div>   
        <?php endif ?>

      </div>
    </div>
  </div>
</section>
  <?php if($header->typePage === 'read'): ?>
  <?= $renderer->render('@admin/template/navbar', ['navbar'=>$header->navbar]) ?>
  <?php endif ?>

  <?php if(in_array($header->typePage,['create','update'])): ?>
  <!-- <a class="ct-widget ct-ignition ct-ignition--ready" href="<?= $router->generateUri($prefixName.'#Read')?>">
    <div class="ct-ignition__button ct-ignition__button--return button is-primary">
      <span class="icon is-medium"><i class="fa fa-chevron-left"></i></span>
    </div>
  </a> -->
  <?php endif ?>