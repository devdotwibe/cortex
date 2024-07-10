<?php

namespace App\Support\Helpers; 

class ImageHelper
{
    public static function convertPdfToImage($file,$cachepath){ 
        $hash=md5("$file/render".time());
    
        $imginfo = new \Imagick();
        $imginfo->pingImage($file);    
    
        $count= $imginfo->getNumberImages();
    
        $imagic = new \Imagick();
        $imagic->readImage($file);
        $data=[];
        foreach ($imagic as $pageIndex => $page) {
    
            $page->setImageFormat('jpeg');  
            $imageBinary = $page->getImageBlob();
            $partLength = ceil(strlen($imageBinary) / 4);
            $parts = str_split($imageBinary, $partLength);
            
            $bydata=[];
            foreach ($parts as $index => $part) {
                $bytefile=sprintf("$hash-%02d-%02d.imc",$pageIndex,$index);
                $bydata[$index] = self::encryptData($bytefile,$hash);
                file_put_contents("$cachepath/$bytefile",self::encryptData($part,$hash));
            }
    
    
            $width = $page->getImageWidth();
            $height = $page->getImageHeight();
    
            $data[] = [
                'page' => $pageIndex + 1, 
                'width' => $width,
                'height' => $height,
                "data" => $bydata
            ];
        }
        $imagic->clear();
        $imagic->destroy();
    
        
        return [
            "hash"=>$hash,
            "count"=>$count,
            "data"=>$data
        ];
    } 
    public static function encryptData($data, $key) {
        $key = substr(hash('sha256', $key, true), 0, 32);
        $iv = random_bytes(16); 
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $encoded = base64_encode($iv . $encrypted); 
        return $encoded;
    }
    public static function decryptData($encoded, $key) { 
        $key = substr(hash('sha256', $key, true), 0, 32); 
        $decoded = base64_decode($encoded); 
        $iv = substr($decoded, 0, 16);
        $encrypted = substr($decoded, 16); 
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv); 
        return $decrypted;
    }
}
