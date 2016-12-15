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
$eventRepository = $doctrine->getRepository('SIP\ResourceBundle\Entity\Event');
/** @var \Doctrine\ORM\EntityRepository $eventTypeRepository */
$eventTypeRepository = $doctrine->getRepository('SIP\ResourceBundle\Entity\EventType');
/** @var \Doctrine\ORM\EntityRepository $tagRepository */
$tagRepository = $doctrine->getRepository('SIP\ResourceBundle\Entity\Tag\Tag');

$em = $doctrine->getManager();

// Соединяемся, выбираем базу данных
$link = mysql_connect('127.0.0.1', 'root')
or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('rustextile_dump') or die('Не удалось выбрать базу данных');

// Загрузка событий
$query = 'SELECT * FROM minprom_events';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines =array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}

foreach ($lines as $event) {

    $e = $doctrine->getRepository('SIP\ResourceBundle\Entity\Event')->findOneBy(array('id' => $event['id']));
    if($e) continue;

    $entity = new Event();
    $entity->setId($event['id']);
    $entity->setH1($event['h1']);
    $entity->setBrief($event['brief']);
    $entity->setFull($event['full']);
    $entity->setAddress($event['address']);
    $entity->setPhone($event['phone']);
    $entity->setSite($event['site']);

    if ($event['status_id'] == 2)
        $entity->setPublish(true);
    else
        $entity->setPublish(false);

    if ($event['is_home'] == 1)
        $entity->setOnMain(true);

    $date = new \DateTime();
    $date->setTimestamp($event['date_add']);
    $entity->setDateAdd($date);

    $date = new \DateTime();
    $date->setTimestamp($event['date_end']);
    $entity->setDateEnd($date);

    $date = new \DateTime();
    $date->setTimestamp($event['date_start']);
    $entity->setDateStart($date);

    $eventType = $eventTypeRepository->find($event['type_id']);
    $entity->setType($eventType);

    $remoteImage = file_get_contents("http://www.rustekstile.ru/images/upload/{$event['big_img']}");
    if ($remoteImage) {
        file_put_contents("/tmp/{$event['big_img']}", $remoteImage);
        $media = getMediaByImage("/tmp/{$event['big_img']}", $event['big_img'], $container);
        $entity->setImage($media);
    }

    $em->persist($entity);

    $metadata = $em->getClassMetaData(get_class($entity));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();

    $query = "SELECT * FROM minprom_tags_links WHERE event_id={$entity->getId()}";
    $result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
    while ($tag = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $entityTag = $tagRepository->find($tag['tag_id']);
        $tagging = new Tagging();
        $tagging->setTag($entityTag);
        $tagging->setResource($entity);

        $em->persist($tagging);
        $em->flush();
    }

    $em->persist($entity);
    $em->flush();

    demonlog("Save event: id: {$entity->getId()}, name: {$entity->getH1()}");
}

/*
// Загрузки типов тегов
$query = 'SELECT * FROM minprom_tags';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines =array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}

foreach ($lines as $tag) {
    $entity = new Tag();
    $entity->setName($tag['h1']);
    $entity->setId($tag['id']);

    $em->persist($entity);

    $metadata = $em->getClassMetaData(get_class($entity));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();
}
*/

/*
// Загрузки типов событий
$query = 'SELECT * FROM minprom_events_types';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines =array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}

foreach ($lines as $type) {
    $eventType = new EventType();
    $eventType->setName($type['name']);
    $eventType->setId($type['id']);

    $em->persist($eventType);

    $metadata = $em->getClassMetaData(get_class($eventType));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();
}
*/

function getMediaByImage($path, $name, $container)
{
    $media = new Media;
    $media->setName($name);
    $media->setBinaryContent($path);
    $media->setProviderName('sonata.media.provider.image');
    $media->setContext('event');
    $container->get('sonata.media.manager.media')->save($media);

    return $media;
}

function demonlog($event)
{
    echo '[', date('Y-m-d H:i:s'), '] ' . $event, "\n";
}