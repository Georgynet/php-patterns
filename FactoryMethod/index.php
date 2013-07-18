<?php

abstract class ApptEncoder {
    protected function getData() {
        return 'Данные из ApptEncoder';
    }

    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder {
    function encode() {
        return $this->getData().' в формате BloggsCal.<br/>';
    }
}
class MegaApptEncoder extends ApptEncoder {
    function encode() {
        return $this->getData().' в формате Mega.<br/>';
    }
}

abstract class CommsManager {
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager {
    function getHeaderText() {
        return 'Bloggs верхний колонтитул.<br/>';
    }

    function getApptEncoder() {
        return new BloggsApptEncoder();
    }

    function getFooterText() {
        return 'Bloggs нижний колонтитул.<br/>';
    }
}

class MegaCommsManager extends CommsManager {
    function getHeaderText() {
        return 'Mega верхний колонтитул.<br/>';
    }

    function getApptEncoder() {
        return new MegaApptEncoder();
    }

    function getFooterText() {
        return 'Mega нижний колонтитул.<br/>';
    }
}

$bloggs = new BloggsCommsManager();
echo $bloggs->getHeaderText();
$bloggsData = $bloggs->getApptEncoder();
echo $bloggsData->encode();
echo $bloggs->getFooterText();

$mega = new MegaCommsManager();
echo $mega->getHeaderText();
$megaData = $mega->getApptEncoder();
echo $megaData->encode();
echo $mega->getFooterText();