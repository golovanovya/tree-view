<?php

require 'tree.php';

$diff = file(__DIR__ . '/diffs/test.txt');

$splittedPath = splitPath($diff);
$printedTree = printHtmlTree($splittedPath, '', 'file-tree');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>File tree</title>
        <meta charset="UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Vue.js -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
        <style>
            .file-tree ul {
                display: none;
            }
            .file-tree--item-title {
                cursor: pointer;
            }
            .glyphicon-folder-close:before, .glyphicon-folder-open:before {
                color: #f0ad4e;
            }
            .glyphicon-file:before {
                color: #286090;
            }
            .file-tree li {
                list-style-type: none;
            }
            
            .file-tree--node__opened > .glyphicon:before {
                content: "\e118";
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div>
                <input type="button" value="expand all" class="file-tree--expand-all">
                <input type="button" value="collapse all" class="file-tree--collapse-all">
            </div>
            <?= $printedTree ?>
        </div>
        <script
            src="//code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
            crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
            $('body').click(function(e) {
                const el = e.target;
                if ($(el).hasClass('file-tree--node')) {
                    $(el).children('.file-tree--folder').toggleClass('glyphicon-folder-close');
                    $(el).children('.file-tree--folder').toggleClass('glyphicon-folder-open');
                    $(el).children('ul').toggle();
                }
                if ($(el).hasClass('file-tree--expand-all')) {
                    $('.file-tree .file-tree--folder').removeClass('glyphicon-folder-close');
                    $('.file-tree .file-tree--folder').addClass('glyphicon-folder-open');
                    $('.file-tree ul').show();
                }
                if ($(el).hasClass('file-tree--collapse-all')) {
                    $('.file-tree .file-tree--folder').addClass('glyphicon-folder-close');
                    $('.file-tree .file-tree--folder').removeClass('glyphicon-folder-open');
                    $('.file-tree ul').hide();
                }
            });
        </script>
    </body>
</html>
