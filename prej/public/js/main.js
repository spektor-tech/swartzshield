/**
 * Created by jasonderidder on 16-06-15.
 */
$(function(){

    $("#typed").typed({
        strings: [

            "^1000<strong>\&lt;swartzshield&gt;</strong>^200 Hi there friend,\n^2000Recently I,ve received an encrypted message from a lost brother.\n^1000After reading, it kept me awake for several nights.\n\n^2000Early 2015 the IDCDA launched a program called Gepetto.\n^1000With it they can monitor the entire web and profile everyone\nbased on interest ^1000 and the dirty stuff you like to watch online. \n^2000It will quarantine individuals who are likely to rebel.\n\n^2000But what program can actually decide who is a rebel or not...^1000 right?\n^1000As you read this, governments are plugging into Gepetto.\n^2000Will this be the end of our freedom?\n\n^2000To put an end to the program I've made a sacrifice.\n^2000Put myself on the radar, so they will come for me. \n^2000I made a program called Torigami^1000 and placed it on the dark web.\n^2000It can decypher several puzzles to get into the IDCDA mainframe.\n\n^1000Don&#39;t be afraid, \n^1000my friend M_REX will provide help when needed.\n\n^1000Will you help me reveal Gepetto?^1000\n\n<strong>&gt; y/n</strong>",
            //"Don&#39;t be afraid, \n^1000my friend M_REX will provide help when needed.\n\n^1000Will you help me reveal Gepetto?^1000\n\n<strong>&gt; y/n</strong>",
        ],
        typeSpeed: 0,
        backDelay: 500,
        loop: false,
        contentType: 'html', // or text
        // defaults to false for infinite loop
        loopCount: true,
        resetCallback: function() { newTyped(); },

        callback: function() {
            $('.typed-cursor').css('display', 'none');

            $('#formEmailaddress').css('display', 'inline');
            $('#emailaddress').css('display', 'inline');
            $('#emailaddress').focus();

            $('#formEmailaddress').on('submit', function(e) {
                e.preventDefault();
                if($('#emailaddress').val().toLowerCase() == 'y') {
                    stage1.pressedY();
                } else {
                    stage1.pressedN();
                }
            });
        }
    });

});

function newTyped(){ /* A new typed object */ }

function foo(){ console.log("Callback"); }

var stage1 = {
    pressedN: function() {
        $('#typed').html($('#typed').html() + ' ' + $('#emailaddress').val() + '<br><strong>&gt; y/n</strong>');
        $('#emailaddress').val('');
    },
    pressedY: function() {
        $('#formEmailaddress').off('submit');
        $('#emailaddress').val('');
        $('#emailaddress').blur();
        $('.stage2-in').css('opacity', 1);

        $("#typed").typed('reset');

        $('#typed').typed({
            strings: [

                "^1000<strong>\&lt;swartzshield&gt;</strong>^200 Thanks for your help.\nYou've got 25 minutes to decypher the puzzles\nand find Gepetto before the IDCDA will find you.\n\n<em>&lt;type <strong>'start</strong> when you're ready&gt;</em>"
            ],

            typeSpeed: 0,
            backDelay: 500,
            loop: false,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: false,
            callback: stage2.callback
        });
    }

}

var stage2 = {
    callback: function()
    {
        $('.typed-cursor').css('display', 'none');

        $('#formEmailaddress').css('display', 'inline');
        $('#emailaddress').css('display', 'inline');
        $('#emailaddress').focus();

        $('#formEmailaddress').on('submit', function(e) {
            e.preventDefault();
            if($('#emailaddress').val().toLowerCase() == 'start') {
                var hnamearr = window.location.hostname.split(".");
                window.location = 'http://game.' + hnamearr[hnamearr.length - 2] + '.' + hnamearr[hnamearr.length - 1] + '/#stage/0';
            } else {
                $('#typed').html($('#typed').html() + $('#emailaddress').val() + '<br><em>&lt;type <strong>start</strong> when you\'re ready&gt;</em>');
                $('#emailaddress').val('');

            }
        });
    }
}