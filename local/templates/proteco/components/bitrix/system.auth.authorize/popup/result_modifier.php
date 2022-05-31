<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>


<?php

global $USER;

if ($USER->IsAuthorized()) {
    ?>
    <script>

        let postData = new FormData();
        postData.append('ID', <?=$_POST['REGISTER']['ID_EVENT']?>);
        postData.append('TYPE', 'event');

        ra.ajax('/ajax/?act=Order.addEventInOrder','POST',postData,{},'json').then((response) => {
            if (response.isSuccess && response.result.ORDER_ID !== 0) {
                window.location = response.result.EVENT_URL + '?ORDER_ID=' + response.result.ORDER_ID;
            }
        });
    </script>
<?php
}

