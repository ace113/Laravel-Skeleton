<?php

/**
 * @OA\Schema(
 *      title="UpdateProfile",
 *      description="Update profile request body data",
 *      @OA\Xml(
 *          name="UpdateProfile"
 *      )
 * )
 */

 class UpdateProfile
 {
    /**
     * @OA\Property(
     *      title="first_name",
     *      description="First Name",
     *      example="admin",
     * )
     * 
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property(
     *      title="last_name",
     *      description="Last Name",
     *      example="admin",
     * )
     * 
     * @var string
     */
    public $last_name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email",
     *      example="admin@admin.com",
     * )
     * 
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="phone",
     *      description="Mobile Number",
     *      example="954949494",
     * )
     * 
     * @var string
     */
    public $phone;

    /**
     * @OA\Property(
     *      title="gender",
     *      description="Gender:male,female,other",
     *      example="male",
     * )
     * 
     * @var string
     */
    public $gender;
 }