<?php
/**
 * LeandroRosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://github.com/leandro-rosa for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2022 Leandro Rosa (https://github.com/leandro-rosa)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */

namespace LeandroRosa\Framework\Api;

interface ClientInterface
{
    /**
     * @param TransferInterface $transfer
     * @param GenericBuildInterface $responseBuild
     * @param GenericCommandInterface|null $responseValidator
     *
     * @return mixed
     */
    public function placeRequest(
        TransferInterface $transfer,
        GenericBuildInterface $responseBuild,
        GenericCommandInterface $responseValidator = null
    );
}
