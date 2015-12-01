<!DOCTYPE html>
<html>
    <head>
        <title>Pagination Test</title>
        <link href="{{ URL::asset('/') }}css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <div style="margin: 200px 500px; text-align: center;">
        <div style="font-size: 40px; margin-bottom: 40px;">Pagination Test</div>
        <?php
            echo $page->show();
        ?>
    </div>
    </body>
</html>
