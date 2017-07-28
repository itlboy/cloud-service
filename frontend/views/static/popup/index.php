<script>
    function SMcreateNewEvent(eventName) {
        if (typeof (Event) === 'function') {
            var event = new Event(eventName);
        } else {
            var event = document.createEvent('Event');
            event.initEvent(eventName, true, true);
        }
        return event;
    }

    var s$LoadedEvent = SMcreateNewEvent('s$Loaded');
    /**************************** Load jquery *****************************/
    loadLibrary('<?php echo $jqueryUrl ?>', function () {
        loadLibrary("//cdn.jsdelivr.net/velocity/1.5/velocity.min.js", function () {
            window.s$ = jQuery.noConflict(true);
            window.dispatchEvent(s$LoadedEvent);
        });
    });
//    loadLibrary("//cdn.jsdelivr.net/velocity/1.5/velocity.ui.min.js");

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
        this.updateOptionsEvent = SMcreateNewEvent("SMToolUpdateOptions");
        this.preview = false;
        this.preName = "SMTOOL_";
    }

    SMTool.prototype = {
        /*********************************** Helper Functions ***************************/
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = this.preName + cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        getCookie: function (cname) {
            var name = this.preName + cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return false;
        },
        /*********************************** Display Rules *****************************/
        checkDisplayFrequency: function () {
            var time = this.renderOptions.displayRules.displayFrequency;
            if (time == 0) {
                return true;
            }
            var userClosedTime = this.getCookie("userClosedTime");
            if (!userClosedTime) {
                return true;
            }
            if ((Date.now() - userClosedTime) < time) {
                return false;
            }
            return true;
        },
        checkDonotShowPages: function () {
            for (var key in this.renderOptions.displayRules.donotShowPages)
            {
                if (!this.renderOptions.displayRules.donotShowPages.hasOwnProperty(key)) {
                    continue;
                }
                var element = this.renderOptions.displayRules.donotShowPages[key];
                if (element.value.length == 0) {
                    continue;
                }
                var method = element.type + "Validate";
                if (this[method](element.value)) {
                    return true;
                }
            }
            return false;
        },
        urlHasStringValidate: function (value) {
            if (window.location.href.indexOf(value) != -1) {
                return true;
            }
            return false;
        },
        urlMatchValidate: function (value) {
            var currentUrl = this.formatUrl(window.location.href);
            value = this.formatUrl(value);
            var regex = this.convertToRegex(value);
            return regex.test(currentUrl);
        },
        formatUrl: function (url) {
            if (decodeURIComponent(url) == url) {
                url = encodeURI(url);
            }
            return url.replace(/(^\w+:|^)\/\/|\/$/, '');
        },
        convertToRegex: function (str) {
            str = str.replace(/[\-\/\[\]\{\}\(\)\+\.\\\^\$\|]/g, "\\$&")
                    .replace(/\*/g, '.*')
                    .replace(/\?/g, '\\?');
            return  new RegExp(str, "i");
        },
        enableToOpen: function () {
            if (this.preview) {
                return true;
            }
            return this.checkRules();
        },
        checkRules: function () {
            if (this.checkDisplayFrequency() && !this.checkDonotShowPages()) {
                return true;
            }
            return false;
        },
        /*********************************** Render functions ***************************/

        setOptions: function (options) {
            this.options = options;
        },
        render: function (options) {
            this.renderOptions = options; //this.convertFromCloudflareOptions(options);
            if (this.enableToOpen())
            {
                this.initContent();
                this.createCustomStyle();
            }
        },
        createCustomStyle: function () {
            if (this.renderOptions.hasOwnProperty("advanced"))
            {
                var style = this.renderOptions.advanced.customCss;
            } else {
                return;
            }
            if (!this.customStyleObject) {
                var id = this.preName + "custom-style";
                s$("body").append("<style id=\"" + id + "\"> </style>");
                this.customStyleObject = s$("#" + id);
            }
            this.customStyleObject.html(style);
        },
        iframeLoaded: function () {
            this.listenEvent();
            this.showContent();
        },
        listenEvent: function () {
            var _this = this;
            this.wraper.click(function () {
                if (_this.contentVisible) {
                    _this.userClose();
                }
            })
            s$(window).resize(function () {
                if (_this.contentVisible)
                    _this.updateContentBox()
            })
        },
        showContent: function () {
            this.content.show();
            var top = this.computeContentBox().top;
            var _this = this;
            this.content.velocity({
                top: top + "px",
            }, {
                duration: 500,
                easing: "easeOutBack",
                queue: "",
                begin: function () {
                    _this.wraper.css({
                        "background-color": "rgba(0, 0, 0, 0.8)",
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
            this.afterShowContent();
        },
        afterShowContent: function () {
        },
        afterUserClose: function () {
            this.setCookie("userClosedTime", Date.now(), 365);
        },
        userClose: function () {
            this.hideContent();
            this.afterUserClose();
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
        convertFromCloudflareOptions: function (cfOptions) {
            return {
                width: 600,
                height: 400,
                content: cfOptions.content,
                css: {
                    body: {
                        "background-image": "url(" + cfOptions.backgroundImage + ")",
                        color: "white",
                    },
                    '.title': {
                        color: "white"
                    }
                }
            };
        },
        computeContentBox: function () {
            var renderWidth = this.renderOptions.size.width;
            var renderHeight = this.renderOptions.size.height;
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
        updateIframe: function () {
            var compute = this.computeContentBox();
            this.content[0].width = compute.width;
            this.content[0].height = compute.height;
        },
        initIframe: function () {
            var iframe = document.createElement('iframe');
            this.content = s$(iframe);
            this.setIframeCss();
            iframe.id = "smtool-content";
            this.wraper[0].appendChild(iframe);
            this.updateIframe();
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
            this.contentFirstTop = -1 * this.renderOptions.size.height;
            this.content.css({
                display: "block",
                position: "relative",
                "margin-left": "auto",
                "margin-right": "auto",
                top: this.contentFirstTop,
                overflow: "hidden"
            });
        },
        updateOptions: function (options) {
            this.renderOptions = options;
            this.updateIframe();
            this.createCustomStyle();
            window.dispatchEvent(this.updateOptionsEvent);
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

    window.addEventListener("s$Loaded", function (e) {
        window.smtool = new SMTool({});
        var event = SMcreateNewEvent("SMToolLoaded")
        window.dispatchEvent(event);
    }, false)

</script>