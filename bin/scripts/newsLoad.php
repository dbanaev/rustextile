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
/** @var \Doctrine\ORM\EntityRepository $tagRepository */
$tagRepository = $doctrine->getRepository('SIP\ResourceBundle\Entity\Tag\Tag');

$em = $doctrine->getManager();

// Соединяемся, выбираем базу данных
$link = mysql_connect('127.0.0.1', 'root')
or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('rustextile_dump') or die('Не удалось выбрать базу данных');
mysql_query("SET NAMES 'utf8'");

// Загрузка событий
$query = 'SELECT * FROM minprom_news';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines = array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}
$count = 1;
foreach ($lines as $news) {
    $entity = new \SIP\ResourceBundle\Entity\News();

    $n = $doctrine->getRepository('SIP\ResourceBundle\Entity\News')->findOneBy(array('id' => $news['id']));
    if($n) continue;

    $entity->setId($news['id']);
    $entity->setH1($news['h1']);
    $entity->setBrief($news['brief']);
    $entity->setFull($news['full']);
    $entity->setFotoFrom($news['fotofrom']);
    $entity->setTitle($news['title']);
    $entity->setDescription($news['description']);
    $entity->setKeywords($news['keywords']);

    if ($news['status_id'] == 2)
        $entity->setPublish(true);
    else
        $entity->setPublish(false);

    if ($news['is_home'] == 1)
        $entity->setOnMain(true);

    $date = new \DateTime();
    $date->setTimestamp($news['date_add']);
    $entity->setDateAdd($date);


    $remoteImage = @file_get_contents("http://www.rustekstile.ru/images/upload/{$news['big_img']}");
    if ($remoteImage && strpos($remoteImage, '<!DOCTYPE HTML>') === false) {
        file_put_contents("/tmp/{$news['big_img']}", $remoteImage);
        $media = getMediaByImage("/tmp/{$news['big_img']}", $news['big_img'], $container);
        $entity->setImage($media);
    }

    $em->persist($entity);

    $metadata = $em->getClassMetaData(get_class($entity));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    $em->flush();


    $query = "SELECT * FROM minprom_tags_links WHERE news_id={$entity->getId()}";
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

    echo "Count: " . $count++ . "\n\n";
    demonlog("Save event: id: {$entity->getId()}");
}


function getMediaByImage($path, $name, $container)
{
    $media = new Media;
    $media->setName($name);
    $media->setBinaryContent($path);
    $media->setProviderName('sonata.media.provider.image');
    $media->setContext('news');
    $container->get('sonata.media.manager.media')->save($media);

    return $media;
}

function demonlog($event)
{
    echo '[', date('Y-m-d H:i:s'), '] ' . $event, "\n";
}