<?php require 'inc/header.php'; ?>

	<!-- Autofocus script -->
	<script>
	$("#divID").focus();
	</script>


    <script src="js/typed.js" type="text/javascript"></script>

    <script>
    $(function(){

        $("#typed").typed({
            strings: [
            
            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 Are you ready to join me?\nIf you are,enter your email adress:\n\n\<em>&lt;friend_\&gt;</em> "],

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
            		alert('Filled in: ' + $('#emailaddress').val());
            	});
            }
        });

        $('#emailaddress')

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

        #formEmailaddress {
        	display: none;
        }
        #emailaddress {
        	display: none;
        }
    </style>
</head>
<body>

<div class="header">
	<img class="shield" onload="this.style.opacity='1';" src="img/s_shield-big.png">
	<img class="logo" onload="this.style.opacity='1';" src="img/s_logo-big.png">
</div>

<div class="textbox">
    <div class="wrap">
        <div class="type-wrap">
            <span id="typed" style="white-space:pre;"></span>
            <span id="typedbutton" style="white-space:pre;"></span>

            	<form action="#" id="formEmailaddress">
            		<input autocomplete="no" type="text" name="emailaddress" required="true" id="emailaddress">
            	</form>
        </div>
    </div>
</div>

<?php require 'inc/footer.php'; ?>