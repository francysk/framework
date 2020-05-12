<?

namespace Francysk\Framework\Core;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();


class Tools
{
    static function monthName($id)
    {
        $aFields = [
          "1" => "Январь",
          "2" => "Февраль",
          "3" => "Март",
          "4" => "Апрель",
          "5" => "Май",
          "6" => "Июнь",
          "7" => "Июль",
          "8" => "Август",
          "9" => "Сентябрь",
          "10" => "Октябрь",
          "11" => "Ноябрь",
          "12" => "Декабрь"
        ];

        return $aFields[$id];
    }

    static function rusdate( $d, $format = 'j %MONTH% Y', $offset = 0 ) {
        $montharr = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        $dayarr = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');

        $d += 3600 * $offset;

        $sarr = array('/%MONTH%/i', '/%DAYWEEK%/i');
        $rarr = array($montharr[date("m", $d) - 1], $dayarr[date("N", $d) - 1]);

        $format = preg_replace($sarr, $rarr, $format);
        return date($format, $d);
    }

    static function rusdateShort( $d, $format = 'j %MONTH% Y', $offset = 0 )
    {
        $montharr = array('янв', 'фев', 'марта', 'апр', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        $dayarr = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');

        $d += 3600 * $offset;

        $sarr = array('/%MONTH%/i', '/%DAYWEEK%/i');
        $rarr = array($montharr[date("m", $d) - 1], $dayarr[date("N", $d) - 1]);

        $format = preg_replace($sarr, $rarr, $format);
        return date($format, $d);
    }

}
