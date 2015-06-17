/**
 * Created by jasonderidder on 16-06-15.
 */

$(function(){

    var thanks = "<em>[Payment Status] </em>";
    switch(payedstatus)
    {
        case 'open':
            thanks += "Open - type 'restart' to retry";
            break;
        case 'cancelled':
            thanks += "Cancelled - type 'restart' to retry";
            break;
        case 'expired':
            thanks += "Expired - You waited too long. <br>    type 'restart' to retry";
            break;
        case 'pending':
            thanks += "Pending - We are waiting for the payment provider to confirm<br>    This can take some time. But don't worry, this will happen soon AND you are a hero already.<br><strong style='color: green'>Thank you so much!</strong>";
            break;
        case 'paid':
            thanks += "Paid<br>    <strong style='color: green'>You are the best!! <br>Thank you very much.</strong>";
            break;
        default:
            thanks += "Unknown - I seriously don't know. <br><strong style='color: red'>Please contact us at info@spektor.nl, with the provided payment id.</strong>";
            break;
    }

    var payinfo = "<em>[Payment ID] </em>" + paymentId;
    if(withEmail)
        payinfo += "<br>    This information will be sent to your email as well.";
    else
        payinfo += "<br><strong style='color: red'>Safe this info carefully. It is needed when you contact me regarding the payment.</strong>";

    startNewTyped("^1000<strong>\&lt;swartzshield&gt;</strong>^200 Welcome back!^1000 <br><br>" +thanks+" ^500<br>"+payinfo+" ^1000<br><br><strong>Command or empty return\&gt;</strong>",
        function() {
            focusOnText();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if($('#emailaddress').val() == '') {
                    share();
                }
                else if($('#emailaddress').val().toLowerCase() == 'restart')
                {
                    window.location = 'outro.php';
                }
            });
        }
    );

});

function share()
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