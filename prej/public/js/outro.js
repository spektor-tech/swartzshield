/**
 * Created by jasonderidder on 16-06-15.
 */
var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

var pmethod = '';
var withEmail = true;
var email = '';
var issuer = 0;
var amount = 0;
var issuers = [];
$(function(){

    startNewTyped("^1000<strong>\&lt;swartzshield&gt;</strong>^200 You were a big help!^1000 We are planning more actions in the future. ^500<br>Leave your emailaddress if you want to be notified first!^1000<br><br><strong>emailaddress (or type \'no\')\&gt;</strong>",
        function() {
            focusOnText();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                email = $('#emailaddress').val();
                if(re.test($('#emailaddress').val())) {
                    $('#emailaddress').blur();

                    $.getJSON('saveEmailaddress.php', {
                            ea: email
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
    );

});

function getIssuers()
{
    $.getJSON('receiveIssuers.php', {}, function(a)
    {
        issuers = a;
    });
}

function doLast()
{
    $('#typed').html($('#typed').html() + ' ' + $('#emailaddress').val() + '<br><em style="color: red">This is not a correct emailaddress</em><br><strong>emailaddress\&gt;</strong>');
    $('#emailaddress').val('');
    $('#emailaddress').focus();
}

function doLastCustom(adding)
{
    $('#typed').html($('#typed').html() + ' ' + $('#emailaddress').val() + '<br>' + adding);
    $('#emailaddress').val('');
    $('#emailaddress').focus();
}

function donate1()
{
    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 " + (withEmail ? "Thanks mate!" : "Well, privacy is a valuable thing.") + "<br> ^1000 To speed up some things, we need some money for this.<br>Do you want to donate? ^1000<br><br><strong>Y/N\&gt;</strong>",
        function() {
            focusOnText();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if($('#emailaddress').val().toLowerCase() == 'y')
                {
                    donate2();
                }
                else {
                    donate5();
                }
            });
        }
    );
}

function donate2()
{

    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 You are even more awesome then I thought!<br> ^1000 Select your prefered method: <br><br><em>[1] Bitcoin<br>[2] Creditcard<br>[3] PayPal<br>[4] iDeal ^1000<br><br><strong>Pick your number [1-4]\&gt;</strong>",
        function()
        {
            focusOnText();

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
                        getIssuers();
                        donate3();
                        break;
                    default:
                        doLastCustom('<strong>Pick your number [1-4]\&gt;</strong>');
                        break;
                }
            });
        }
    );
}

function donate3()
{
    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 I always go for " + pmethod + " too!<br> ^1000 Please set your amount in whole numbers in EUR (\&euro;). ^1000<br><br><strong>Set your amount. Minimum of \&euro; 5\&gt;</strong>",
        function() {
            focusOnText();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if(!isNaN(Number($('#emailaddress').val())) && Number($('#emailaddress').val()) >= 5) {
                    amount = Number($('#emailaddress').val());
                    if(pmethod.toLowerCase() == 'ideal')
                    {
                        donate4();
                    }
                    else {
                        // Send to donating
                        sendToDonation();
                    }
                }
                else {
                    doLastCustom("<strong>Set your amount. Minimum of \&euro; 5\&gt;</strong>");
                }
            });
        }
    );
}

function donate4()
{
    // Make sure there is an issuers list. Check every .5 seconds
    if(issuers.length < 1)
    {
        getIssuers();
        setTimeout(function()
        {
            donate4();
        }, 500);

        return;
    }

    var issuersList = '';
    for(var i = 0; i < issuers.length; i++)
    {
        issuersList += '[' + (i+1) + '] ' + issuers[i].name + '<br>';
    }

    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 Please select one of the following banks:<br><br><em>" + issuersList + "<br><strong>Pick your bank [1-" + issuers.length + "]\&gt;</strong>",
        function() {
            focusOnText();
            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if (Number($('#emailaddress').val()) > 0 && Number($('#emailaddress').val()) <= issuers.length) {
                    issuer = Number($('#emailaddress').val());
                    sendToDonation();
                } else {
                    doLastCustom("<strong>Pick your bank [1-" + issuers.length + "]\&gt;</strong>");
                }
            });
        }
    );
}

function sendToDonation()
{
    var ideal = "";
    // Check ideal
    if(pmethod.toLowerCase() == 'ideal')
    {
        ideal = "<em>[bank]</em> " + issuers[issuer - 1].name + "<br>";
    }

    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 We are redirecting you to the payment provider <em>(Mollie)</em><br><br><em>[payment method]</em> " + pmethod + "<br>" + ideal +"<em>[amount]</em> \&euro; " + amount + ".00<br><br>You'll transfer the money to the producer.<br><em>---------------<br>Spektor Storytelling B.V.<br>Duvenvoordestraat 18<br> 2013 AE  HAARLEM<br> The Netherlands<br><br>Chamber of Commerce: Amsterdam, 50496123<br>VAT number: NL822772498B01<br>Contact via: info@spektor.nl<br>+31642080421<br>---------------</em><br><br> ^100 Is this correct...?<br><strong>Y/N\&gt;</strong>",
        function () {
            focusOnText();
            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if ($('#emailaddress').val().toLowerCase() == 'y') {
                    // Redirect
                    var prms = {
                        method: pmethod.toLowerCase(),
                        amount: amount
                    };
                    if(prms.method == 'ideal')
                        prms.issuer = issuer;
                    if(withEmail)
                        prms.emailaddress = email;
                    $.post('generatePaymentURL.php', prms, function(a)
                    {
                        if(a.result)
                            window.location = a.reason;
                        else {
                            switch(a.reason)
                            {
                                case 'issuer': alert('Something went wrong. Please re-enter the bank.'); donate4(); break;
                                case 'method': alert('Something went wrong. Please re-enter the method.'); donate2(); break;
                                case 'amount': alert('Something went wrong. Please re-enter the amount.'); donate3(); break;
                                default: alert('Something went wrong. Please try again.'); window.location.reload(); break;
                            }
                        }
                    });

                } else if ($('#emailaddress').val().toLowerCase == 'n') {
                    donate2();
                } else {
                    doLastCustom("<strong>Y/N\&gt;</strong>");
                }
            });
        }
    );
}

function donate5()
{
    startNewTyped("<strong>\&lt;swartzshield&gt;</strong>^200 That's okay. No hard feelings. ^500<br>Do you want to share this experience on Facebook?<br><br><strong>Y/N\&gt;</strong>",
        function () {
            focusOnText();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if($('#emailaddress').val().toLowerCase() == 'y')
                {
                    donate6();
                }
                else {
                    donate8();
                }
            });
        }
    );
}

function focusOnText() {
    $('.typed-cursor').css('display', 'none');
    $('#formEmailaddress').css('display', 'inline');
    //$('#emailaddress').css('display', 'inline');
    $('#emailaddress').focus();
}

function startNewTyped(strings, callback)
{
    // Clear events and such
    $('#formEmailaddress').off('submit');
    $('#emailaddress').val('');
    $('#formEmailaddress').css('display', 'none');

    if(typeof strings == 'string')
    {
        strings = [strings];
    }
    $('#typed').typed('reset');
    $("#typed").typed({
        strings: strings,
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: false,

        callback: callback
    });
}