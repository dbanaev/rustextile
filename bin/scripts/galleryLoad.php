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

$em = $doctrine->getManager();

// Соединяемся, выбираем базу данных
$link = mysql_connect('127.0.0.1', 'root')
or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('rustextile_dump') or die('Не удалось выбрать базу данных');
mysql_query("SET NAMES 'utf8'");

$query = 'SELECT * FROM minprom_products ORDER BY des_id DESC';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
$lines = array();
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $lines[] = $line;
}

foreach ($lines as $item)
{
    if ($item['des_id']) {
        $designer = $em->getRepository('SIP\ResourceBundle\Entity\Designer')->findOneBy(array('id' => $item['des_id']));
        if($designer) {
            $entity = new \SIP\ResourceBundle\Entity\Media\DisignerHasMedia();

            $entity->setDesigner($designer);
            $remoteImage = @file_get_contents("http://www.rustekstile.ru/images/upload/{$item['main_img']}");
            if ($remoteImage && strpos($remoteImage, '<!DOCTYPE HTML>') === false) {
                file_put_contents("/tmp/{$item['main_img']}", $remoteImage);
                $media = getMediaByImage("/tmp/{$item['main_img']}", $item['main_img'], $container);
                $entity->setImage($media);
            }

            $em->persist($entity);

            $metadata = $em->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $em->flush();

            demonlog("Save image: id: {$entity->getId()}");
        }
    } elseif ($item['brand_id']) {
        $brand = $em->getRepository('SIP\ResourceBundle\Entity\Brand')->findOneBy(array('id' => $item['brand_id']));
        if($brand) {
            $entity = new \SIP\ResourceBundle\Entity\Media\BrandHasMedia();

            $entity->setBrand($brand);
            $remoteImage = @file_get_contents("http://www.rustekstile.ru/images/upload/{$item['main_img']}");
            if ($remoteImage && strpos($remoteImage, '<!DOCTYPE HTML>') === false) {
                file_put_contents("/tmp/{$item['main_img']}", $remoteImage);
                $media = getMediaByImage("/tmp/{$item['main_img']}", $item['main_img'], $container);
                $entity->setImage($media);
            }

            $em->persist($entity);

            $metadata = $em->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $em->flush();

            demonlog("Save image from brand: id: {$entity->getId()}");
        }
    } elseif ($item['manuf_id']) {
        $manyf = $em->getRepository('SIP\ResourceBundle\Entity\Manufacturer')->findOneBy(array('id' => $item['manuf_id']));
        if($manyf) {
            $entity = new \SIP\ResourceBundle\Entity\Media\ManufacturerHasMedia();

            $entity->setManufacturer($manyf);
            $remoteImage = @file_get_contents("http://www.rustekstile.ru/images/upload/{$item['main_img']}");
            if ($remoteImage && strpos($remoteImage, '<!DOCTYPE HTML>') === false) {
                file_put_contents("/tmp/{$item['main_img']}", $remoteImage);
                $media = getMediaByImage("/tmp/{$item['main_img']}", $item['main_img'], $container);
                $entity->setImage($media);
            }

            $em->persist($entity);

            $metadata = $em->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $em->flush();

            demonlog("Save image from manuf: id: {$entity->getId()}");
        }
    } else {
        demonlog("Image without designer: id: {$item['id']}");
    }
}


function getMediaByImage($path, $name, $container)
{
    $media = new Media;
    $media->setName($name);
    $media->setBinaryContent($path);
    $media->setProviderName('sonata.media.provider.image');
    $media->setContext('designer_gallery');
    $container->get('sonata.media.manager.media')->save($media);

    return $media;
}

function demonlog($event)
{
    echo '[', date('Y-m-d H:i:s'), '] ' . $event, "\n";
}