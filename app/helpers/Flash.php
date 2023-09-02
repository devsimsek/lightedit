<?php

function flashr(string $url, string $title, string $message, bool $hide = false, string $type = "info"): void
{
    flash->add($title, $message, $hide, $type);
    redirect($url);
}