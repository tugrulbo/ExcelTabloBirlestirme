<?php
require_once 'SimpleXLSX.php';
$operasyon = [];
$mola = [];
$result = [];
if ( $xlsx = SimpleXLSX::parse('giris.xlsx') ) {
    $operasyon = $xlsx->rows();
} else {
  echo SimpleXLSX::parseError();
}

if ( $xlsx = SimpleXLSX::parse('eklenti.xlsx') ) {
  $mola=$xlsx->rows();
} else {
  echo SimpleXLSX::parseError();
}
print_r($operasyon[1]);
print_r($mola[1]);
//operasyon içindeki eleman sayısı
$count_operasyon = count($operasyon);
//mola içindeki eleman sayısı
$count_mola = count($mola);

$temp =array();
$operasyon_new = [];
$k = 1;


for($i=1; $i<$count_operasyon;$i++){
        $operasyon_time =  date('H:i:s',strtotime($operasyon[$i][2]));
        $mola_time = date('H:i:s',strtotime($mola[1][$k]));
        if(var_dump($operasyon_time < $mola_time)){
           
            $temp = array(array(
                0 => $operasyon[$i][0],
                    1 => $operasyon[$i][1],
                    2 => $operasyon[$i][2],
                    3 => $operasyon[$i][3],
                    4 => $operasyon[$i][4],
                    5 => $operasyon[$i][5]
            )      
            );
            $operasyon_new = array_merge($operasyon_new,$temp);
           
        }   
        else  if(var_dump($operasyon_time < $mola_time)==FALSE && $i<$count_mola){

          
            $mola_time_1 = new DateTime(date('H:i:s',strtotime($mola[$i][0])));
            $operasyon_time_1 = new DateTime(date('H:i:s',strtotime($operasyon[$i][2])));
            $diff =  $mola_time_1->diff($operasyon_time_1);
            $temp = array(array(
                0 => $operasyon[$i][0],
                1 => $operasyon[$i][2],
                2 => date('Y/m/d',strtotime($operasyon[$i][1])).' '.date('H:i:s',strtotime($mola[$i][0])),
                3 => $diff->format('%H:%i'),
                4 => $operasyon[$i][4],
                5 => $operasyon[$i][5]
                )
            );

            $operasyon_new = array_merge($operasyon_new,$temp);

            $mola_time_1 = new DateTime(date('H:i:s',strtotime($mola[$i][0])));
            $operasyon_time_1 = new DateTime(date('H:i:s',strtotime($mola[$i][1])));
            $diff =  $mola_time_1->diff($operasyon_time_1);
            $temp = array(array(
                0 => $operasyon[$i][0],
                1 => date('Y/m/d',strtotime($operasyon[$i][1])).' '.date('H:i:s',strtotime($mola[$i][0])),
                2 => date('Y/m/d',strtotime($operasyon[$i][1])).' '.date('H:i:s',strtotime($mola[$i][1])),
                3 => $diff->format('%H:%i'),
                4 => "DURUŞ",
                5 => $mola[$i][2]
            )
            );

            $operasyon_new = array_merge($operasyon_new,$temp);

            $mola_time_1 = new DateTime(date('H:i:s',strtotime($mola[$i][1])));
            $operasyon_time_1 = new DateTime(date('H:i:s',strtotime($operasyon[$i+1][2])));
            $diff =  $mola_time_1->diff($operasyon_time_1);
            $temp = array(array(
                0 => $operasyon[$i][0],
                1 => date('Y/m/d',strtotime($operasyon[$i][1])).' '.date('H:i:s',strtotime($mola[$i][1])),
                2 => $operasyon[$i+1][2],
                3 => $diff->format('%H:%i'),
                4 => $operasyon[$i][4],
                5 => $operasyon[$i][5]
            )
            );

            $operasyon_new = array_merge($operasyon_new,$temp);
        }else{
            $mola_time_1 = new DateTime(date('H:i:s',strtotime($operasyon[$i][2])));
            $operasyon_time_1 = new DateTime(date('H:i:s',strtotime($operasyon[$i][1])));
            $diff =  $mola_time_1->diff($operasyon_time_1);

            $temp = array(array(
                0 => $operasyon[$i][0],
                1 => $operasyon[$i][1],
                2 => $operasyon[$i][2],
                3 => $diff->format('%H:%i'),
                4 => $operasyon[$i][4],
                5 => $operasyon[$i][5]
            )
            );
            $operasyon_new = array_merge($operasyon_new,$temp);
          }
        }


print_r($operasyon_new);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
    <thead>Üretim Operasyon Bildirimleri</thead>
        <tr>
            <th>İş No</th>
            <th>Başlangıç</th>
            <th>Bitiş</th>
            <th>Toplam Süre(Saat)</th>
            <th>Statü</th>
            <th>Duruş Nedeni</th>
        </tr>
        
        <?php for($i=0;$i<count($operasyon_new);$i++):?>
        <tr>
           <?php for($j =0;$j<6;$j++):?>
            <td><?php echo $operasyon_new[$i][$j]?></td>
            <?php endfor?>
        </tr>
        <?php endfor?>
        
    </table>
</body>
</html>