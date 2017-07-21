<html>
    <head>
        <script>
            var smtool = parent.smtool;
        </script>
        <script src="<?php echo $jqueryUrl ?>">
        </script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <style>
            * {
                border: none;
                margin: 0px;
                padding: 0px;
            }
            .center {
                text-align: center;
            }
            .overflow-bg {
                position: fixed;
                width: 100%;
                height: 100%;
                z-index: -1;
                background-color: rgba(0, 0, 0, 0.15);
                top:0;
            }
        </style>
        <div class="overflow-bg">
        </div>
        <div class="title">
            <h1 class="center">Hello world!</h1>
        </div>
        <div class="content">
            <h3 class="center">Chao mung ban den voi beautiful popup</h3>
        </div>
        <script>
            var width = smtool.renderOptions.width;
            var height = smtool.renderOptions.height;
            $(".title").css("margin-top", height / 4)

            $.each(smtool.renderOptions.css, function (selector, values) {
                $(selector).css(values);
            })
        </script>
    </body>
</html>