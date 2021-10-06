<?php

/**
 * @OA\Schema(
 *      title="ChangePassword",
 *      description="Change the user password",
 *      @OA\Xml(
 *          name="ChangePassword",
 *      )
 * )
 */

 class ChangePassword
 {
    /**
     * @OA\Property(
     *     title="current_password",
     *     description="Current Password",
     *     example="password"
     * )
     * 
     * @var string
     */
    public $current_password;

    /**
     * @OA\Property(
     *     title="password",
     *     description="New Password",
     *     example="password"
     * )
     * 
     * @var string
     */
    public $password;
 }