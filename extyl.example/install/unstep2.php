<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Configuration;

if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {

    $ex_message = [
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MOD_UNINST_ERR'),
        'DETAILS' => $ex->GetString(),
        'HTML' => true,
    ];

    $adminMessage = new CAdminMessage($ex_message, $ex);
    $adminMessage->Show();
} else {
    $adminMessage = new CAdminMessage(Loc::getMessage('MOD_UNINST_OK'));
    $adminMessage->ShowNote(Loc::getMessage('MOD_UNINST_OK'));
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
</form>