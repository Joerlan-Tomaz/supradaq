/* =============================================================================
 Login Supra
 Gustavo Costa
 
 v1.1
 Junho/2017
 ========================================================================== */


/* Otherwise just put the config content (json): */


particlesJS('particles-js', {
    "particles": {
        "number": {
            "value": 80,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {"value": "#ffffff"},
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {"nb_sides": 5},
            "image": {
                "src": "img/github.svg",
                "width": 100,
                "height": 100
            }
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": false,
                "mode": "repulse"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 400,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200,
                "duration": 0.4
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});


// $.fn.extend({
//     animateCss: function(animationName) {
//         var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
//         this.addClass('animated ' + animationName).one(animationEnd, function() {
//             $(this).removeClass('animated ' + animationName);
//         });
//         return this;
//     }
// });

$(document).ready(function () {

    $('.btn-login').click(function () {
        $('#login-box').removeClass('fadeOutUp');
        $('#login-box').addClass('fadeInDown');
        $('#login-box').removeClass('hidden');
        $('#video-box').removeClass('fadeInDown');
        $('#video-box').addClass('fadeOutUp');
    });

    $('#btn-login-close').click(function () {
        $('#login-box').removeClass('fadeInDown');
        $('#login-box').addClass('fadeOutUp');
    });

    $('#btn-video').click(function () {
        $('#video-box').removeClass('fadeOutUp');
        $('#video-box').addClass('fadeInDown');
        $('#video-box').removeClass('hidden');
        $('#login-box').removeClass('fadeInDown');
        $('#login-box').addClass('fadeOutUp');
    });

    $('#btn-video-close').click(function () {
        $('#video-box').removeClass('fadeInDown');
        $('#video-box').addClass('fadeOutUp');
    });

    $('.btn-acesso').click(function () {
        $("#acesso-nome").val("");
        $("#acesso-email").val("");
        $("#acesso-empresa").val("");
        $("#acesso-cpf").val("");
        $("#acesso-telefone").val("");
        $("#acesso-captcha").val("");
        $("#acesso-coordenacao").val("");
        $("#acesso-uf").val("");


        $("#nume_matricula").val("");
        $("#codi_senha").val("");

        $('#login-box').removeClass('fadeInDown');
        $('#login-box').addClass('fadeOutUp');
        $('#acesso-box').removeClass('fadeOutUp');
        $('#acesso-box').addClass('fadeInDown');
        $('#acesso-box').removeClass('hidden');
        $('.mensagem-acesso-envio').addClass('hidden');
        $('.mensagem-acesso-inicio').removeClass('hidden');
        $('.form-acesso').removeClass('hidden');
        //-------------------------------------------------
        //refreshCaptcha();

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


    });

    $('#btn-acesso-close').click(function () {
        $('#acesso-box').removeClass('fadeInDown');
        $('#acesso-box').addClass('fadeOutUp');
    });

    $('.btn-tentar').click(function () {
        $('.mensagem-acesso-envio').addClass('hidden');
        $('.mensagem-acesso-inicio').removeClass('hidden');
        $('.form-acesso').removeClass('hidden');
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

    // window.onload = function () {
    //     var video = document.getElementById("video");
    //     var playButton = document.getElementById("btn-video");
    //     var pauseButton = document.getElementById("btn-video-close");

    //     playButton.addEventListener("click", function () {
    //         video.play();
    //     });

    //     pauseButton.addEventListener("click", function () {
    //         video.pause();
    //     });

    //     video.addEventListener('ended', myHandler, false);

    //     function myHandler(e) {
    //         // alert('kabô!');
    //         $('#video-box').removeClass('fadeInDown');
    //         $('#video-box').addClass('fadeOutUp');
    //         video.currentTime = 0;
    //     }

    // };
    //----------------------------------------------------------------------------------
    //$("#reload").click(function() {
    //     $("img#img").remove();
    //     var id = Math.random();
    //     $('<img id="img" src="/supra/login2017/captcha/captcha.php?id='+id+'"/>').appendTo("#imgdiv");
    //     id ='';
    // });


});


