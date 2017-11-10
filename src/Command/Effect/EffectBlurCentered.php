<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 08/09/17
 * Time: 15.39
 */

namespace Jackal\ImageMerge\Command\Effect;

use Jackal\ImageMerge\Builder\ImageBuilder;
use Jackal\ImageMerge\Command\AbstractCommand;
use Jackal\ImageMerge\Command\Options\DimensionCommandOption;
use Jackal\ImageMerge\Command\Options\DoubleCoordinateColorCommandOption;
use Jackal\ImageMerge\Command\Options\SingleCoordinateFileObjectCommandOption;
use Jackal\ImageMerge\Command\Asset\ImageAssetCommand;
use Jackal\ImageMerge\Command\Asset\SquareAssetCommand;
use Jackal\ImageMerge\Model\Coordinate;
use Jackal\ImageMerge\Model\File\File;
use Jackal\ImageMerge\Model\File\FileTemp;
use Jackal\ImageMerge\Model\Image;

class EffectBlurCentered extends AbstractCommand
{
    /**
     * EffectBlurCentered constructor.
     * @param Image $image
     * @param DimensionCommandOption $options
     */
    public function __construct(Image $image, DimensionCommandOption $options)
    {
        parent::__construct($image, $options);
    }

    /**
     * @return Image
     */
    public function execute()
    {
        /** @var DimensionCommandOption $options */
        $options = $this->options;

        $builder = ImageBuilder::fromImage($this->image);

        $originalWidth = $this->image->getWidth();
        $originalHeight = $this->image->getHeight();

        if ($originalHeight > $options->getHeight()) {
            $builder->thumbnail(null, $options->getHeight() - 4);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        if ($originalWidth > $options->getWidth()) {
            $builder->thumbnail($options->getWidth() - 4, null);
            $originalWidth = $this->image->getWidth();
            $originalHeight = $this->image->getHeight();
        }

        $originalImg = $this->saveImage($this->image);

        $builder->resize($options->getWidth(), $options->getHeight());
        $builder->blur(40);
        $builder->brightness(-70);

        $x = round(($options->getWidth() - $originalWidth) / 2);
        $y = round(($options->getHeight() - $originalHeight) / 2);

        $borderColor = 'FFFFFF';

        $builder->addSquare($x - 1, $y - 1,$x + $originalWidth, $y + $originalHeight,$borderColor);

        $builder->merge(Image::fromFile($originalImg),$x, $y);

        return $builder->getImage();
    }

    /**
     * @param Image $image
     * @return File
     */
    private function saveImage(Image $image)
    {
        return FileTemp::fromString($image->toPNG());
    }
}
