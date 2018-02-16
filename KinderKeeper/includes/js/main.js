$(function() {
    var url = window.location.href;
    //general menu 
    $(".sidenav a").each(function() {
        // checks if its the same on the address bar
        if (url == (this.href)) {
            $(this).closest("li").addClass(" selected2");
        }
    });

    start();

    //Parsing the JSON file (eventlist.html)
    $.getJSON("includes/eventlist.json", function(data) {
        var length = data.Event4.length-1;
        for(; length>-1; length--)
            $('#chooseEvent form').prepend('<label class="container">' + data.Event4[length] + '<input type="radio" name="eventlist" value=" ' + data.Event4[length] + '"> <span class="checkmark"></span>  </label>');

        var length2 = data.Event3.length-1;
        for(; length2>-1; length2--)
            $('#chooseEvent2 form').prepend('<label class="container">' + data.Event3[length2] + '<input type="radio" name="eventlist" value=" ' + data.Event3[length2] + '"> <span class="checkmark"></span>  </label>');

        var length3 = data.Event2.length-1;
        for(; length3>-1; length3--)
            $('#chooseEvent3 form').prepend('<label class="container">' + data.Event2[length3] + '<input type="radio" name="eventlist" value=" ' + data.Event2[length3] + '"> <span class="checkmark"></span>  </label>');

        var length4 = data.Event1.length-1;
        for(; length4>-1; length4--)
            $('#chooseEvent4 form').prepend('<label class="container">' + data.Event1[length4] + '<input type="radio" name="eventlist" value=" ' + data.Event1[length4] + '"> <span class="checkmark"></span>  </label>');
        });
});

function start() {
    document.getElementById("triggerClose").addEventListener("click", function closeNav() {
        document.getElementById("mySidenav").className = "sidenav";
    });

    document.getElementById("triggerOpen").addEventListener("click", function openNav() {
        var w = window.innerWidth;
        if (w > 750) {
            document.getElementById("mySidenav").className = "sidenav defaultSN";
        }
        if (w < 750) {
            document.getElementById("mySidenav").className = "sidenav mobileSN";
        }
    });



};