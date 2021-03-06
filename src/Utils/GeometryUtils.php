<?php


namespace Jackal\ImageMerge\Utils;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimention;

class GeometryUtils
{
    const TOP_LEFT = 0;
    const TOP_RIGHT = 1;
    const BOTTOM_RIGHT = 2;
    const BOTTOM_LEFT = 3;

    public static function getClockwiseOrder(MultiCoordinateCommandOption $multiCoordinateCommandOption)
    {
        $coords = $multiCoordinateCommandOption->getCoordinates();

        $mostTop = self::getTopCoord($coords,2);
        $mostBottom = self::getBottomCoord($coords,2);

        $topLeft = self::getLeftCoord($mostTop)[0];
        $topRight = self::getRightCoord($mostTop)[0];
        $bottomLeft = self::getLeftCoord($mostBottom)[0];
        $bottomRight = self::getRightCoord($mostBottom)[0];

        return new MultiCoordinateCommandOption([
            self::TOP_LEFT => $topLeft,
            self::TOP_RIGHT => $topRight,
            self::BOTTOM_RIGHT => $bottomRight,
            self::BOTTOM_LEFT => $bottomLeft,
        ]);
    }

    /**
     * @param $coords
     * @param int $limit
     * @return Coordinate[]
     */
    public static function getLeftCoord($coords,$limit = 1){
        $c = $coords;
        usort($c,function (Coordinate $coordA,Coordinate $coordB){
            if($coordA->getX() == $coordB->getX()){
                return 0;
            }
            return ($coordA->getX() >= $coordB->getX()) ? 1 : -1;
        });

        return array_slice($c,0,$limit);
    }

    /**
     * @param $coords
     * @param int $limit
     * @return Coordinate[]
     */
    public static function getTopCoord($coords,$limit = 1){
        $c = $coords;
        usort( $c,function (Coordinate $coordA,Coordinate $coordB){
            if($coordA->getY() === $coordB->getY()){
                return 0;
            }
            return ($coordA->getY() >= $coordB->getY()) ? 1 : -1;
        });

        return array_slice($c,0,$limit);
    }

    /**
     * @param $coords
     * @param int $limit
     * @return Coordinate[]
     */
    public static function getRightCoord($coords,$limit = 1){
        $c = $coords;
        usort( $c,function (Coordinate $coordA,Coordinate $coordB){
            if($coordA->getX() === $coordB->getX()){
                return 0;
            }
            return ($coordA->getX() >= $coordB->getX()) ? -1 : 1;
        });

        return array_slice($c,0,$limit);
    }

    /**
     * @param $coords
     * @param int $limit
     * @return Coordinate[]
     */
    public static function getBottomCoord($coords,$limit = 1){
        $c = $coords;
        usort($c,function (Coordinate $coordA,Coordinate $coordB){
            if($coordA->getY() === $coordB->getY()){
                return 0;
            }
            return ($coordA->getY() >= $coordB->getY()) ? -1 : 1;
        });

        return array_slice($c,0,$limit);
    }
}
