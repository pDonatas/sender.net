<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kačių veislės</title>
</head>
<body>
<?php
if(isset($_GET['n'])) {
    //Statistika
    require('maincore.php');
    $query = $pdo->query("SELECT * FROM `Count` WHERE `n` = 0");
    if($query->rowCount() > 0) {
        $data = $query->fetch(PDO::FETCH_BOTH); // CountAll
        $countAll = $data['count'];
    }else{
        $query = $pdo->prepare("INSERT INTO `Count` (`count`, `n`) VALUES (?, ?)");
        $query->execute([0, 0]);
        $countAll = 0;
    }
    //Statistika n reikšmei
    $query = $pdo->prepare("SELECT * FROM `Count` WHERE `n` = ?");
    $query->execute([$_GET['n']]);
    if($query->rowCount() > 0){
        $data = $query->fetch(PDO::FETCH_BOTH); // CountN
        $countN = $data['count'];
    }else{
        $query = $pdo->prepare("INSERT INTO `Count` (`count`, `n`) VALUES (?, ?)");
        $query->execute([0, $_GET['n']]);
        $countN = 0;
    }
    //Reikšmių atnaujinimas:
    $query = $pdo->prepare("UPDATE `Count` SET `count` = ? WHERE `n` = 0");
    $query->execute([$countAll+1]);
    $query = $pdo->prepare("UPDATE `Count` SET `count` = ? WHERE `n` = ?");
    $query->execute([$countN+1, $_GET['n']]);
    //Tikrinam kešą
    $cachetime = 60; //60 sekundžių kešo galiojimas
    $cfile = 'cache/' . $_GET['n'];
    if (file_exists($cfile) && time() - $cachetime <= filemtime($cfile)) {
        $cached = fopen($cfile, "r");
        $data = [];
        while(!feof($cached)){
            $temp = fgets($cached);
            if(!empty($temp)) {
                array_push($data,$temp);
            }
        }
        echo 'Cat1: ' . $data[0] . '<br/>';
        echo 'Cat2: ' . $data[1] . '<br/>';
        echo 'Cat3: ' . $data[2] . '<br/>';
        //Rašom logą:
        $json = file_get_contents('log.json');
        $jdata = json_decode($json,true);
        if($jdata == null) {
            $jdata = [];
            $json = json_encode($jdata, JSON_PRETTY_PRINT);
            file_put_contents('log.json', $json);
        }
        require 'Log.php';
        $log = new Log();
        $log->setCats($data);
        $log->setCountAll($countAll+1);
        $log->setCountN($countN+1);
        $log->setN($_GET['n']);
        $log->setDatetime(date("Y-m-d H:i:s"));
        array_push($jdata, $log);
        $json = json_encode($jdata,JSON_PRETTY_PRINT);
        file_put_contents('log.json', $json);
        exit();
    }
    ob_start();
    //Tolimesnis kodas vykdomas tik neradus ir/arba pasibaigus kešo failui
    if (file_exists('cats.txt')) {
        $f_contents = file("cats.txt");
        $data = array_values(array_intersect_key($f_contents, array_flip(array_rand($f_contents, 3))));

        echo 'Cat1: ' . $data[0] . '<br/>';
        echo 'Cat2: ' . $data[1] . '<br/>';
        echo 'Cat3: ' . $data[2] . '<br/>';
    } else {
        echo "Failas neegzistuoja";
    }
    $content = ob_get_contents();

    file_put_contents($cfile, $data);
    //Rašom logą:
    require 'Log.php';
    //Rašom logą:
    $json = file_get_contents('log.json');
    $jdata = json_decode($json,true);
    if($jdata == null) {
        $jdata = [];
        $json = json_encode($jdata, JSON_PRETTY_PRINT);
        file_put_contents('log.json', $json);
    }
    $log = new Log();
    $log->setCats($data);
    $log->setCountAll($countAll+1);
    $log->setCountN($countN+1);
    $log->setN($_GET['n']);
    $log->setDatetime(date("Y-m-d H:i:s"));
    array_push($jdata, $log);
    $json = json_encode($jdata,JSON_PRETTY_PRINT);
    file_put_contents('log.json', $json);
}else{
    echo "Svetainės naudojimas: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/[1-1000000]";
}
?>
</body>
</html>