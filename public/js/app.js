$(document).ready(function () {

    // LES RÉSEUX SOCIAUX

    $(".network-social").hover(function () {
        $(this).removeClass("text-white");
        $(this).addClass("bg-white");
    }, function () {
        $(this).addClass("text-white");
        $(this).removeClass("bg-white");
    });

    // LECTURE DE VIDEOS
    $('.play').click(function () {

        // LES IMAGES
        var $images = $(this).parent().parent().parent().find(".image-item"),
            $imgActive = $(this).parent().parent(),
            index = $imgActive.index();
                
        // ENLEVER LA CLASS ACTIVE
        $images.removeClass("active");
        $imgActive.addClass("active");


        // INDICE DE L'IMAGE ACTIVE
        // var index = $(this).parent().parent().parent().find(".image-item.active").index();
        

        // LES VIDEOS
        var $videos = $(this).parent().parent().parent().parent().find(".video .container-iframe") ,
            $iframeContent = $videos.eq(index),
            $videoActive = $iframeContent.find(".video-iframe"),
            $src = $videoActive.attr("src");
        
        // ARTICLES MODAL POP PUP
        var $article = $(this).parent().parent().parent().parent().find("article"),
            $articleActive = $article.eq(index);
        
        $articleActive.show();
        // $articleActive.removeClass('dNone');
        
        // // Arreter la lecture de toute les videos
        $videos.find(".video-iframe").each(function () {
            $(this).prop('src', $(this).attr("src").replace("&autoplay=1", ""))
        })
     
        // Lecture de la video cliquée
        $videoActive.prop('src', $src + "&autoplay=1");
        
    })

    // Arreter la cure des videos quand clique sur "X"
    $('.content-close-icon').click(function () {

        $("#videos-img .video-iframe").each(function () {
            $(this).prop('src', $(this).attr("src").replace("&autoplay=1", ""))
        })

        $("article.video-item").hide();
        // $("article.video-item").addClass("dNone");
        $(".image-item").removeClass("active");
    })
    
    
    // SCROLL
    $(this).scroll(function () {
        var windowTop = $(this).scrollTop();
        // afficher ou cacher header
        if (windowTop > 430) {
            $(".header1").slideDown();
            $(".header1").removeClass("dNone");
            $(".header1").addClass('fixed-top');
            $(".bar-content").addClass('bg-darks');
        } else {
            $(".header1").slideUp();
            $(".bar-content").removeClass('bg-darks');
        }

        if (windowTop > 700 & windowTop <= 1100) {
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_pres").addClass("text-white")
        }
        if (windowTop > 1100 & windowTop <= 2370) {
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_zone_3").addClass("text-white")
        }
        if (windowTop > 2370 & windowTop <= 4225) {
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_zone_4").addClass("text-white")
        }
        if (windowTop > 4225 & windowTop <= 5245) {
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_zone_5").addClass("text-white")
        }
        if (windowTop > 5245 & windowTop <= 5690) {
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_zone_6").addClass("text-white")
        }
        if (windowTop > 5690){
            $(".nav-item-content li a").removeClass("text-white")
            $("#nav_site_zone_7").addClass("text-white")
        }

        // console.log(windowTop);
    })

    // NAVBAR
    $(".bar-content, .close").click(function () {
        
        $("header").fadeToggle();
        $(".bar-content").fadeToggle();
        $(".close").fadeToggle();

    })
    // NAV BAR
    $(".nav-rdw a").click(function () {
        $("header").fadeToggle();
        $(".nav-rdw a").removeClass("text-white");
        $(".nav-rdw a").addClass("grey2");
        $(".bar-content").fadeToggle();
        $(".close").fadeToggle();
        $(this).addClass("text-white");
        $(this).removeClass("grey2");
        // console.log($(this));
    })
})
