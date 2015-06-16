/**
 * Created by jasonderidder on 16-06-15.
 */
var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

var pmethod = '';
var withEmail = true;
$(function(){

    $("#typed").typed({
        strings: [

            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 You were a big help!^1000 We are planning more actions in the future. ^500\nLeave your emailaddress if you want to be notified first!^1000\n\n<strong>emailaddress (or type \'no\')\&gt;</strong>",
        ],
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,

        callback: function() {
            $('.typed-cursor').css('display', 'none');

            $('#formEmailaddress').css('display', 'inline');
            $('#emailaddress').css('display', 'inline');
            $('#emailaddress').focus();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if(re.test($('#emailaddress').val())) {
                    $('#emailaddress').blur();

                    $.getJSON('saveEmailaddress.php', {
                        ea: $('#emailaddress').val()
                    },
                    function(a) {
                        if(a != 'true')
                            doLast();
                        else {
                            // Go to next
                            $('#emailaddress').val('');
                            donate1();
                        }
                    });
                    $('#emailaddress').val('Checking emailaddress... (' + $('#emailaddress').val() +')');
                }
                else if($('#emailaddress').val().toLowerCase() == 'no')
                {
                    withEmail = false;
                    donate1();
                }
                else {
                    doLast();
                }
            });
        }
    });

});

function doLast()
{
    $('#typed').html($('#typed').html() + ' ' + $('#emailaddress').val() + '<br><em style="color: red">This is not a correct emailaddress</em><br><strong>emailaddress\&gt;</strong>');
    $('#emailaddress').val('');
    $('#emailaddress').focus();
}

function donate1()
{
    $('#formEmailaddress').off('submit');
    $('#typed').typed('reset');
    $("#typed").typed({
        strings: [

            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 " + (withEmail ? "Thanks mate!" : "Well, privacy is a valuable thing.") + "<br> ^1000 To speed up some things, we need some money for this.<br>Do you want to donate? ^1000<br><br><strong>Y/N\&gt;</strong>",
        ],
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,

        callback: function () {
        }
    });
}

function donate2()
{
    $('#formEmailaddress').off('submit');
    $('#typed').typed('reset');
    $("#typed").typed({
        strings: [

            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 You are even more awesome then I thought!<br> ^1000 Select your prefered method: <br><br><em>[1] Bitcoin<br>[2] Creditcard<br>[3] PayPal<br>[4] iDeal ^1000<br><br><strong>Pick your number [1-4]\&gt;</strong>",
        ],
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,

        callback: function () {
            $('.typed-cursor').css('display', 'none');

            $('#formEmailaddress').css('display', 'inline');
            $('#emailaddress').css('display', 'inline');
            $('#emailaddress').focus();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                switch(Math.round($('#emailaddress').val())){
                    case 1:
                        pmethod = 'BitCoin';
                        donate3();
                        break;
                    case 2:
                        pmethod = 'creditcard';
                        donate3();
                        break;
                    case 3:
                        pmethod = 'PayPal';
                        donate3();
                        break;
                    case 4:
                        pmethod = 'iDeal';
                        donate3();
                        break;
                    default:
                        doLast();
                        break;
                }
            });

        }
    });
}

function donate3()
{
    $('#formEmailaddress').off('submit');
    $('#emailaddress').val('');
    $('#typed').typed('reset');
    $("#typed").typed({
        strings: [

            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 I always go for " + pmethod + " too!<br> ^1000 Please set your amount in whole numbers in EUR (\&euro;). ^1000<br><br><strong>Set your amount. Minimum of \&euro; 5\&gt;</strong>",
        ],
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,

        callback: function () {
            $('.typed-cursor').css('display', 'none');

            $('#formEmailaddress').css('display', 'inline');
            $('#emailaddress').css('display', 'inline');
            $('#emailaddress').focus();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
            });
        }
    });
}