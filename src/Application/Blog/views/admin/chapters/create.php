<section class="section">
  <div class="container">
      <input id="created_at" type="hidden"  value="<?= $element->created_at ?>">
      <input id="books_id" type="hidden"  value="<?= $element->books_id ?>">
      <input id="chapters_order" type="hidden" name="chapters_order" value="<?= $element->chapters_order ?>">
      <div class="columns is-centered" >
        <div class="column is-three-quarters" data-editable data-name="content">
          <p>Entrez votre nouveau contenu<p>
        </div>
      </div>
  </div>
</section>