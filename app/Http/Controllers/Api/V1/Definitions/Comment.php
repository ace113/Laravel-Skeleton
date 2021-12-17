<?php

/**
 * @OA\Schema(
 *      title="Comment",
 *      description="Comment request body",
 *      @OA\Xml(
 *          name="Comment",
 *      )
 * )
 */

 class Comment
 {
     /**
      * @OA\Property(
      *     title="comment",
      *     description="Comment",
      *     example="This is comment"
      * )
      * @var string
      */
      public $comment;

     /**
      * @OA\Property(
      *     title="name",
      *     description="name",
      *     example="John Cena"
      * )
      * @var string
      */
      public $name;

     /**
      * @OA\Property(
      *     title="email",
      *     description="email",
      *     example="john@cena.com"
      * )
      * @var string
      */
      public $email;

     /**
      * @OA\Property(
      *     title="parent_id",
      *     description="replies to comment. Put 0 if it is not a reply",
      *     example="0"
      * )
      * @var integer
      */
      public $parent_id;
 }

