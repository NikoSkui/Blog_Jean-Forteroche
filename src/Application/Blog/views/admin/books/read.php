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
