<?php

require 'tree.php';

$diff = file(__DIR__ . '/diffs/test.txt');

$splittedPath = splitPath($diff);

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
        
        <style>
            #file-tree ul {
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
            .file-tree--block {
                list-style-type: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div id="app">
                <div v-show="loading">loading..</div>
                <div v-show="!loading">
                    <button @click="expand">Expand all</button>
                    <button @click="collapse">Collapse all</button>
                    <ul>
                        <item
                            v-for="(item, index) in tree"
                            :name="index"
                            :items="item"
                            ref="items"
                        ></item>
                    </ul>
                </div>
            </div>
        </div>
        <script
            src="//code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
            crossorigin="anonymous"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- item template -->
        <script type="text/x-template" id="item-template">
            <li class="file-tree--block" @expand-event="expand">
                <div
                    @click="toggle"
                    class="file-tree--item-title"
                >
                    <span class="glyphicon" :class="classIcon"></span>
                    {{ name }}
                </div>
                <ul v-if="hasChildren" v-show="open">
                    <item
                        v-for="(item, index) in items"
                        :name="index"
                        :items="item"
                        ref='items'>
                        </item>
                </ul>
            </li>
        </script>

        <!-- Vue.js -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
        <script>
            data = JSON.parse('<?= json_encode($splittedPath) ?>');
        </script>
        <script>
            const collapse = {
                methods: {
                    expand: function() {
                        this.open = true;
                        if (this.$refs.items) {
                            this.$refs.items.map(c => c.expand());
                        }
                    },
                    collapse: function() {
                        this.open = false;
                        if (this.$refs.items) {
                            this.$refs.items.map(c => c.collapse());
                        }
                    }
                }
            };
            // define the item component
            Vue.component('item', {
                template: '#item-template',
                mixins: [collapse],
                props: {
                    name: '',
                    items: null
                },
                data: function() {
                    return {
                        open: false
                    };
                },
                computed: {
                    hasChildren: function() {
                        return this.items &&
                            Object.keys(this.items).length;
                    },
                    classIcon: function() {
                        return {
                            'glyphicon-file': !this.hasChildren,
                            'glyphicon-folder-open': this.open && this.hasChildren,
                            'glyphicon-folder-close': !this.open && this.hasChildren
                        };
                    }
                },
                methods: {
                    toggle: function() {
                        this.open = this.hasChildren && !this.open;
                    }
                }
            });
            const app = new Vue({
                el: '#app',
                mixins: [collapse],
                data: () => {
                    return {
                        loading: true,
                        tree: data,
                        open: false
                    };
                },
                created: function() {
                    this.loading = false;
                }
            });
        </script>
    </body>
</html>
