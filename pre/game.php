<?php require 'inc/header.php'; ?>

    <script src="js/typed.js" type="text/javascript"></script>

    <script>
    $(function(){

        $("#typed").typed({
            strings: [
            
            "^1000<strong>\&lt;swartzshield&gt;</strong>^200<a class=\"button button button--antiman button--inverted button--border-thin button--text-thick\" href=\"game-email.php\">Play the game</> ",],

            typeSpeed: 0,
            backDelay: 500,
            loop: false,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: false,
            resetCallback: function() { newTyped(); }
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

<div class="textbox">
    <div class="wrap">
        <div class="type-wrap">
            <span id="typed" style="white-space:pre;"></span>
            <span id="typedbutton" style="white-space:pre;"></span>
        </div>
    </div>
</div>

</body>
</html>