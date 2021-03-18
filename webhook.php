<?php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// include composer autoload
require "vendor/autoload.php";
 
// ดึง config id&token bot
require_once 'bot_settings.php';
 
///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
 
// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
 
// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    $userMessage = strtolower($userMessage);
 switch ($typeMessage){
 case 'text':
 switch ($userMessage) {
 case "ติดต่อเจ้าหน้าที่":
    $textReplyMessage = "เบอร์โทรติดต่อเจ้าหน้าที่ KD 
 คุณสรัลกร (คุณรัล)  = 4020
 คุณลลิตา (คุณเบน)  = 4021
 คุณอรวรา (คุณหมิว) = 4122";
    $replyData = new TextMessageBuilder($textReplyMessage);
    break;
 case "ติดต่อ":
    $textReplyMessage = "เบอร์โทรติดต่อเจ้าหน้าที่ KD 
 คุณสรัลกร (คุณรัล)  = 4020
 คุณลลิตา (คุณเบน)  = 4021
 คุณอรวรา (คุณหมิว) = 4122";
    $replyData = new TextMessageBuilder($textReplyMessage);
    break;
 case "บอท":
    $textReplyMessage = "บอทอยู่นี่ อยากทราบข้อมูลอะไรสอบถามได้เลยครับ";
    $replyData = new TextMessageBuilder($textReplyMessage);
    break;
 case "แผนที่":
    $picFullSize = 'https://sv1.picz.in.th/images/2021/02/23/oCK7cP.png';
    $picThumbnail = 'https://sv1.picz.in.th/images/2021/02/23/oCK7cP.png';
    $replyData = new ImageMessageBuilder($picFullSize,$picThumbnail);
    break; 
 case "ห้องอบรม":
    $picFullSize = 'https://sv1.picz.in.th/images/2021/02/23/oCK7cP.png';
    $picThumbnail = 'https://sv1.picz.in.th/images/2021/02/23/oCK7cP.png';
    $replyData = new ImageMessageBuilder($picFullSize,$picThumbnail);
    break;
 //case "วีดีโอ":
    $picThumbnail = 'https://www.i-vdo.info/v/cayhxorb1170';
    $videoUrl = "https://www.i-vdo.info/v/cayhxorb1170";                
    $replyData = new VideoMessageBuilder($videoUrl,$picThumbnail);
    break;
//case "เสียง":
    $audioUrl = "https://www.mywebsite.com/simpleaudio.mp3";
    $replyData = new AudioMessageBuilder($audioUrl,27000);
    break;
 case "ที่ตั้งบริษัท":
    $placeName = "ที่ตั้งบริษัท";
    $placeAddress = "332 333 หมู่ 5 ถ. พหลโยธิน ตำบล ลำไทร อำเภอวังน้อย จังหวัดพระนครศรีอยุธยา 13170";
    $latitude = 14.228424142606057;
    $longitude = 100.70143403664254;
    $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
    break;
 case "ขอบคุณ":
    $stickerID = 52114119;
    $packageID = 11539;
    $replyData = new StickerMessageBuilder($packageID,$stickerID);
    break;
 case "สวัสดี":
    $textReplyMessage = "สวัสดีครับ 😊";
    $replyData = new TextMessageBuilder($textReplyMessage);
    break;
 case "ข้อมูลการอบรม":
    $textReplyMessage = "ขณะนี้ ข้อมูลการอบรมยังไม่พร้อมใช้งานครับ";
    $replyData = new TextMessageBuilder($textReplyMessage);
  break;
   
 case "เพิ่มเพื่อน":  
    $textReplyMessage = "ไอดีของเราคือ @210pmvok หรือ scan QRcode";
    $textMessage = new TextMessageBuilder($textReplyMessage);
                     
    $picFullSize = 'https://sv1.picz.in.th/images/2021/03/18/DqYJgI.png';
    $picThumbnail = 'https://sv1.picz.in.th/images/2021/03/18/DqYJgI.png';
    $imageMessage = new ImageMessageBuilder($picFullSize,$picThumbnail);
    $multiMessage = new MultiMessageBuilder;
    $multiMessage->add($textMessage);
    $multiMessage->add($imageMessage);
    $replyData = $multiMessage;                                          
 break;  
 default:
 $textReplyMessage = "บอทขออภัยที่ยังไม่ค่อยเข้าใจในคำถาม กรุณาเปลี่ยนคำถามหรือใช้คำที่ใกล้เคียง บอทขอแนะนำ อย่างเช่น
 - ข้อมูลการอบรม
 - ติดต่อเจ้าหน้าที่ 
 - ห้องอบรม,แผนที่
 - ที่ตั้งบริษัท
 - เว็บแนะนำ
 ";
 $replyData = new TextMessageBuilder($textReplyMessage);         
    break;  
  
 case "เว็บแนะนำ":
  $textReplyMessage = "วันนี้บอทขอแนะนำเว็บความรู้ทางการเงิน เป็นอย่างไรนั้น คลิกเพื่อเข้าดูข้อมูลได้เลยครับ";
  $textMessage = new TextMessageBuilder($textReplyMessage);
   
  $imageMapUrl = 'https://sv1.picz.in.th/images/2021/02/26/o8EPe2.png';
  $replyData = new ImagemapMessageBuilder(
  $imageMapUrl,'URL',new BaseSizeBuilder(1080,1080),array(
  //new ImagemapMessageActionBuilder('MSarea',new AreaBuilder(0,0,520,699)),
  new ImagemapUriActionBuilder('https://www.รู้เรื่องเงิน.com/',new AreaBuilder(0,0,1080,1080)))); 

  $multiMessage =     new MultiMessageBuilder;
  $multiMessage->add($textMessage);
  $multiMessage->add($imageMapUrl);
  $replyData = $multiMessage;            
   
 break;
 default:
   // $stickerID = 52002744;
   // $packageID = 11537;
   // $replyData = new StickerMessageBuilder($packageID,$stickerID);         
// break;  
    }
}
 
//l ส่วนของคำสั่งตอบกลับข้อความ
$response = $bot->replyMessage($replyToken,$replyData);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
 
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>
