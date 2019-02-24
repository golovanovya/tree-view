<?php

function setValue(&$array, $path, $value, $delimiter = '.')
{
    if ($path === null) {
        $array = $value;
        return;
    }
    $keys = is_array($path) ? $path : explode($delimiter, $path);
    while (count($keys) > 1) {
        $key = array_shift($keys);
        if (!isset($array[$key])) {
            $array[$key] = [];
        }
        if (!is_array($array[$key])) {
            $array[$key] = [$array[$key]];
        }
        $array = &$array[$key];
    }
    $array[array_shift($keys)] = $value;
}

function split_path()
{
    return function ($str) {
        return preg_split('/\\\\|\//', trim($str));
    };
}

function splitPath($diff, $splitter = null)
{
    if ($splitter === null) {
        $splitter = split_path();
    }
    return array_reduce($diff, function ($carry, $item) use ($splitter) {
        $splitted = $splitter($item);
        setValue($carry, $splitted, []);
        return $carry;
    }, []);
}

function prepare($diff, $splitter = null)
{
    if ($splitter === null) {
        $splitter = split_path();
    }
    return array_reduce($diff, function ($carry, $item) use ($splitter) {
        $splitted = $splitter($item);
        $carry[] = $splitted;
        return $carry;
    }, []);
}

function printHtmlTree($array, $id = '', $class = '')
{
    $str = '';
    $str .= "<ul id='$id' class='$class'>";
    foreach ($array as $key => $value) {
        $str .= '<li class="file-tree--node">';
        if (empty($value)) {
            $str .= '<span class="glyphicon glyphicon-file"></span> ';
            $str .= $key;
        } else {
            $str .= '<span class="glyphicon file-tree--folder glyphicon-folder-close"></span> ';
            $str .= $key;
            $str .= printHtmlTree($value);
        }
        $str .= '</li>';
    }
    $str .= '</ul>';
    return $str;
}

function printHtml1Tree($array, $id = '', $class = '')
{
    static $itemIdNum = 0;
    $str = '';
    $str .= "<ul id='$id' class='$class'>";
    foreach ($array as $key => $value) {
        $itemId = 'file-tree--item-' . $itemIdNum++;
        $str .= '<li class="file-tree--node">';
        $isFile = empty($value);
        if (!$isFile) {
            $str .= "<input type='checkbox' id='$itemId' class='file-tree--item-checkbox'>";
        }
        
        $str .= "<label for='$itemId'>$key</label>";
        
        if (!$isFile) {
            $str .= printHtml1Tree($value, '', '');
        }
        $str .= '</li>';
    }
    $str .= '</ul>';
    return $str;
}
