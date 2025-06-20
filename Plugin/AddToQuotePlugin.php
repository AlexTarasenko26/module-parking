<?php

declare(strict_types=1);

namespace Epam\Parking\Plugin;

use Magento\Quote\Model\Quote;
use Magento\Framework\DataObject;
use Magento\Catalog\Model\Product;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Exception\LocalizedException;

class AddToQuotePlugin
{
    public function __construct(
        private readonly Json $json
    ){ }
    public function beforeAddProduct(Quote $subject, Product $product, $request = null)
    {
        if ($request instanceof DataObject && (int) $product->getData('is_parking_ticket') === 1) {
            $carNumber = $request->getData('car_number');
            $startTime = $request->getData('start_time');
            $endTime = $request->getData('end_time');

            if (!$carNumber || !$startTime || !$endTime) {
                throw new LocalizedException(
                    __('Parking ticket fields are required.')
                );
            }

            if (strtotime($startTime) >= strtotime($endTime)) {
                throw new LocalizedException(
                    __('Start time must be earlier than end time.')
                );
            }

            $request->setData('additional_options', [
                ['label' => 'Car Number', 'value' => $carNumber],
                ['label' => 'Start Time', 'value' => $startTime],
                ['label' => 'End Time', 'value' => $endTime]
            ]);
        }

        return [$product, $request];
    }

    public function afterAddProduct(
        Quote $subject,
              $result,
        Product $product,
        $request = null
    ) {
        if (
            $request instanceof \Magento\Framework\DataObject
            && (int) $product->getData('is_parking_ticket') === 1
            && is_object($result)
        ) {
            $additionalOptions = [
                ['label' => 'Car Number', 'value' => $request->getData('car_number')],
                ['label' => 'Start Time', 'value' => $request->getData('start_time')],
                ['label' => 'End Time', 'value' => $request->getData('end_time')]
            ];

            $existingOption = $result->getOptionByCode('additional_options');
            $existing = $existingOption ? (array) $this->json->unserialize($existingOption->getValue()) : [];

            $mergedOptions = array_merge($existing, $additionalOptions);

            $result->addOption([
                'code'  => 'additional_options',
                'value' => $this->json->serialize($mergedOptions),
            ]);
        }

        return $result;
    }

}
