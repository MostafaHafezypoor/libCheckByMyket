<?php
include("../connDB.php");
if(isset($_POST["packageName"])&&isset($_POST["skuID"])&&isset($_POST["tokenBuy"])){
$packageName=mysqli_real_escape_string($conn,$_POST['packageName']);
$skuID=mysqli_real_escape_string($conn,$_POST['skuID']);
$tokenBuy=mysqli_real_escape_string($conn,$_POST['tokenBuy']);
checkBuyCoin();
}
function checkBuyCoin(){
     global $packageName;
     global $skuID;
     global $tokenBuy;
      global $conn;
     global $token;
    // $packageName="hafezypoor.mosafa.rubikaassistant";
    // $token="xpWJgfBeLYlQErzsIRAzCMSZiPuqcKjNhDoUvOFG";
    // $tokenBuy="13318458";
    // $skuID="100";
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,"https://developer.myket.ir/api/applications/$packageName/purchases/products/$skuID/tokens/$tokenBuy");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_HTTPHEADER,array(
'X-Access-Token: 7269320f-17a5-42f4-918b-0bfa3475d7e2'
));
$result=curl_exec($curl);
curl_close($curl);
 $responseMyket=json_decode($result,true);
if(isset($responseMyket["purchaseState"])&&$responseMyket["purchaseState"]==0){
    $users=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `users` WHERE `token`='$token'"));
      $coin=$users['coin']+$skuID;
      mysqli_query($conn,"UPDATE `users` SET `coin`='$coin' WHERE `token`='$token'");
    echo "success";
  
}else{
    echo "failure";
}
} 





