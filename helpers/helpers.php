<?php

function validTitle(string $title): bool {
    return strlen($title) > 3;
}
function validURL(string $url): bool {
    return filter_var($url, FILTER_VALIDATE_URL);
}