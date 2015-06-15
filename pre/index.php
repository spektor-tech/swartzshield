<?php require 'inc/header.php'; ?>

    <script src="js/typed.js" type="text/javascript"></script>

    <script>
    $(function(){

        $("#typed").typed({
            strings: [
            
            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 Hi there friend,\n^2000Recently I,ve received an encrypted message from a lost brother.\n^1000After reading, it kept me awake for several nights.\n\n^2000Early 2015 the IDCDA launched a program called Gepetto.\n^1000With it they can monitor the entire web and profile everyone\nbased on interest ^1000 and the dirty stuff you like to watch online. \n^2000It will quarantine individuals who are likely to rebel.\n\n^2000But what program can actually decide who is a rebel or not...^1000 right?\n^1000As you read this, governments are plugging into Gepetto.\n^2000Will this be the end of our freedom?\n\n^2000To put an end to the program I've made a sacrifice.\n^2000Put myself on the radar, so they will come for me. \n^2000I made a program called Torigami^1000 and placed it on the dark web.\n^2000It can decypher several puzzles to get into the IDCDA mainframe.\n\n^1000Don&#39;t be afraid, \n^1000my friend M_REX will provide help when needed.\n\n^1000Will you help me reveal Gepetto?^2000\n\n<strong>&gt; y/n</strong>",],

            typeSpeed: 0,
            backDelay: 500,
            loop: false,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: false,
            resetCallback: function() { newTyped(); },
            
            callback: function() {
            	$('.typed-cursor').css('display', 'none');

            	$('#formEmailaddress').css('display', 'inline');
            	$('#emailaddress').css('display', 'inline');
            	$('#emailaddress').focus();

            	$('#formEmailaddress').on('submit', function(e) {
            		e.preventDefault();
            		if($('#emailaddress').val().toLowerCase() == 'y') {
                        window.location = 'index2.php'
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

<div class="textbox">
    <div class="wrap">
        <div class="type-wrap">
            <span id="typed" style="white-space:pre;"></span>
            <form action="#" id="formEmailaddress">
            	<input autocomplete="no" type="text" name="emailaddress" required="true" id="emailaddress" autocomplete="off">
            </form>
        </div>
    </div>
</div>

</body>
</html>