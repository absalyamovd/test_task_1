<?php

/*  Необходимо вывести Элементы в линейный список в соответствии с индексом порядка (указан в скобках) папок,
 *  в которых они находятся. 
 * 
 *  Т. е. для папок одного уровня в начале списка должны быть элементы папки с наименьшим индексом порядка,
 *  а в конце списка будут элементы из папки с наибольшим индексом. Для папок, содержащих подпапки, сначала должны идти элементы папки,
 *  затем элементы подпапок. 
 * 
 *  Для элементов одного уровня какой-либо папки отношение порядка определить индексом порядка самих элементов от 
 *  меньшего к большему. Предполагаем, что один элемент находится только в одной папке.
 */

$tree = CIBlockSection::GetTreeList(Array('IBLOCK_ID' => $arResult['ID']),Array('ID', 'NAME'));
$arTmp = Array();
while($section = $tree->GetNext()) {
    //$arSelect = Array('ID','NAME');
    $arFilter = Array('SECTION_ID'=>$section['ID'], 'ACTIVE'=>'Y');
    $res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false);// $arSelect);

    while($elem = $res->GetNextElement()){
        $arResult1 = $elem->GetFields();
        $arTmp[] = $arResult1;
        //echo 'ID:'.$arResult1['ID'].' - '.$arResult1['NAME'].'<br>';
    }
}
unset($arResult1);

$cntr = 0;
foreach($arTmp as $key1=>$value1){
    foreach ($arResult['ITEMS'] as $key2 => $value2){
        if($value2['ID'] == $arTmp[$key1]['ID']){
            $tmp = $arResult['ITEMS'][$cntr];
            $arResult['ITEMS'][$cntr] = $arResult['ITEMS'][$key2];
            $arResult['ITEMS'][$key2] = $tmp;
            $cntr++;
            break;
        }
    }
}

//echo '<pre>';print_r($arResult['ITEMS']);echo '</pre>';

