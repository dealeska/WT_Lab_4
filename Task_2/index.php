<?php
    $page_text = file_get_contents('index.html');

    $date = date('Y', time());
    $page_text = str_replace('{YEAR}', $date, $page_text);

    $file_pattern = '/\{\s*FILE=((?!\{\"\})[\s\S])*\"\s*\}/';
    preg_match($file_pattern, $page_text, $matched_pattern);
    $file_path = substr($matched_pattern[0], strpos($matched_pattern[0], '"') + 1);
    $substitution_file_path = substr($file_path, 0, strpos($file_path, '"'));
    $text_to_paste = file_get_contents($substitution_file_path);
    $page_text = str_replace($matched_pattern[0], $text_to_paste, $page_text);

    echo $page_text;