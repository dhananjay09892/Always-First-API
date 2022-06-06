<?php

/**
 * base_url
 *
 * Overwrites the base_url function to support
 * loading your asset from KeyCDN.
 */
function base_url($uri)
{
   $currentInstance =& get_instance();

   $keycdnUrl = $currentInstance->config->item('keycdn_url');

   $extensions = array('css', 'js', 'jpg', 'jpeg', 'png', 'gif','pdf');
   $pathParts = pathinfo($uri);

   if (!empty($keycdnUrl) && in_array($pathParts['extension'],$extensions)) {
      return $keycdnUrl . $uri;
   }

   return $currentInstance->config->base_url($uri);
}