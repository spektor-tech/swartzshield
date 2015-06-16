<?php require 'inc/header.php'; ?>

    <script src="js/typed.js" type="text/javascript"></script>

    <script>
    $(function(){

        $("#typed").typed({
            strings: [
            
            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 Thanks for your help.\nYou've got 25 minutes to decypher the puzzles\nand find Gepetto before the IDCDA will find you.\n\n<em>&lt;type <strong>'start</strong> when you're ready&gt;</em>",],

            typeSpeed: 0,
            backDelay: 500,
            loop: false,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: false,
            resetCallback: function() { newTyped(); },
            
            callback: function() {
            	$('.typed-cursor').css('display', 'none');

            	$('#formStartgame').css('display', 'inline');
            	$('#startgame').css('display', 'inline');
            	$('#startgame').focus();

            	$('#formStartgame').on('submit', function(e) {
            		e.preventDefault();
            		if($('#startgame').val().toLowerCase() == 'start') {
                        window.location = 'game.php'
                    } else {
                        alert('To proceed type \'Y\'.');
                    }
            	});
            }
        });
        
    });


    function newTyped(){ /* A new typed object */ }

    function foo(){ console.log("Callback"); }

    </script>

    <!-- <link href="css/main.css" rel="stylesheet"/> -->
    <style>
        /* code for animated blinking cursor */
        .typed-cursor{
            opacity: 1;
            font-weight: 100;
            -webkit-animation: blink 0.7s infinite;
            -moz-animation: blink 0.7s infinite;
            -ms-animation: blink 0.7s infinite;
            -o-animation: blink 0.7s infinite;
            animation: blink 0.7s infinite;
        }
        @-keyframes blink{
            0% { opacity:1; }
            50% { opacity:0; }
            100% { opacity:1; }
        }
        @-webkit-keyframes blink{
            0% { opacity:1; }
            50% { opacity:0; }
            100% { opacity:1; }
        }
        @-moz-keyframes blink{
            0% { opacity:1; }
            50% { opacity:0; }
            100% { opacity:1; }
        }
        @-ms-keyframes blink{
            0% { opacity:1; }
            50% { opacity:0; }
            100% { opacity:1; }
        }
        @-o-keyframes blink{
            0% { opacity:1; }
            50% { opacity:0; }
            100% { opacity:1; }
        }
    </style>
</head>
<body>

<div class="header">
	<img class="shield" onload="this.style.opacity='1';" src="img/s_shield-big.png">
	<img class="logo animate" onload="this.style.opacity='1';" src="img/s_logo-big.png">
</div>

<div class="textbox">
    <div class="wrap">
        <div class="type-wrap">
            <span id="typed" style="white-space:pre;"></span>
<form action="#" id="formStartgame">
            	<input autocomplete="no" type="text" name="startgame" required="true" id="startgame" autocomplete="off">
            </form>
        </div>
    </div>
</div>

<?php require 'inc/footer.php'; ?>