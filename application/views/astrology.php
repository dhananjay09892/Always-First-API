<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Astrology</title>
</head>

<body>
    <?php
    $url = 'https://www.alwaysfirst.in/api/getHoroscopeTomorrow';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "url=$url");
    $result = curl_exec($ch);
    curl_close($ch);
    // echo $result;
    $result = json_decode($result, true);
    $arrayData = $result['body'];
    // print_r($arrayData);
    $i = 1;
    $tomorrow = date('d-M-Y', strtotime('+1 day'));
    echo '<button onClick="copyToClipboard(\'p1\')">Copy text</button>';
    echo '<p id="p1">';
    echo $tomorrow . '<br>';
    foreach ($arrayData as $key => $value) {
        $id = $value['id'];
        $rashi_id = $value['rashi_id'];
        $date = $value['date'];
        $horoscope = $value['horoscope'];
        $remedy = $value['remedy'];
        $rashi_name = $value['name'];
        echo $i . ")" . $rashi_name . "<br>";
        echo  "राशिफल:- " . $horoscope . "<br>";
        echo "उपाय:- " . $remedy . "<br>";
        $i++;
    }
    echo '</p>';
    ?>
    <script>
        function copyToClipboard(id) {
            var from = document.getElementById(id);
            var range = document.createRange();
            window.getSelection().removeAllRanges();
            range.selectNode(from);
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        }
    </script>
</body>

</html>