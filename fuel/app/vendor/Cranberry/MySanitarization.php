<?php

namespace Cranberry;

class MySanitarization 
{
    /**
     * Remplace les caractères accentués par leurs homologues normaux.
     * 
     * @param type $string
     * @return type 
     */
    public static function stripAccents($string){
        $_remplace = array('à'=>'a',
                         'á'=>'a',
                         'â'=>'a',
                         'ã'=>'a',
                         'ä'=>'a',
                         'å'=>'a',
                         'ò'=>'o',
                         'ó'=>'o',
                         'ô'=>'o',
                         'õ'=>'o',
                         'ö'=>'o',
                         'è'=>'e',
                         'é'=>'e',
                         'ê'=>'e',
                         'ë'=>'e',
                         'ì'=>'i',
                         'í'=>'i',
                         'î'=>'i',
                         'ï'=>'i',
                         'ù'=>'u',
                         'ú'=>'u',
                         'û'=>'u',
                         'ü'=>'u',
                         'ÿ'=>'y',
                         'ñ'=>'n',
                         'ç'=>'c',
                         'ø'=>'0'
                         );
	return strtr((string) $string, $_remplace);
    }
    
    /**
     * Enlève les chiffres contenus dans un string.
     * 
     * @param type $string 
     */
    public static function filterAlpha($string)
    {
//        $pattern = '/[^[:digit:]\s]/';
        $pattern = '/[^\p{L} -]/u';

        return preg_replace($pattern, '', (string) $string);
    }
    
    /**
     * Met la 1ère lettre en majuscule et le reste en minuscule
     * 
     * @param type $str
     * @return type 
     */
    public static function ucFirstAndToLower($str)
    {
         return ucfirst(mb_strtolower(trim($str)));
    }
    
    /**
     * Retourne une string qui ne contient plus que des chiffres.
     * 
     * @param type $string
     * @return type 
     */
    public static function filterDigits($string)
    {
        $pattern = '/[^0-9]/';
        return preg_replace($pattern, '', (string) $string);
    }
    
    /**
     * Filtre le registre national et le renvoie correctement formaté.
     *
     * @param type $num
     * @return type 
     */
    public static function filterRegistreNational($num)
    {
        $num = \Cranberry\MySanitarization::filterDigits($num);
        return $num[0] . $num[1] . '.' . $num[2] . $num[3] . '.' . $num[4] . $num[5] . '-' . $num[6] . $num[7] . $num[8] . '.' . $num[9] . $num[10];
    }
    
    /**
     * Filtre le compte bancaire et le renvoie correctement formaté.
     *
     * @param type $num
     * @return type 
     */
    public static function filterCompteBancaire($num)
    {
        $num = \Cranberry\MySanitarization::filterDigits($num);
        return $num[0] . $num[1] . $num[2] . '-' . $num[3] . $num[4] . $num[5] . $num[6] . $num[7] . $num[8] . $num[9] . '-' . $num[10] . $num[11];
    }
}

?>
