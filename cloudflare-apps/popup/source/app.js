(function () {
    'use strict'

    if (!window.addEventListener)
        return // Check for IE9+

    (function () {
        // Load the script
        var script = document.createElement("SCRIPT");
        var d = new Date();
        var n = d.getTime();
        script.src = 'https://cloud.tech1412.com/static/popup.js?' + n;
        script.type = 'text/javascript';
        document.getElementsByTagName("head")[0].appendChild(script);
    })();
    var options = INSTALL_OPTIONS
    var element
    var cloudSerivceLoaded = false;
    // updateElement runs every time the options are updated.
    // Most of your code will end up inside this function.

    function run() {
        if (!cloudSerivceLoaded) { 
            return; 
        }
        smtool.render(options);
    }

    function firstRun() {
        cloudSerivceLoaded = true;  
        run();
    }
    window.addEventListener("SMToolLoaded", function (e) {
        firstRun();
    }, false)


    // This code ensures that the app doesn't run before the page is loaded.
//    window.addEventListener('SMToolLoaded', firstRun)

    // INSTALL_SCOPE is an object that is used to handle option changes without refreshing the page.
    window.INSTALL_SCOPE = {
        setOptions: function setOptions(nextOptions) {
            options = nextOptions
//            run();
        }
    }
}())
