<section class="hero is-dark is-bold">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column">
          <p class="title">
            Administration
          </p>
          <p class="subtitle">
            Gestion des <strong>chapitres</strong> du livre 
          </p>
        </div>

        <div class="column is-narrow">
            <a class="button is-info is-medium" href="<?= $router->generateUri($prefixName.'#Create') ?>" style="box-shadow: 0 2px 3px rgba(10, 10, 10, .1), 0 0 0 1px rgba(10, 10, 10, .1);">
              Ajouter un nouveau livre
            </a>
        </div>

      </div>
    </div>
  </div>

   <!-- <div class="hero-foot">
    <div class="container">
      <nav class="tabs is-boxed">
        <ul>
          <li>
            <a href="/documentation/overview/start/">Overview</a>
          </li>
          <li>
            <a href="http://bulma.io/documentation/modifiers/syntax">Modifiers</a>
          </li>
          <li>
            <a href="http://bulma.io/documentation/columns/basics">Columns</a>
          </li>
          <li>
            <a href="http://bulma.io/documentation/layout/container/">Layout</a>
          </li>
          <li>
            <a href="http://bulma.io/documentation/form/general">Form</a>
          </li>
          <li class="is-active">
            <a href="http://bulma.io/documentation/elements/box/">Elements</a>
          </li>
          <li>
            
              <a href="http://bulma.io/documentation/components/breadcrumb/">Components</a>
            
          </li>
        </ul>
      </nav>
    </div>
  </div>  -->
</section>
<section class="section">
  <div class="container">
    <table class="table is-striped is-fullwidth ">
      <thead>
        <tr>
          <th><abbr title="Livre">Livre</abbr></th>
          <th><abbr title="Titre">Titre</abbr></th>
          <th><abbr title="Action">Action</abbr></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($elements as $num => $book):?> 
           
        <tr>
          <th><?= $num + 1 ?></th>
          <td><?= $book->name ?></td>
          <td>
            <div class="tags">
              <a class="tag is-primary" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $book->id]) ?>">Editer</a>
              <form action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $book->id]) ?>" method="post" onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')">
                <input type="hidden" name="_method" value ="DELETE">
                <button class="tag delete " style="border-radius:3px;min-height: 24px;"type="submit"></button>
              </form>
            </div>
          </td>
        </tr>
          
        </tr>
        <?php endforeach?>
      </tbody>
    </table>
  </div>
 </section>
