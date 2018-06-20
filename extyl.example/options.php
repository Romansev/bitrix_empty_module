<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpApplication;

$module_id = 'extyl.example'; // required !

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/options.php');
Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight($module_id) < 'S') {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
}

Loader::includeModule($module_id);

$request = HttpApplication::getInstance()->getContext()->getRequest();

// Описание табов в админке
$aTabs = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('EXTYL_EXAMPLE_TAB_SETTINGS'),
        'OPTIONS' => [
            [
                'field 1',
                Loc::getMessage('EXTYL_EXAMPLE_FIELD_1'),
                '',
                ['text', 80],
            ],
            [
                'field 2',
                Loc::getMessage('EXTYL_EXAMPLE_FIELD_2'),
                '',
                ['text', 80],
            ],
            [
                'field 3',
                Loc::getMessage('EXTYL_EXAMPLE_FIELD_3'),
                '',
                ['text', 80],
            ],
        ],
    ],
    [
        'DIV' => 'edit2',
        'TAB' => Loc::getMessage('MAIN_TAB_RIGHTS'),
        'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_RIGHTS'),
    ],
];

// Визуальный вывод
$tabControl = new CAdminTabControl('tabControl', $aTabs);
?>

<? $tabControl->Begin() ?>

    <form method="post"
          action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($request['mid']) ?>&amp;lang=<?= $request['lang'] ?>"
          name="extyl_example_settings">

        <? foreach ($aTabs as $aTab): ?>
            <? if ($aTab['OPTIONS']): ?>
                <?
                $tabControl->BeginNextTab();
                __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
                ?>
            <? endif; ?>
        <? endforeach; ?>
        <?
        $tabControl->BeginNextTab();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/admin/group_rights.php';

        $tabControl->Buttons();
        ?>
        <input type="submit" name="update" value="<?= Loc::getMessage('MAIN_SAVE') ?>">
        <input type="reset" name="reset" value="<?= Loc::getMessage('MAIN_RESET') ?>">
        <?= bitrix_sessid_post() ?>
    </form>
<? $tabControl->End(); ?>

<?
// Сохранение данных
if ($request->isPost() && $request['update'] && check_bitrix_sessid()) {
    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) {
                continue;
            }

            if ($arOption['note']) {
                continue;
            }

            $optionName = $arOption[0];
            $optionValue = $request->getPost($optionName);

            Option::set($module_id, $optionName, $optionValue);
        }
    }
}