<?php

require 'tree.php';

$diff = file(__DIR__ . '/diffs/test.txt');

$splittedPath = splitPath($diff);
$printedTree = printHtml1Tree($splittedPath, '', 'file-tree');
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
            .file-tree input[type=checkbox] {
                display: none;
            }
            .file-tree input[type=checkbox]:checked ~ ul {
                display: block;
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
            .file-tree--node label:before {
                margin-top: 5px;
                margin-bottom: 10px;
                /*font-size: 24px;*/
                position: relative;
                top: 1px;
                display: inline-block;
                font-family: 'Glyphicons Halflings';
                font-style: normal;
                font-weight: 400;
                line-height: 1;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .file-tree--node label:before {
                content: "\e022";
                margin-right: 5px;
            }
            .file-tree input[type=checkbox] ~ label:before {
                content: "\e117";
                color: #f0ad4e;
            }
            .file-tree input[type=checkbox]:checked ~ label:before {
                content: "\e118";
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div>
                <input type="button" value="expand all" onclick="expandAll()">
                <input type="button" value="collapse all" onclick="collapseAll()">
            </div>
            <?= $printedTree ?>
        </div>
        <script>
            function expandAll() {
                let elements = document.querySelectorAll('.file-tree--item-checkbox');
                for (let i = 0; i < elements.length; i++) {
                    elements[i].checked = true;
                }
            }
            function collapseAll() {
                let elements = document.querySelectorAll('.file-tree--item-checkbox');
                for (let i = 0; i < elements.length; i++) {
                    elements[i].checked = false;
                }
            }
        </script>
    </body>
</html>
