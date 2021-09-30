<?php

/**
 * @OA\Schema(
 *    title="Register",
 *    description="User register request body",
 *    @OA\Xml(
 *      name="Register"
 *    )   
 * )
 */

 class Register
 {
    /**
     * @OA\Property(
     *      title="First Name",
     *      description="First Name",
     *      example="John",
     * )
     * 
     * @var string
     * 
     */
    public $first_name;   

    /**
     * @OA\Property(
     *      title="Last Name",
     *      description="Last Name",
     *      example="Cena",
     * )
     * 
     * @var string
     * 
     */
    public $last_name; 

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email",
     *      example="John@cena.com",
     * )
     * 
     * @var string
     * 
     */
    public $email;    

    /**
     * @OA\Property(
     *      title="Phone Number",
     *      description="Phone Number",
     *      example="John@cena.com",
     * )
     * 
     * @var string
     * 
     */
    public $phone;   
    
    /**
     * @OA\Property(
     *      title="Gender",
     *      description="Gender",
     *      example="male",
     * )
     */
    public $gender;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Password",
     *      example="password",
     * )
     */
    public $password;
 }