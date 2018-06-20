<?php

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
    return;
}

$stepMessage = new CAdminMessage(Loc::getMessage('MOD_UNINST_WARN'));
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="<?= Loc::getMessage('EXTYL_EXAMPLE_MODULE_ID') ?>">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <? $stepMessage->Show() ?>
    <p><?= Loc::getMessage('MOD_UNINST_SAVE') ?></p>
    <p>
        <label for="savedata"><?= Loc::getMessage('MOD_UNINST_SAVE_TABLES') ?></label>
        <input type="checkbox" name="savedata" id="savedata" value="Y">
    </p>
    <input type="submit" value="<?= Loc::getMessage('MOD_UNINST_DEL') ?>">
</form>