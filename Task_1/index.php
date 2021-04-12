<?php
    function CompareText($fileName)
    {
        if (!file_exists($fileName))
        {
            $file = fopen($fileName, 'wb');
            echo "noInformation";
            fclose($file);
        }
        else
        {
            $inputFile = fopen($fileName, 'rb');
            $content = file_get_contents($fileName);
            $ar = preg_replace('`(\b[А-ЯЁA-Z]{2,}\b)`u', '<span style="text-decoration:underline">$1</span>', $content);
            $content = preg_replace('/(\d)/', '<span style="color: blue">$1</span>', $ar);
            $new_str = preg_replace('/[\n]+/', "", $content);
            $j = 0;
            $fl_array = null;
            for ($i = 0; $i < strlen($new_str); $i++)
            {
                if ($new_str[$i] == "." || $new_str[$i] == "!" || $new_str[$i] == "?")
                {
                    $fl_array[$j++] = $new_str[$i];
                }
                elseif ($i == strlen($new_str) - 1)
                    $fl_array[$j] = "";
            }
            $keywords = preg_split("/[.!?]+/", $new_str);
            for ($i = 0; $i < count($keywords); $i++)
            {
                if ($keywords[$i] != "")
                    echo $keywords[$i] . $fl_array[$i] . "<br>";
            }
            fclose($inputFile);

        }
    }
?>





<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1">
    <meta name = "description" content="Спорт товары">
    <title>SuperSport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class = "section">
    <div class = "container">
        <div class = "form" align = "center">
            <?php
                echo "Ну давай проверим твой текст.<br>Он ведь лежит в файле example.txt, верно?";
            ?>
        </div>
        <form method = "post" class="form" align="center">
            <button class = "button" name = "getText">Нажми сюда</button>
        </form>
        <div class = "form" align="center">
            <?
            if (isset($_POST["getText"]))
            {
                CompareText("example.txt");
            }
            ?>
        </div>


    </div>
</section>


</body>
</html>