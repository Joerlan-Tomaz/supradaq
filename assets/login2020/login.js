/* =============================================================================
   Login Supra
   Gustavo Costa

   v1.1
   Junho/2017
   ========================================================================== */

(function( $ ){
    var checkSize = function() {
	    var current_width = $(window).width();
	    var tabletWidth = 768;
	    var desktopWidth = 1100;
	
	    if(current_width < tabletWidth)
	      $('html, body').addClass("mobile").removeClass("tablet").removeClass("desktop").data('device', 'mobile');
	    else if(current_width >= tabletWidth && current_width < desktopWidth)
	      $('html, body').removeClass("mobile").addClass("tablet").removeClass("desktop").data('device', 'tablet');
	    else
	      $('html, body').removeClass("mobile").removeClass("tablet").addClass("desktop").data('device', 'desktop');
	  }

  $(document).ready(checkSize);
  $(window).resize(checkSize);
  
})( jQuery );



$(document).ready(function() {

    // resize-------------------------------------------------------------------
		
		//var bodyHeight = $('body').outerHeight();
		//var baseHeight = $(document).outerHeight();

		function handleResize() {
			
			$('.slide-box').css('height', '');
			$('.slide').css('height', '');
			
			var win = $(window);
            var	viewport = window.innerHeight;
            var actualHeight = $('.conteudo').outerHeight();
					
			if ( $('body').hasClass('desktop') ) {
				$('.slide-box').css('height', actualHeight - 1);
			} else if ( $('body').hasClass('tablet') ) {
                $('.slide-box').css('height', actualHeight - 1);
            } else {
                $('.slide-box').css('height', actualHeight - 1);
            };
	
			// if ($('body').hasClass('mobile') && $('.content-section.active').length) {
			// 	var st = win.scrollTop(),
			// 		position = $('.content-section.active').offset().top;
	
			// 	if (st <= (position - 100) || st >= (position + 300)) {
			// 		win.scrollTop(position);
			// 	}
			// } else {
			// 	win.scrollTop(0);
			// }
		};
		
	   
		$(window).resize(handleResize);
		$(document).resize(handleResize);
		$('body').resize(handleResize);
        window.setTimeout(handleResize, 50);
        
    // Activate bezierCanvas plugin on a #bg-canvas element
    $("#bg-canvas").bezierCanvas({
        maxStyles: 10,
        maxLines: 100,
        lineSpacing: 1,
        // colorBase: {r: 100,g: 100,b: 100},
        // colorVariation: {r: 150, g: 120, b: 150},
        colorBase: {r: 255,g: 255,b: 255},
        colorVariation: {r: 0, g: 0, b: 0},
        delayVariation: 0.5,
        moveCenterX: 0,
        moveCenterY: 0,
        speedVariation: 0.3,
        globalAlpha: 0.5,
        globalSpeed: 600,
    });


    $("#nav a").each(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
        && location.hostname == this.hostname
        && this.hash.replace(/#/,'') ) {
          var $targetId = $(this.hash), $targetAnchor = $('[name=' + this.hash.slice(1) +']');
          var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;
           if ($target) {
             var targetOffset = $target.offset().top;

             $(this).click(function() {
                $("#nav li a").removeClass("active");
                $(this).addClass('active');
                $('html, body').animate({scrollTop: targetOffset}, 1000);
               return false;
             });
          }
        }
    });


    // $(".seta-down").click(function() {
    //     $(".link-login").click();
    // })

    var lastId,
        topMenu = $("#nav"),
        //topMenuHeight = topMenu.outerHeight()+100,
        menuItems = topMenu.find("a"),
        scrollItems = menuItems.map( function() {
        var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });

    
    $(window).scroll( function() {

        var fromTop = $(this).scrollTop();
        var cur = scrollItems.map(function() {
          if ($(this).offset().top < fromTop)
            return this;
        });
        cur = cur[cur.length-1];
        var id = cur && cur.length ? cur[0].id : "";
        
        if (lastId !== id) {
            lastId = id;
            menuItems
              .removeClass("active")
              $("a[href='#"+id+"']").addClass("active");
        }                   
     });




    $('.btn-login').click(function() {
        $('#login-box').removeClass('fadeOutUp');
        $('#login-box').addClass('fadeInDown');
        $('#login-box').removeClass('hidden');
        $('#video-box').removeClass('fadeInDown');
        $('#video-box').addClass('fadeOutUp');
    });

    $('#btn-login-close').click(function() {
        $('#login-box').removeClass('fadeInDown');
        $('#login-box').addClass('fadeOutUp');
    });


    $('#btn-video').click(function() {
        $('#video-box').removeClass('fadeOutUp');
        $('#video-box').addClass('fadeInDown');
        $('#video-box').removeClass('hidden');
        $('#login-box').addClass('fadeOutUp');
    });

    $('#btn-video-close').click(function() {
        $('#video-box').removeClass('fadeInDown');
        $('#video-box').addClass('fadeOutUp');
    });

    $('#btn-video-pb, btn-video-pb-2').click(function() {
        $('#video-box').removeClass('hidden');
        $('#video-box .video-container').addClass('slide-fwd-center');
    });

    $('#btn-video-close-pb').click(function() {
        $('#video-box .video-container').addClass('slide-bck-center');
        $('#login-box .video-container').removeClass('slide-fwd-center');
        $('#video-box').addClass('hidden');
        $('#video-box .video-container').removeClass('slide-bck-center');
    });

    //$('.btn-acesso').click(function() {
    //});

    $('#btn-acesso-close').click(function() {
        $('#acesso-box').removeClass('fadeInDown');
        $('#acesso-box').addClass('fadeOutUp');
    });

    $('.btn-tentar').click(function() {
        $('.mensagem-acesso-envio').addClass('hidden');
        $('.mensagem-acesso-inicio').removeClass('hidden');
        $('.form-acesso').removeClass('hidden');
        $('.msg-erro').hide();
        $('.btn-tentar').hide();
    });

    $('.form-supra .form-control').on('blur', function() {
        var value = $(this).val();
        var label = $(this).parent().find('label');

        if(!value) {
            label.removeClass('active');
        }

        label.removeClass('focus');

    });

    $('.form-login .form-pb .form-control').on('blur', function() {
        var value = $(this).val();
        var label = $(this).parent().find('label');

        if(!value) {
            label.removeClass('active');
        }

        label.removeClass('focus');

    });

    $('.form-supra .form-control').on('focus', function() {
        var value = $(this).val();
        var label = $(this).parent().find('label');

        label.addClass('active');
        label.addClass('focus');
    });

    $('.form-login .form-pb .form-control').on('focus', function() {
        var value = $(this).val();
        var label = $(this).parent().find('label');

        label.addClass('active');
        label.addClass('focus');
    });


    $('.form-supra .form-control').each( function() {
        var $this = $(this);
        var value = $this.val();

        setTimeout( function() {
            if(value) {
                $this.parent().find('label').addClass('active');
            }else{
                $this.parent().find('label').removeClass('active');
            }
        }, 0);
    });

    $('.form-login .form-pb .form-control').each( function() {
        var $this = $(this);
        var value = $this.val();

        setTimeout( function() {
            if(value) {
                $this.parent().find('label').addClass('active');
            }else{
                $this.parent().find('label').removeClass('active');
            }
        }, 0);
    });

    $(".login-pb .form-login .form-control").bind('focus', function() {
        $(this).css({'background-color': 'transparent', 'color': '#fff'});
     });


    function msgEnvio(cod) {

        var cod = cod;

        $('.mensagem-acesso-inicio').addClass('hidden');
        $('.form-acesso').addClass('hidden');
        $('.mensagem-acesso-envio').removeClass('hidden');

        if (cod == 1) {
            $('.msg-erro').show();
            $('#messagem').text('Não foi possível enviar sua solicitação.');
            $('.btn-tentar').show();
        } else if (cod == 2) {
            $('.msg-erro').show();
            $('#messagem').text('E-mail já cadastrado.');
            $('.btn-tentar').show();
        }
    }


    window.onload = function() {

        var video = document.getElementById("video");
        var playButton = document.getElementById("btn-video-pb");
        var pauseButton = document.getElementById("btn-video-close-pb");

        playButton.addEventListener("click", function() {
            video.play();
        });

        pauseButton.addEventListener("click", function() {
            video.pause();
        });

        video.addEventListener('ended', myHandler, false);

        function myHandler(e) {
            // alert('kabô!');
            $('#video-box').removeClass('fadeInDown');
            $('#video-box').addClass('fadeOutUp');
            video.currentTime = 0;
        }

        if ( !$(".link-video").hasClass("active") ) {
            video.pause();
        }

    };
    //----------------------------------------------------------------------------------

    $("#acesso-captcha").val("");
    $("#acesso-empresa").val("");
    $("#acesso-email").val("");
    $("#acesso-nome").val("");
    $("#nume_matricula").val("");
    $("#codi_senha").val("");
    $('.form-acesso').removeClass('hidden');

    $.ajax({
        type: 'POST',
        url: 'SolicitacaoAcesso/codigoCaptcha',
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            $("img#img").remove();
            var id = Math.random();
            $('<img id="img" src="assets/captcha/captcha.php?id=' + id + '"/>').appendTo("#imgdiv");
            id = '';
        }
    });

    //$("#reload").click(function() {

    //        $("img#img").remove();
    //        var id = Math.random();
    //        $('<img id="img" src="/supra/login2017/captcha/captcha.php?id='+id+'"/>').appendTo("#imgdiv");
    //        id ='';
    //});
    
});


