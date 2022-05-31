<?php
namespace Ajax;
use \Ajax\Response;
use Bitrix\Sale,
    Bitrix\Main,
    Bitrix\Currency;

class Order
{
    public static function addToBasket($products) {
        if (!$products) return false;
        $response = new Response();
        try {
            if(!\CModule::IncludeModule("sale")) throw new Exception('Не подключен модуль sale');
            $basket = Sale\Basket::create(SITE_ID);
            foreach ($products as $product) {
                $item = $basket->createItem("catalog", $product["ID"]);
                unset($product["ID"]);
                $item->setFields($product);
            }
            //$basket->save();
            return $basket;
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
    public static function addToOrder($basket, $withPay = true, $customPrice = false, $isCheckNeeded = false, $checkData = false) {
        if (!$basket) return false;
        $response = new Response();
        try {
            if(!\CModule::IncludeModule("sale")) throw new Exception('Не подключен модуль sale');
            if(!\CModule::IncludeModule("catalog")) throw new Exception('Не подключен модуль catalog');
            global $USER;
            $order = Sale\Order::create(SITE_ID, $USER->GetID());
            $order->setPersonTypeId(1);
            $order->setBasket($basket);
            //if ($customPrice) {$order->setField('PRICE', $customPrice);}

            if ($withPay) {
                $paymentCollection = $order->getPaymentCollection();
                $payment = $paymentCollection->createItem(
                    Sale\PaySystem\Manager::getObjectById(2)
                );
                $payment->setField("SUM", $customPrice ? : $order->getPrice());
                $payment->setField("CURRENCY", $order->getCurrency());
            } else {

                if(!empty($isCheckNeeded)) {

                    $order->setField('STATUS_ID', 'PP');

                    $collection = $order->getPropertyCollection();

                    if (!empty($checkData)) {
                        $propertyValue = $collection->getItemByOrderPropertyId(1);
                        $propertyValue->setField('VALUE', $checkData);
                    }

                } else {
                    $order->setField('STATUS_ID', 'F');
                }

            }
            $order->doFinalAction(true);
            $result = $order->save();
            if (!$result->isSuccess()) {
                throw new \Exception($result->getErrors());
            } else {
                // $orderId = $order->getId();
                // if (!$withPay) {
                //     $orderNew = Sale\Order::load($orderId);
                //     if(!empty($isCheckNeeded)) {
                //
                //         $orderNew->setField('STATUS_ID', 'PP');
                //
                //         $collection = $orderNew->getPropertyCollection();
                //
                //         if (!empty($checkData)) {
                //             $propertyValue = $collection->getItemByOrderPropertyId(1);
                //             $propertyValue->setField('VALUE', $checkData);
                //         }
                //
                //     } else {
                //         $orderNew->setField('STATUS_ID', 'F');
                //     }
                //     $orderNew->save();
                //     $result = $orderNew->save();
                //     if (!$result->isSuccess()) {
                //         throw new Exception($result->getErrors());
                //     }
                // }
                return $orderId;
            }
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
    public static function addEventInOrder()
    {
        $response = new Response();
        try {
            if(!\CModule::IncludeModule("iblock")) throw new Exception('Не подключен модуль iblock');
            if(!\CModule::IncludeModule("sale")) throw new Exception('Не подключен модуль sale');
            if(!\CModule::IncludeModule("catalog")) throw new Exception('Не подключен модуль catalog');

            global $USER;
            $request = Main\Application::getInstance()->getContext()->getRequest();
            //$siteOptions = siteOptions();

            $arSelect = Array("ID", "NAME",
                "DETAIL_PAGE_URL",
                "PROPERTY_UF_REGISTER_PAY",
                "PROPERTY_UF_POINTS_PROTECO",
                "PROPERTY_UF_POINTS_HMO",
                "PROPERTY_IS_CHECK_NEEDED"
            );

            $arFilter = Array("IBLOCK_ID"=>3, "ID" => $request->getPost('ID'), "ACTIVE"=>"Y");
            $prodOb = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            if($prodArr = $prodOb->GetNext()) {
                //$points = $prodArr['PROPERTY_UF_POINTS_PROTECO_VALUE'] ? : $siteOptions['UF_POINTS_PROTECO']['VALUE'];
                $points = $prodArr['PROPERTY_UF_POINTS_PROTECO_VALUE'];
                if ($prodArr['PROPERTY_UF_REGISTER_PAY_VALUE']) {
                    $withPay = true;
                    $productPrice = IntVal($prodArr['PROPERTY_UF_REGISTER_PAY_VALUE']);
                } else {
                    $withPay = false;
                    $productPrice = 0;
                }

                $isCheckNeeded = $checkData = false;
                if(!empty($prodArr['PROPERTY_IS_CHECK_NEEDED_VALUE'])) {
                    $isCheckNeeded = true;
                    $checkData = $request->getPost('PAYMENT_CHECK');
                }

                $prodToBasketArr[] = [
                    'ID' => $prodArr["ID"],
                    'NAME' => $prodArr["NAME"],
                    'QUANTITY' => 1,
                    'CURRENCY' => Currency\CurrencyManager::getBaseCurrency(),
                    'BASE_PRICE' => $productPrice,
                    'LID' => SITE_ID,
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProviderCustom',
                ];
            }
            //return $response->shapeOk(['ORDER_ID' => 1, 'EVENT_URL' => $prodArr['DETAIL_PAGE_URL']], 'Запись успешна');
            if ($prodToBasketArr && !empty($prodToBasketArr)) {
                $basket = self::addToBasket($prodToBasketArr);
                if ($basket) {
                    $orderId = self::addToOrder($basket, $withPay, false, $isCheckNeeded, $checkData);
                    if ($orderId && $points) {
                        addUserBonus($USER->GetID(), $points, $orderId);
                    }
                    return $response->shapeOk(
                        [
                        'ORDER_ID' => $orderId,
                        'EVENT_URL' => $prodArr['DETAIL_PAGE_URL']
                        ],
                        'Запись успешна'
                    );
                }
            }
            throw new Exception('Сегодня не твой день, приходи завтра....');
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
    public static function addCourseInOrder() {
        $response = new Response();
        try {
            if(!\CModule::IncludeModule("iblock")) throw new Exception('Не подключен модуль iblock');
            if(!\CModule::IncludeModule("sale")) throw new Exception('Не подключен модуль sale');
            if(!\CModule::IncludeModule("catalog")) throw new Exception('Не подключен модуль catalog');

            global $USER;
            $request = Main\Application::getInstance()->getContext()->getRequest();
            //$siteOptions = siteOptions();

            $arSelect = Array("ID", "NAME", "PROPERTY_UF_PRICE", "PROPERTY_UF_POINTS_PROTECO");
            $arFilter = Array("IBLOCK_ID"=>9, "ID" => $request->getPost('COUSE_ID'), "ACTIVE"=>"Y");
            $courseOb = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            if($courseArr = $courseOb->GetNext()) {
                //$points = $courseOb['PROPERTY_UF_POINTS_PROTECO_VALUE'] ? : $siteOptions['UF_POINTS_PROTECO']['VALUE'];
                $points = $courseArr['PROPERTY_UF_POINTS_PROTECO_VALUE'];
                $arSelect = Array("ID", "NAME", "PROPERTY_UF_REGISTER_PAY");
                $arFilter = Array("IBLOCK_ID"=>3, "ID" => explode(',', $request->getPost('ID')), "ACTIVE"=>"Y");
                $prodOb = \CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($prodArr = $prodOb->GetNext()) {
                    $prodToBasketArr[] = [
                        'ID' => $prodArr["ID"],
                        'NAME' => $prodArr["NAME"],
                        'QUANTITY' => 1,
                        'CURRENCY' => Currency\CurrencyManager::getBaseCurrency(),
                        'BASE_PRICE' => IntVal($prodArr['PROPERTY_UF_REGISTER_PAY_VALUE']),
                        'LID' => SITE_ID,
                        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProviderCustom',
                    ];
                }

                if ($prodToBasketArr && !empty($prodToBasketArr)) {
                    $basket = self::addToBasket($prodToBasketArr);
                    if ($basket) {
                        $orderId = self::addToOrder($basket, true, IntVal($courseArr['PROPERTY_UF_PRICE_VALUE']));
                        if ($orderId && $points) {
                            addUserBonus($USER->GetID(), $points, $orderId);
                        }
                        return $response->shapeOk(['ORDER_ID' => $orderId], 'Запись успешна');
                    }
                }
            }

            //throw new Exception('Сегодня не твой день, приходи завтра....');
        } catch (Exception $e) {
            return $response->shapeError([], $e);
        }
    }
}
