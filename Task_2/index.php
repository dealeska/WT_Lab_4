<?php
    $page_text = file_get_contents('index.html');

function LoadData($id)
{
    $mySQL = mysqli_connect("localhost", "root", "", "dataBase");
    $SQL = "SELECT `image` FROM `imagenames` WHERE `id` = $id";
    $request = mysqli_query($mySQL, $SQL);
    if ($request)
        $data = mysqli_fetch_assoc($request);
    return $data['image'];

}

    $date = date('Y', time());
    $page_text = str_replace('{YEAR}', $date, $page_text);

    $bd_path_pattern = '/\{\s*DB=(?:(?!\{\"\})[\s\S])*\"\s*\}/';
    preg_match($bd_path_pattern, $page_text, $matched_bd_pattern);
    $bd_path = substr($matched_bd_pattern[0], strpos($matched_bd_pattern[0], '"') + 1);
    $bd_path = substr($bd_path, 0, strpos($bd_path, '"'));
    $bd_paste_value = LoadData($bd_path);
    $page_text = str_replace($matched_bd_pattern[0], $bd_paste_value, $page_text);



    $file_pattern = '/\{\s*FILE=(?:(?!\{\"\})[\s\S])*\"\s*\}/';
    preg_match($file_pattern, $page_text, $matched_pattern);
    $file_path = substr($matched_pattern[0], strpos($matched_pattern[0], '"') + 1);
    $substitution_file_path = substr($file_path, 0, strpos($file_path, '"'));
    $text_to_paste = file_get_contents($substitution_file_path);
    $page_text = str_replace($matched_pattern[0], $text_to_paste, $page_text);


    $file = '/\{\s*CONFIG=(?:(?!\{\"\})[\s\S])*\"\s*\}/';
    preg_match($file, $page_text, $matched);
    $file_path = substr($matched[0], strpos($matched[0], '"') + 1);
    $substitution_file_path = substr($file_path, 0, strpos($file_path, '"'));
    $text_to_paste = file_get_contents($substitution_file_path);
    $page_text = str_replace($matched[0], $text_to_paste, $page_text);

    $pageNames = array('all' => 'Распродажа',
                       'about' => 'О нас',
                       'order' => 'Заказ товара',
                       'contacts' => 'Контакты');

    $varPattern = '/\{\s*VAR=((?!\{VAR=|\"\})[\s\S])*\"\s*\}/';
    for ($i = 0; $i < count($pageNames); $i++) {
        preg_match($varPattern, $page_text, $matched_var_pattern);
        $var_name = substr($matched_var_pattern[0], strpos($matched_var_pattern[0], '"') + 1);
        $var_name = substr($var_name, 0, strpos($var_name, '"'));
        $page_text = str_replace($matched_var_pattern[0], $pageNames[$var_name], $page_text);
    }

    echo $page_text;
