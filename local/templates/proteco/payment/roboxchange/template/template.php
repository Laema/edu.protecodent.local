<?php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
/**
 * @var array $params
 */
?>
			<form action="<?=$params['URL']?>" method="post" id="pay-form">
				<input type="hidden" name="MerchantLogin" value="<?=htmlspecialcharsbx($params['ROBOXCHANGE_SHOPLOGIN']);?>">
				<input type="hidden" name="OutSum" value="<?=htmlspecialcharsbx($params['SUM']);?>">
				<input type="hidden" name="InvId" value="<?=htmlspecialcharsbx($params['PAYMENT_ID']);?>">
				<input type="hidden" name="Description" value="<?=htmlspecialcharsbx($params['ROBOXCHANGE_ORDERDESCR']);?>">
				<input type="hidden" name="SignatureValue" value="<?=$params['SIGNATURE_VALUE'];?>">
				<input type="hidden" name="Email" value="<?=htmlspecialcharsbx($params['BUYER_PERSON_EMAIL'])?>">

				<?php foreach ($params['ADDITIONAL_USER_FIELDS'] as $fieldName => $fieldsValue):?>
					<input type="hidden" name="<?=$fieldName?>" value="<?=htmlspecialcharsbx($fieldsValue);?>">
				<?php endforeach; ?>

				<?php if ($params['PS_IS_TEST'] === 'Y'):?>
					<input type="hidden" name="IsTest" value="1">
				<?php endif;?>

				<?php if ($params['PS_MODE']):?>
					<input type="hidden" name="IncCurrLabel" value="<?=htmlspecialcharsbx($params['PS_MODE']);?>">
				<?php endif;?>
				<button class="button pay-btn" id="pay-btn">Перейти к оплате</button>

			</form>
