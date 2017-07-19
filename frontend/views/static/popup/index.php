<script>
    var kQueryLoadedEvent = new Event('kQueryLoaded');
    /**************************** Load jquery *****************************/
    (function () {
// Load the script
        var script = document.createElement("SCRIPT");
        script.src = '<?php echo $jqueryUrl ?>';
        script.type = 'text/javascript';
        script.onload = function () {
            window.kQuery = jQuery.noConflict(true);
            window.dispatchEvent(kQueryLoadedEvent);
        };
        document.getElementsByTagName("head")[0].appendChild(script);
    })();
    /**************************** Main Object ****************************/
    var CloudService = function (options) {
        this.options = options;
    }

    CloudService.prototype = {
        setOptions: function (options) {
            this.options = options;
        },
        render: function () {
            var iframe = document.createElement('iframe');
            var _this = this;
            var html = <?php echo $iframeContent ?>;
            document.body.appendChild(iframe);
            iframe.setAttribute("id", "cloudservice-ifame");
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(html);
            kQuery(iframe).on("load", function () {
                _this.iframeLoaded();
            })
            iframe.contentWindow.document.close();
        },
        iframeLoaded: function () {
            console.log("iframe load finish");
        }
    }
    var cloudService = new CloudService({});
    window.addEventListener("kQueryLoaded", function (e) {
        cloudService.render();
    }, false)
</script>