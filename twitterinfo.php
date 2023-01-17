<?php
error_reporting(false);
header('Content-type: application/json;'); 

$urlside=$_GET['url'];


$ch = curl_init();
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
curl_setopt($ch, CURLOPT_URL,"https://nitter.bus-hit.me/$urlside");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_HEADER, false);
$meysam1= curl_exec($ch);
curl_close($ch);    

preg_match_all('#<span class="profile-stat-num">(.*?)</span>#is',$meysam1,$sidepath1);//info follow post
preg_match_all('#<div class="profile-bio"><p dir="auto">(.*?)<a href="(.*?)">(.*?)</a></p></div>#is',$meysam1,$sidepath2);//1-0 bio
preg_match_all('#<a class="profile-card-fullname" href="(.*?)" title="(.*?)">(.*?)<div class="icon-container">#is',$meysam1,$sidepath3);//name 2 0
preg_match_all('#<a class="profile-card-avatar" href="(.*?)" target="_blank">#is',$meysam1,$sidepath4);//https://nitter.bus-hit.me/   1 0
preg_match_all('#<div class="tweet-content media-body" dir="auto">(.*?)</div>#is',$meysam1,$sidepath5);

$da=[
'name'=>$sidepath3[2][0],
'bio'=>$sidepath2[1][0],
'Tweets'=>$sidepath1[1][0],
'Following'=>$sidepath1[1][1],
'Followers'=>$sidepath1[1][2],
'Likes'=>$sidepath1[1][3],
'photo'=>"https://nitter.bus-hit.me".$sidepath4[1][0]
];

echo json_encode(['ok' => true, 'channel' => '@SIDEPATH','writer' => '@meysam_s71',  'Results' =>['info'=>$da, 'posts'=>$sidepath5[1]]], 448);


