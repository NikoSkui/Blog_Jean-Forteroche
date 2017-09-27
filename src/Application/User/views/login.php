<section class="hero is-fullheight" style="background:url(../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white">Connexion</h1>
      <div class="columns is-centered">
          <form method="post" class="column is-offset-one-quarter-mobile is-half-mobile is-one-third">
            <div class="field">
              <p class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="username" value="<?= $username ?>" placeholder="Identifiant">
                <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
                <span class="icon is-small is-right"></span>
                <!-- <i class="fa fa-check"></i> -->
              </p>
            </div>
            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="password" name="password"  placeholder="Mot de passe">
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <p class="control">
                <button class="button is-primary" type="submit">Connection</button>
              </p>
            </div>
          </form>
      </div>
    </div>
  </div>
</section>
