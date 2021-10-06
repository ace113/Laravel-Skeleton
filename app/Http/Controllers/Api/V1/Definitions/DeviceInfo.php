<?php

/**
 * @OA\Schema(
 *      title="DeviceInfo",
 *      description="device info request body data",
 *      @OA\Xml(
 *         name="DeviceInfo"
 *      )
 * )
 */

class DeviceInfo
{
    /**
     * @OA\Property(
     *      title="device_id",
     *      description="device id",
     *      example="1423454567"
     * )
     *
     * @var string
     */
    public $device_id;
    /**
     * @OA\Property(
     *      title="device_token",
     *      description="device_token",
     *      example="efalksfjaslkeeowfwnwkjfalkfjsa"
     * )
     *
     * @var string
     */
    public $device_token;
    /**
     * @OA\Property(
     *      title="device_type",
     *      description="device_type",
     *      example="1"
     * )
     *
     * @var string
     */
    public $device_type;
}