<script>
    var s$LoadedEvent = new Event('s$Loaded');
    /**************************** Load jquery *****************************/
    (function () {
// Load the script
        var script = document.createElement("SCRIPT");
        script.src = '<?php echo $jqueryUrl ?>';
        script.type = 'text/javascript';
        script.onload = function () {
            window.s$ = jQuery.noConflict(true);
            window.dispatchEvent(s$LoadedEvent);
        };
        document.getElementsByTagName("head")[0].appendChild(script);
    })();
    /**************************** Main Object ****************************/
    var SMTool = function (options) {
        this.options = options;
        this.renderOptions = {};
        this.contentBox;
    }

    SMTool.prototype = {
        setOptions: function (options) {
            this.options = options;
        },
        render: function (options) {
            this.renderOptions = options;
            this.initContent();
        },
        iframeLoaded: function () {
            this.content.addClass("animated");
            this.content.addClass("bounceInDown");
            this.content.show();
        },
        resetCss: function () {
            this.content.css("border", "none");
            this.content.css("padding", 0);
            this.content.css("margin", 0);
        },
        initContent: function () {
            this.initWraper();
            this.initIframe();
        },
        initIframe: function () {
            var iframe = document.createElement('iframe');
            this.content = s$(iframe);
            iframe.id = "smtool-content";
            this.wraper[0].appendChild(iframe);
            iframe.width = this.renderOptions.width;
            iframe.height = this.renderOptions.height;
            var _this = this;
            var html = <?php echo $iframeContent ?>;
            this.content.hide();
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(html);
            this.content.on("load", function () {
                _this.iframeLoaded();
            })
            iframe.contentWindow.document.close();
            this.setIframeCss();
        },
        setIframeCss: function () {
            this.content.css({
                display: "table-cell",
                'vertical-align': "middle",
                "margin-left": "auto",
                "margin-right": "auto"
            });
        },
        initWraper: function () {
            var div = document.createElement('div');
            this.wraper = s$(div);
            div.id = "smtool-wraper";
            document.body.appendChild(div);
            this.setWraperCss();
        },
        setWraperCss: function () {
            this.wraper.css({
                position: "fixed",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%",
            })
        }
    }
    var smtool = new SMTool({});
    window.addEventListener("s$Loaded", function (e) {
        smtool.render({
            width: 600,
            height: 400,
            css: {
                body: {
                    "background-image": "url(http://www.technocrazed.com/wp-content/uploads/2015/12/beautiful-wallpaper-download-14.jpg)",
                    color: "white",
                },
                '.title': {
                    color: "white"
                }
            }
        });
    }, false)
</script>