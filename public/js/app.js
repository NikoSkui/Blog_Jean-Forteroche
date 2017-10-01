jQuery(document).ready(function($){

  /**
   * POST COMMENTS
   */
  // Affiche le formulaire de réponse à un commentaire suivant le commentaire
  $('.reply').click(function(e){
    e.preventDefault()
    var $form = $('#form-comment')
    var $this = $(this)
    var $parent_id = $this.data('id')
    var $comment = $('#comment-' + $parent_id)

    $("#content").attr('placeholder','Répondre à ce commentaire')
    $("#parent_id").val($parent_id)
    $comment.after($form);
  }) 

  /**
   * REPORT COMMENTS
   */
  // Affiche la fenetre modal quand l'utilisateur clique sur signaler
  $('.report').click(function(e){
    e.preventDefault()
    var $content = $('#comment-content-modal')
    var $modal = $('#modal')
    var $modalCard = $('.modal-card')
    var $form = $('#form-modal')
    var $this = $(this)
    var $comments_id = $this.data('id')
    var $comment = $('#comment-' + $comments_id).clone()

    $comment.find('#action').remove()
    $form.find("#comments_id").val($comments_id)
    $content.append($comment);
    $modal.addClass('is-active')
    $modal.removeClass('fadeOut')
    $modalCard.addClass('fadeInDown')
  })
  // Delete la fenetre modal quand l'utilisateur clique en dehors de la card
  $('#modal').click(function(e) { 
    var $content = $('#comment-content-modal').children()
    var $modal = $(this)
    var $modalCard = $('.modal-card')
    if(!$(e.target).closest($modalCard).length){
      $modal.addClass('fadeOut').delay(800).queue(function(){
        $modal.removeClass('is-active')
        $content.remove()
        $(this).dequeue();
      })
    }
  }); 



  /**
   * BUTTON RETURN
   */
  // Ajoute une classe auchargement du page avec le bouton retour
  $( ".ct-widget" ).addClass("ct-widget--active");
})