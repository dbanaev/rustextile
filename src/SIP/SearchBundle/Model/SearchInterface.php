<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\SearchBundle\Model;

interface SearchInterface
{
    /**
     * @abstract
     * @return string
     */
    public function getItem($object);
}