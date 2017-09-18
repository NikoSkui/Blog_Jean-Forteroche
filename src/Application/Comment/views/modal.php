<!--Modal signaler un commentaire  -->
<form action="" method="post" id="modal-comment">
  <div id="modal" class="modal "><!-- is-active -->
      <div class="modal-background"></div>

      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title is-size-6">Aidez-nous à comprendre ce qui se passe avec ce commentaire</p>
          <!-- <button class="delete" aria-label="close"></button> -->
        </header>
        <section class="modal-card-body">

          <!-- <div class=""> -->
            <!-- <div class=""> -->
              <article class="media" style="padding: 1.25rem;">
                <figure class="media-left">
                  <p class="image is-64x64">
                    <img src="http://bulma.io/images/placeholders/128x128.png">
                  </p>
                </figure>
                <div class="media-content">
                  <div class="content" id="comment-<?= $comment->id ?>">
                    <p>
                      <strong>John Smith </strong>
                      <br>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.
                      <br>
                    </p>
                  </div>
                </div>
              </article>

              <div class="field">
                <!-- <div class="field-label">
                  <label class="label">Already a member?</label>
                </div> -->
                <div class="field-body">
                  <div class="field is-narrow">
                    <div class="control ">
                      <label class="radio">
                        <input type="radio" name="member" value="Option 1">
                        C’est ennuyeux ou inintéressant
                      </label>
                    </div>
                    <div class="control ">
                      <label class="radio">
                        <input type="radio" name="member" value="Option 2">
                        Je pense que cela n’a rien à faire sur ce blog
                      </label>
                    </div>
                    <div class="control ">
                      <label class="radio">
                        <input type="radio" name="member" value="Option 3">
                        C’est du contenu indésirable
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            <!-- </div> -->
          <!-- </div> -->

        </section>
        <footer class="modal-card-foot">
          <!-- <button class="button is-success ">Continuer</button> -->
          <div class="field is-grouped is-grouped-right">
            <p class="control">
              <button type="submit" class="button is-primary">
                Continuer
              </button>
            </p>
          </div>
          <!-- <button class="button">Cancel</button> -->
        </footer>
      </div>
      <a class="modal-close is-large"></a>
  </div>
</form>