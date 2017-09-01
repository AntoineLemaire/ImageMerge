<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 31/08/17
 * Time: 14.59
 */

namespace Jackal\ImageMerge\Model\Font;

use Jackal\ImageMerge\Exception\InvalidFontException;

class Font
{
    const FONT_ARIAL = 'arial';

    private $fontPathname;

    private static function getFonts()
    {
        $directory = dirname(__FILE__).'/../../Resources/Fonts/';
        return [
            self::FONT_ARIAL => $directory.'arial.ttf'
        ];
    }

    private function __construct($fontPathname)
    {
        $this->fontPathname =  $fontPathname;
    }

    private static function fromSavedFont($fontName)
    {
        $fonts = Font::getFonts();

        if (!isset($fonts[$fontName])) {
            throw new InvalidFontException($fontName);
        }

        if (!is_file($fonts[$fontName])) {
            throw new InvalidFontException($fonts[$fontName]);
        }

        return new Font($fonts[$fontName]);
    }

    public static function arial()
    {
        $fonts = Font::getFonts();
        return new Font($fonts[Font::FONT_ARIAL]);
    }

    public function __toString()
    {
        return $this->fontPathname;
    }
}
