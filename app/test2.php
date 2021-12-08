<?php
/**
 * Сокращение текста
 * 
 * @param string  $text   - Текст для обработки
 * @param string  $link   - Ссылка на оригинал
 * @param integer $length - Длина сокращённого текста
 * 
 * @return string
 */
function reduction($text, $link = '?', $length = 75)
{
    if (mb_strlen($text, 'UTF-8') > $length) {
        $substr = mb_substr($text, 0, $length, 'UTF-8');

        $text = strpos($substr, ' ') !== false 
            ? preg_replace('~(\s)?(?(1)\S+$|\s$)~', '', $substr) 
            : strstr($text, ' ', true);

        $text .= " ... <a href='$link'><span style='color:red;'>&raquo;&raquo;</span></a>";
    }

    return $text;
}


$text = 'PHP — скриптовый язык программирования общего назначения, активно применяемый для разработки веб-приложений. Используйте эту метку, если у Вас возникли вопросы по применению данного языка или о самом языке';

echo reduction($text);