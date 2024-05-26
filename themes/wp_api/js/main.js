jQuery(document).ready(function ($) {

  /**
   * Limitando número de caracteres do título de notícias
   */
  if ($("input[name=post_type]").length) {
    if ($("input[name=post_type]").val() == "post") {
      $("input#title").keyup(function () {
        var val = $(this).val()
        if (val.length >= 110) $(this).val(val.substr(0, 110))
      });
    }
  }

  /**
   * Escondendo campo de resumo da página de vídeos 
   */
  if ($("input[name=post_type]").length) {
    if ($("input[name=post_type]").val() == "videos") {
      $("#postexcerpt").hide()
    }
  }

  /**
   * Removendo blocos sem utilidade:
   *  - campos personalizados de todas as páginas
   *  - Atributos de página
   */

  if ($("input[name=post_type]").length) {
    $("#postcustom").hide()
    $("#pageparentdiv").hide()
    console.log("Vai remover aqui")
  }
  // postexcerpt

  // Hack para alterar endereço do botão de 'Visualizar Alterações'
  // $("#post-preview").attr("href", "olateste")

})