<?php

/**
 * @OA\Schema(
 *      title="Login",
 *      description="User Login request body data",
 *      @OA\Xml(
 *          name="Login"
 *      )  
 * )
 */

 class Login
 {
       /**
       * @OA\Property(
       *    title="email",
       *    description="email",
       *    example="email",
       * )
       * 
       * @var string
       */
      public $email;


      /**
       * @OA\Property(
       *    title="password",
       *    description="password",
       *    example="password",
       * )
       * 
       * @var string
       */
      public $password;
 }