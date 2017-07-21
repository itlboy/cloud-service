<script>
    var s$LoadedEvent = new Event('s$Loaded');
    /**************************** Load jquery *****************************/
    loadLibrary('<?php echo $jqueryUrl ?>', function () {
    });
//    loadLibrary("//cdn.jsdelivr.net/velocity/1.5/velocity.ui.min.js");
    loadLibrary("//cdn.jsdelivr.net/velocity/1.5/velocity.min.js", function () {
        window.s$ = jQuery.noConflict(true);
        window.dispatchEvent(s$LoadedEvent);
    });
    function loadLibrary(scriptSrc, onload) {
        var script = document.createElement("SCRIPT");
        script.src = scriptSrc;
        script.type = 'text/javascript';
        script.onload = onload;
        document.getElementsByTagName("head")[0].appendChild(script);
    }
    /**************************** Main Object ****************************/
    var SMTool = function (options) {
        this.options = options;
        this.renderOptions = {};
        this.contentBox;
        this.contentVisible = false;
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
            this.listenEvent();
            this.showContent();
        },
        listenEvent: function () {
            var _this = this;
            this.wraper.click(function () {
                if (_this.contentVisible) {
                    _this.hideContent();
                }
            })
            s$(window).resize(function () {
                _this.updateContentBox()
            })
        },
        showContent: function () {
            this.content.show();
            var top = (window.innerHeight - this.renderOptions.height) / 2;
            var _this = this;
            this.content.velocity({
                top: top + "px",
            }, {
                duration: 500,
                easing: "easeOutBack",
                queue: "",
                begin: function () {
                    _this.wraper.css({
                        "background-color": "rgba(0, 0, 0, 0.3)",
                        "z-index": 9999999999
                    })
                },
                progress: undefined,
                complete: function () {
                    _this.contentVisible = true;
                },
                display: undefined,
                visibility: undefined,
                loop: false,
                delay: false,
                mobileHA: true
            });
        },
        hideContent: function () {
            var _this = this;
            this.content.velocity({
                top: this.contentFirstTop}, {
                duration: 500,
                easing: "easeInOutBack",
                queue: "",
                complete: function () {
                    _this.content.hide();
                    _this.wraper.css({
                        "background-color": "rgba(0, 0, 0, 0)",
                        "z-index": -1
                    })
                }
            })
        },
        resetCss: function (jqueryObject) {
            jqueryObject.css({
                "border": "none",
                "padding": 0,
                "margin": 0
            });
        },
        initContent: function () {
            this.initWraper();
            this.initIframe();
        },
        computeContentBox: function () {
            var renderWidth = this.renderOptions.width;
            var renderHeight = this.renderOptions.height;
            var width = Math.min(renderWidth, window.innerWidth);
            var height = Math.min(renderHeight, window.innerHeight);
            var ratio = (renderWidth * height) / (renderHeight * width);

            var top = (window.innerHeight - height) / 2 * 0.7;

            if (ratio !== 1) {
                height = Math.min(1, 1 / ratio) * height;
                width = Math.min(1, ratio) * width;
            }
            return  {
                width: width,
                height: height,
                top: top
            }
        },
        updateContentBox: function () {
            var computeBox = this.computeContentBox();
            this.content[0].width = computeBox.width;
            this.content[0].height = computeBox.height;
            this.content.css({
                top: computeBox.top
            })
        },
        initIframe: function () {
            var iframe = document.createElement('iframe');
            this.content = s$(iframe);
            this.setIframeCss();
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
        },
        setIframeCss: function () {
            this.resetCss(this.content);
            this.contentFirstTop = -1 * this.renderOptions.height;
            this.content.css({
                display: "block",
                position: "relative",
                "margin-left": "auto",
                "margin-right": "auto",
                top: this.contentFirstTop,
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
            this.resetCss(this.wraper);
            this.wraper.css({
                position: "fixed",
                top: 0,
                left: 0,
                width: "100%",
                height: "100%",
                "z-index": -1
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