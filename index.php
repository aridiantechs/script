<?php

ini_set('display_errors', 1);
ini_set('max_execution_time', '0');
error_reporting(E_ALL);

include_once('simple_html_dom.php');
require_once (__DIR__ . '/vendor/autoload.php');
use Rct567\DomQuery\DomQuery;


// $servername = "localhost";
// $username = "aridtlpn_kundkontakter_user";
// $password = "A)Ro#7Ups_ZN";
// $dbname = "aridtlpn_kundkontakter";

// Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


function get_web_page( $url )
    {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(
    
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
    
    
    $numbers = [762272103,
762273207,
762273667,
858172311,
762276741,
722514121,

            ];
    
    
    foreach($numbers as $number){
        
            
            $url = 'https://www.merinfo.se/search?who=0'.$number.'&where=';
            
            $result = get_web_page($url);
        
            // print_r($result['content']);
            
            $html = $result['content'];
            
            $dom = str_get_html($html);
            
            $page_links = [];
            
            foreach($dom->find('.link-primary') as $element){
                $page_links[] = $element->href;
            }
            
            if(empty($page_links)){
                
                echo 'No result found';
                
            }else{
                foreach($dom->find('.btn-primary') as $element){
                    if(trim($element->text()) == 'Företag'){
                        
                        $company_name = '';
                        
                        foreach($dom->find('.link-primary') as $element){
                            $company_name = $element->text();
                        }
                        
                        
                        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
                            $txt = '0' . $number .' - '. $company_name . "\n" ;
                            fwrite($myfile, $txt);
                            fclose($myfile);
                    }
                    
                }
            }
               
           
    }
    
    // echo json_encode($person_data);
    
    
    
    
    
    
    