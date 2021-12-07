<?php

/**
 * @OA\Schema(
 *      title="UploadImage",
 *      description="Profile image",
 *      @OA\Xml(
 *         name="UploadImage"
 *      )
 * )
 */

class UploadImage
{
    /**
     * @OA\Property(
     *      title="image",
     *      description="Image Format['jpg', 'jpeg', 'png']",
     *      example="1423454567.jpg",
     *      type="string",
     *      format="file"
     *      
     * )
     *
     * @var string
     */
    public $image;
  
}