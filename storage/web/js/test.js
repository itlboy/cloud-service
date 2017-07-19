var kQueryLoadedEvent = new Event('kQueryLoaded');
/**************************** Load jquery *****************************/
(function () {
    // Load the script
    var script = document.createElement("SCRIPT");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
    script.type = 'text/javascript';
    script.onload = function () {
        window.kQuery = jQuery.noConflict(true);
        window.dispatchEvent(kQueryLoadedEvent);
    };
    document.getElementsByTagName("head")[0].appendChild(script);
})();
/**************************** Main Object ****************************/
window.addEventListener("kQueryLoaded", function (e) {

}, false)


var CloudService = function (options) {
    this.options = options;
}

CloudService.prototype = {
    setOptions: function (options) {
        this.options = options;
    },
    render: function () {
        var iframe = document.createElement('iframe');
        var html = '<body><script>alert("hehehe")</script></body>';
        document.body.appendChild(iframe);
        iframe.contentWindow.document.open();
        iframe.contentWindow.document.write(html);
        iframe.contentWindow.document.close();
    }
}
var cloudService = new CloudService({});
cloudService.render();