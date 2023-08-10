<?php

/** Format News Tags */

function formatTags(array $tags): String
{
    // dd($tags);
    return implode(',', $tags);
}
