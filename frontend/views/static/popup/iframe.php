<html>
    <head>
        <script>
            var smtool = parent.smtool;
            console.log("options", smtool.renderOptions);
        </script>
        <script src="<?php echo $jqueryUrl ?>">
        </script>
        <!-- Latest compiled and minified CSS -->
        <!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                 Optional theme 
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
                 Latest compiled and minified JavaScript 
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
    </head>
    <body>
        <style>
            * {
                border: none;
                margin: 0px;
                padding: 0px;
                overflow: hidden;
                color: white;
                font-size: 3.5vw;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                line-height: 1.42857
            }
            .center {
                text-align: center;
            }
            .overflow-bg {
                position: fixed;
                width: 100%;
                height: 100%;
                z-index: -1;
                background-color: rgba(0, 0, 0, 0.4);
                top:0;
            } 
            .background {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: -1;
            }
            h1 {
                font-size: 6vw;
            }
            h2 {
                font-size: 5.2vw;
            }
            h3 {
                font-size: 4.7vw;
            }
            h4 {
                font-size: 4.5vw;
            }
            .close-button:after{
                display: inline-block;
                content: "\00d7"; /* This will render the 'X' */
                color: #cccccc;
                cursor: pointer;
            }
            .close-button:hover:after {
                color: white;
            }
            .close-button {
                float: right;
                display: block;
                line-height: 15px;
                font-size: 6vw;
                margin: 7px;
            }
        </style>
        <img class="background" src="" />
        <div class="overflow-bg"></div>
        <div class="close-button"></div>

        <!--        <div class="title">
                    <h1 class="center">Hello world!</h1>
                </div>-->
        <div class="content center">
        </div>

        <script>
            function run() {
                var backgroundImage;
                if (smtool.renderOptions.backgroundImage)
                {
                    backgroundImage = smtool.renderOptions.backgroundImage;
                } else {
                    var randomImages = <?php echo $randomImages ?>;
                    var randomImage = randomImages[Math.floor(Math.random() * randomImages.length)];
                    backgroundImage = "https://cloud.tech1412.com/img/popup/" + randomImage;
                }
                $(".background").attr("src", $(".background").attr("src") || backgroundImage)

//                var width = smtool.renderOptions.width;
//                var height = smtool.renderOptions.height;
                $(".content").css("margin-top", "24vh");
                $(".content").html(smtool.renderOptions.content);
                $.each(smtool.renderOptions.css, function (selector, values) {
                    $(selector).css(values);
                })
            }
            run();
            parent.addEventListener("SMToolUpdateOptions", function () {
                run();
            })
            $(".close-button").click(function () {
                smtool.userClose();
            })
        </script>
    </body>
</html>