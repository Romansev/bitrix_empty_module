<?php

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

if ($ex = $APPLICATION->GetException()) {

    $ex_message = [
        'TYPE' => 'ERROR',
        'MESSAGE' => Loc::getMessage('MOD_INST_ERR'),
        'DETAILS' => $ex->GetString(),
        'HTML' => true,
    ];

    $adminMessage = new CAdminMessage($ex_message, $ex);
    $adminMessage->ShowMessage($ex_message);
} else {
    $adminMessage = new CAdminMessage(Loc::getMessage('MOD_INST_OK'), $ex);
    $adminMessage->ShowNote(Loc::getMessage('MOD_INST_OK'));
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
</form>