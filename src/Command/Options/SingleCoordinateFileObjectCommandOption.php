<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 11/09/17
 * Time: 10.57
 */

namespace Jackal\ImageMerge\Command\Options;

class SingleCoordinateFileObjectCommandOption extends SingleCoordinateCommandOption
{
    public function __construct(\SplFileObject $imageObject, $x1, $y1)
    {
        parent::__construct($x1, $y1);
        $this->add('file_object', $imageObject);
    }

    public function getFileObject()
    {
        return $this->get('file_object');
    }
}