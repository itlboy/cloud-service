(function() {
    'use strict'

    if (!window.addEventListener)
        return // Check for IE9+

    (function() {
        // Load the script
        var script = document.createElement("SCRIPT");
        var d = new Date();
        var n = d.getTime();
        script.src = 'http://storage.cloud.tech1412.com/js/test.js?' + n;
        script.type = 'text/javascript';
        document.getElementsByTagName("head")[0].appendChild(script);
    })();

    var options = INSTALL_OPTIONS
    var element
    var cloudSerivceLoaded = false;
    // updateElement runs every time the options are updated.
    // Most of your code will end up inside this function.
    function updateElement() {
        if (!cloudSerivceLoaded) {
            return;
        }
        cloudService.render(options);
        element = INSTALL.createElement(options.location, element)

        // Set the app attribute to your app's dash-delimited alias.
        element.setAttribute('app', 'example')
        element.innerHTML = options.message
    }

    function firstRun() {
        cloudSerivceLoaded = true;
        updateElement();
    }

    // This code ensures that the app doesn't run before the page is loaded.
    window.addEventListener('cloudServiceLoaded', firstRun)

    // INSTALL_SCOPE is an object that is used to handle option changes without refreshing the page.
    window.INSTALL_SCOPE = {
        setOptions: function setOptions(nextOptions) {
            options = nextOptions
            updateElement()
        }
    }
}())
