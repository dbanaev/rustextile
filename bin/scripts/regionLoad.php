<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
$loader = require_once __DIR__.'/../../app/bootstrap.php.cache';
require_once __DIR__.'/../../app/AppKernel.php';

use SIP\ResourceBundle\Entity\Event;
use SIP\ResourceBundle\Entity\EventType;
use SIP\ResourceBundle\Entity\Tag\Tag;
use SIP\ResourceBundle\Entity\Tag\Tagging;
use SIP\ResourceBundle\Entity\Media\Media;

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$kernel->boot();

/** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
$container = $kernel->getContainer();
/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
$doctrine = $container->get('doctrine');
/** @var \Doctrine\ORM\EntityRepository $eventRepository */
$newsRepository = $doctrine->getRepository('SIP\ResourceBundle\Entity\News');

$em = $doctrine->getManager();

// Соединяемся, выбираем базу данных
$link = mysql_connect('127.0.0.1', 'root')
or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('sip_rustextile_old') or die('Не удалось выбрать базу данных');
mysql_query("SET NAMES 'utf8'");

// Загрузка событий
$query = 'SELECT * FROM minprom_filter_region';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

$lines = array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}
$count = 1;
foreach ($lines as $reg) {
    $entity = new \SIP\ResourceBundle\Entity\Region();

    $entity->setId($reg['id']);
    $entity->setSortNumber($reg['sort_number']);
    $entity->setName($reg['name']);


    $em->persist($entity);

    $metadata = $em->getClassMetaData(get_class($entity));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();

    echo "Count: " . $count++ . "\n\n";
    demonlog("Save region: id: {$entity->getId()}");
}

function demonlog($event)
{
    echo '[', date('Y-m-d H:i:s'), '] ' . $event, "\n";
}