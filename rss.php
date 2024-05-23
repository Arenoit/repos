<?php
  require_once('./database/conexion.php');
  header('Content-Type: text/xml');
  $row=mysqli_fetch_assoc($resultCarousel);
  $link='http://projectesis.infinityfreeapp.com';
  if (isset($_GET['v'])&&$_GET['v']=='1.0') {
    echo  '<?xml version="1.0" encoding="utf-8"?>
    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
      <channel>
        <generator>RSS Builder by B!Soft</generator>
        <title>Repositorio</title>
        <link>'.$link.'</link>
        <description>Esta es un feed de descripcción de un la actualización del sitio web.</description>
        <language>es-es</language>
        <managingEditor>author@repository.com</managingEditor>
        <webMaster>webmaster@repository.com</webMaster>
        <copyright>2023 Repositorio</copyright>
        <atom:link href="'.$link.'/rss.xml" rel="self" type="application/rss+xml" />
        <image>
          <title>Repositorio</title>
          <link>'.$link.'</link>
          <url>'.$link.'/images/campus-istvl.png</url>
          <width>144</width>
          <height>108</height>
        </image>
        <item>
          <title>New RSS Feed</title>
          <pubDate>'.date("D, d M Y H:i:s",strtotime($row["projc_fec_projc"])).' -0500</pubDate>
          <link>'.$link.'</link>
          <guid isPermaLink="false">'.$link.'</guid>
          <author>author@repository.com</author>
          <category>General</category>
          <description><![CDATA[Respositorio web Instituto Vicente Leon <strong>feed</strong>.]]></description>
        </item>
      </channel>
    </rss>';
  }else{
    $feed='<?xml version="1.0" encoding="utf-8"?>';
    $feed.='<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
    $feed.='<channel>';
    $feed.='<generator>RSS Builder by B!Soft</generator>';
    $feed.='<title>Repositorio</title>';
    $feed.="<link>$link</link>";
    $feed.='<description>Description</description>';
    $feed.='<language>es-es</language>';
    $feed.='<managingEditor>author@repository.com</managingEditor>';
    $feed.='<webMaster>webmaster@repository.com</webMaster>';
    $feed.='<copyright>2023 Repositorio</copyright>';
    $feed.='<atom:link href="'.$link.'/rss" rel="self" type="application/rss+xml" />';
    if(mysqli_num_rows($resultCarousel)>0){
      while ($row=mysqli_fetch_assoc($resultCarousel)) {
          $feed.='<item>';
          $feed.="<title>$row[projc_tit_projc]</title>";
          $feed.="<pubDate>".date("D, d M Y H:i:s",strtotime($row["projc_fec_projc"]))." -0500</pubDate>";
          $feed.="<description><![CDATA[$row[projc_rem_projc].]]></description>";
          $feed.="<link>$link/handler?id=$row[projc_cod_projc]</link>";
          $feed.='<guid isPermaLink="false">'.$row["projc_cod_projc"].'</guid>';
          $feed.='</item>';
        }
    }
    $feed.='</channel>';
    $feed.='</rss>';
    echo $feed;
  }
?>