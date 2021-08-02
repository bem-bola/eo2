$(document).ready(function () {

    // console.log($( "input:checked" ).val())

    $(".p-check").change(function () {
        if ($(this).val() == "on") {
            $(this).parent().parent().find(".p-danger").addClass('dNone');
            $(this).parent().parent().find(".p-success-1").removeClass('dNone');
            $(this).parent().parent().find(".p-success").addClass('dNone');
            $(this).parent().parent().find(".p-warning").addClass('dNone');
        } else {
            $(this).parent().parent().find(".p-danger").addClass('dNone');
            $(this).parent().parent().find(".p-success").addClass('dNone');
            $(this).parent().parent().find(".p-warning").removeClass('dNone');
            $(this).parent().parent().find(".p-success-1").addClass('dNone');
        }

    })
    if ($(".image-media").attr('value') !== "") {
        $(".photo-admin-upload").attr("disabled", "disabled");
        $(".photo-admin-upload").attr("title", 'Veuillez cliquer sur le bouton "X" ci-dessus');
    console.log($(".image-media").attr('value'));

    }

    // SELECTIOONER UNE IMAGE DANS LE MEDIA
    $(".img-mini").click(function () {

        // recuperer le nom de l'image selectionnée
        $path_img = $(this).find("input").val();

        // attribuer ce nom à l'input
        $(".image-media").attr("value", $path_img);

        // Afficher image selectionner
        $(".img-add").removeClass("dNone");
        $(".img-add img").attr("src", "/images/slider/" + $(this).find("input").val());

        $(".form_photo").attr("value", "");
        $(".photo-admin-upload").attr("disabled", "disabled");

        // console.log($(".image-media").val());

    })

    // SUPPRIMER IMAGE SELCTIONNEE

    $(".close-admin-img").click(function () {
        // Recuperer l'input
        var $input_delete = $(this).parent().find(".image-media");

        $input_delete.attr("value", "");

        $(".photo-admin-upload").attr("disabled", false);

        // console.log($("#form_photo").attr("value"));
    })

     // CACHER OU AFFICHER MOT DE PASSE

    $(".showPassword").click(function () {
        
        // On recupère l'input password
        $inputPassword = $("input[name='password']");

        // On change son type
        $inputPassword.prop('type', 'text');
        // On cache l'oeil
        $(this).addClass("dNone");
        // on montre l'oeil barré
        $(this).parent().find(".hidePassword").removeClass("dNone");

    })
    $(".hidePassword").click(function () {
        
        // On recupère l'input password
        $inputPassword = $("input[name='password']");

        // On change son type
        $inputPassword.prop('type', 'password');
        // On cache l'oeil
        $(this).addClass("dNone");
        // on montre l'oeil barré
        $(this).parent().find(".showPassword").removeClass("dNone");

    })

    // LES ROLES
    $("#role-admin").change(function () {

        var value = $(this).val();

        if (value === "ROLE_USER") {
            $(".text-admin-role").addClass("dNone");
            $(".text-user-role").removeClass("dNone");
        }
        if (value === "ROLE_ADMIN") {
            $(".text-admin-role").removeClass("dNone");
            $(".text-user-role").addClass("dNone");
        }
    })

})
