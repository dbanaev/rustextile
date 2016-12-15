<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
ini_set('memory_limit', '2048M');

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
mysql_select_db('rustextile_dump') or die('Не удалось выбрать базу данных');
mysql_query("SET NAMES 'utf8'");

// Загрузка событий
//$query = 'SELECT * FROM minprom_designers';
//$query = 'SELECT * FROM minprom_brands';
$query = 'SELECT * FROM minprom_manufs';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines = array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}
$count = 1;
foreach ($lines as $news) {

    $n = $doctrine->getRepository('SIP\ResourceBundle\Entity\Manufacturer')->findOneBy(array('id' => $news['id']));
    if($n) continue;

    $entity = new \SIP\ResourceBundle\Entity\Manufacturer();

    $entity->setId($news['id']);
    $user = $em->getRepository('SIP\ResourceBundle\Entity\User\User')->findOneBy(array('id' => $news['user_id']));
    if($user) {
        $entity->setUser($user);
    }

    if ($news['status_id'] == 2)
        $entity->setPublish(true);
    else
        $entity->setPublish(false);

    $city = $em->getRepository('SIP\ResourceBundle\Entity\City')->findOneBy(array('id' => $news['city_id']));
    if($city) {
        $entity->setCity($city);
    }

    $region = $em->getRepository('SIP\ResourceBundle\Entity\Region')->findOneBy(array('id' => $news['region_id']));
    if($region) {
        $entity->setRegion($region);
    }

    $entity->setH1($news['h1']);
    $entity->setBrief($news['brief']);
    $entity->setFull($news['full']);
    $entity->setAddress($news['address']);
    $entity->setCoords($news['coords']);
    $entity->setPerson($news['person']);
    $entity->setPhone($news['phone']);
    $entity->setFax($news['fax']);
    $entity->setEmail($news['email']);
    $entity->setSite($news['site']);
    $entity->setTitle($news['title']);
    $entity->setDescription($news['description']);
    $entity->setKeywords($news['keywords']);

    $date = new \DateTime();
    $date->setTimestamp($news['date_add']);
    $entity->setDateAdd($date);


    $remoteImage = @file_get_contents("http://www.rustekstile.ru/images/upload/{$news['main_img']}");
    if ($remoteImage && strpos($remoteImage, '<!DOCTYPE HTML>') === false) {
        file_put_contents("/tmp/{$news['main_img']}", $remoteImage);
        $media = getMediaByImage("/tmp/{$news['main_img']}", $news['main_img'], $container);
        $entity->setImage($media);
    }

    $em->persist($entity);

    $metadata = $em->getClassMetaData(get_class($entity));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();

    echo "Count: " . $count++ . "\n\n";
    demonlog("Save designer: id: {$entity->getId()}");
}


function getMediaByImage($path, $name, $container)
{
    $media = new Media;
    $media->setName($name);
    $media->setBinaryContent($path);
    $media->setProviderName('sonata.media.provider.image');
//    $media->setContext('designer');
//    $media->setContext('brand');
    $media->setContext('manufacturer');
    $container->get('sonata.media.manager.media')->save($media);

    return $media;
}

function demonlog($event)
{
    echo '[', date('Y-m-d H:i:s'), '] ' . $event, "\n";
}