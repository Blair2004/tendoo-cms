<?php
/*
 * License Key Management Class can generate random license keys
 * The length and formatting of these keys can be customised. 
 * The class is also capable of validating these keys on passing 
 * the parameters with which the key was generated.
 * Author: Abhishek Shukla, Lucknow, India;
 * mail: abhishek_rttc@yahoo.com;
 * web: www.eeyesolutions.com;
 * version: 1.1 /2014-01-15
 * (C) 2014 Abhishek Shukla
     This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
if (!defined("LICENSE_KEY_INC")) {
    define("LICENSE_KEY_INC", 1) ;
    
//34 symbols unweghted code
class license_key
{
    public $keylen= 16;// recommended lengths 8,10,12,14,16,20
    public $basechar='23456789ABCDEFGHJKLMNPQRSTUVWXYZ';//32 symbols
    public $formatstr= '4444'; //characters in each segment, max 5 segments
    public $isvalid=true; //returns this value for valid keys
    public $invalid=false; //returns this value for invalid keys
    public $software="Nexo"; //name of software for which key is to be generated

    public function codeGenerate($name="")
    {
        $keylen= $this->keylen;
        $initlen=$this->initLen();
        $initcode=$this->initCode($initlen);
        $fullcode=$this->extendCode($initcode, $name);
        return $this->formatLicense($fullcode);
    }
    
    public function codeValidate($serial, $name="")
    {
        //return false on empty serial
        if (empty($serial)|| $serial=="") {
            return $this->invalid;
        }
        //remove formating to get plain string
        $serial=str_replace("-", "", $serial);
        $serial=strtoupper($serial);
        $serial=str_replace(array("0", "1", "O", "I", ),
                            array("", "", "", "", ),
                            $serial);
        $keylen= $this->keylen; //default length
        $thislen=strlen($serial);
        //check length of code
        if ($keylen<>$thislen) {
            return $this->invalid;
        }
        $initlen=$this->initLen();
        $initcode=substr($serial, 0, $initlen);
        $extendedcode=$this->extendCode($initcode, $name);
        $fullcode=substr($extendedcode, 0, $keylen);
        if ($fullcode==$serial) {
            return $this->isvalid;
        } else {
            return $this->invalid;
        }
    }

    public function initCode($length=14)
    {
        $list=$this->basechar;
        $lenlist=strlen($list)-1; //count start from 0
        $codestring="";
        $length=max($length, 1);
        if ($length>0) {
            while (strlen($codestring)<$length) {
                $codestring.=$list[mt_rand(0, $lenlist)];
            }
        }
        return $codestring;
    }
    
    public function extendCode($initcode, $name)
    {
        $software=$this->software;
        $p1str=$this->sumDigit($initcode);
        $p1str.=$this->add32($initcode, $name."abhishek".$software);
        $p1str=strtoupper($p1str);
        $p1str=str_replace(array("0", "1", "O", "I", ),
                            array("", "", "", "", ),
                            $p1str);
        $p1len=strlen($p1str);
        $extrabit="";
        $i=0;
        while (strlen($extrabit)<$this->keylen-2) {
            $extrabit.=substr($p1str, $i, 1);
            $extrabit.=substr($p1str, $p1len-$i-1, 1);
            $i++;
            if (defined('LKM_DEBUG')) {
                echo "$p1str $extrabit<br/>";
            }
        }
        return $initcode.$extrabit."6F75";
    }

    public function formatLicense($serial)
    {
        $farray=str_split($this->formatstr);
        $sarray=str_split($serial);
        $s0=$farray[0];
        $s1=$farray[1]+$s0;
        $s2=$farray[2]+$s1;
        $s3=$farray[3]+$s2;
        $s4=$farray[3]+$s3;
        $scount=$this->keylen;
        $sformated="";
        for ($i=0;$i<$scount;$i++) {
            if ($i==$s0||$i==$s1||$i==$s2||$i==$s3||$i==$s4) {
                $sformated.="-";
            }
            $sformated.=$sarray[$i];
        }
        if (defined('LKM_DEBUG')) {
            echo " $serial FORMATED AS $sformated<br/>";
        }
        
        return $sformated;
    }
    
    public function initLen()
    {
        $keylen=$this->keylen;
        $initlen=intval($keylen/3);
        $initlen=max($initlen, 1);
        return $initlen;
    }
    
    public function add32($a, $b)
    {
        $sum=base_convert($a, 36, 10)+base_convert($b, 36, 10);
        $sum32=base_convert($sum, 10, 36);
        $sum32=str_replace(array("0", "1", "O", "I", "o", "i"),
                            array("", "", "", "", "", "", ),
                            $sum32);
        if (defined('LKM_DEBUG')) {
            echo " ADD32 $a + $b = $sum32<br/>";
        }
        return $sum32;
    }
    

    public function sumDigit($str)
    {
        $a=str_split($str);
        $sum=0;
        for ($i=0;$i<count($a);$i++) {
            $sum=$sum+base_convert($a[$i], 36, 10);
        }
        $sum=str_replace(array("0", "1", "O", "I", "o", "i"),
                            array("AZ", "BY", "29", "38", "29", "38", ),
                            $sum);
        if (defined('LKM_DEBUG')) {
            echo " sumDigit  $str = $sum<br/>";
        }
        return $sum;
    }
}
}
