<?php

$loader = require_once __DIR__ . '/../../app/bootstrap.php.cache';
require_once __DIR__ . '/../../app/AppKernel.php';

$kernel = new AppKernel('dev', true);

$kernel->loadClassCache();
$kernel->boot();

/** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
$container = $kernel->getContainer();
/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
$doctrine = $container->get('doctrine');
$em = $doctrine->getManager();
$conn = $em->getConnection();

// Соединяемся, выбираем базу данных
$link = mysql_connect('127.0.0.1', 'root')
or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('rustextile_dump') or die('Не удалось выбрать базу данных');

mysql_query("SET NAMES 'utf8'");

$result = mysql_query("SELECT * FROM minprom_designers_brands");

while ($row = mysql_fetch_assoc($result)) {

    $arr = array(
        $row['des_id'],
        $row['brand_id']
    );

    $sql = 'INSERT INTO designer_brand
                      (designer_id, brand_id)
                    VALUES
                      (?, ?)';

    $stmt = $conn->prepare($sql);
    $stmt->execute($arr);

    echo "*******Success*******\n\n";
}

echo "Done\n\n";