<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Application/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单


function getIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        } 
    }
    return $realip;

}
function isbot($useragent){
	if (strpos($useragent, 'googlebot')!== false){$bot = 'Google';}
	elseif (strpos($useragent,'mediapartners-google') !== false){$bot = 'Google Adsense';}
	elseif (strpos($useragent,'baiduspider') !== false){$bot = 'Baidu';}
	elseif (strpos($useragent,'baidu') !== false){$bot = 'Baidu';}
	elseif (strpos($useragent,'sogou spider') !== false){$bot = 'Sogou';}
	elseif (strpos($useragent,'sogou web') !== false){$bot = 'Sogou web';}
	elseif (strpos($useragent,'sosospider') !== false){$bot = 'SOSO';}
	elseif (strpos($useragent,'360spider') !== false){$bot = '360Spider';}
	elseif (strpos($useragent,'yahoo') !== false){$bot = 'Yahoo';}
	elseif (strpos($useragent,'msn') !== false){$bot = 'MSN';}
	elseif (strpos($useragent,'msnbot') !== false){$bot = 'msnbot';}
	elseif (strpos($useragent,'sohu') !== false){$bot = 'Sohu';}
	elseif (strpos($useragent,'yodaoBot') !== false){$bot = 'Yodao';}
	elseif (strpos($useragent,'twiceler') !== false){$bot = 'Twiceler';}
	elseif (strpos($useragent,'ia_archiver') !== false){$bot = 'Alexa_';}
	elseif (strpos($useragent,'iaarchiver') !== false){$bot = 'Alexa';}
	elseif (strpos($useragent,'slurp') !== false){$bot = '雅虎';}
	elseif (strpos($useragent,'bot') !== false){$bot = '其它蜘蛛';} 
	return $bot;
}
//$ip1 = getenv("REMOTE_ADDR");
$ip2 = getIP();

//$host1 = gethostbyaddr($ip1);
$host2 = gethostbyaddr($ip2);
//file_put_contents("spidertest.txt",'host1:'.$hots1.'  host2:'.$host2.'\r\n',FILE_APPEND);

$useragent = addslashes(strtolower($_SERVER['HTTP_USER_AGENT']));
$bot = isbot($useragent);
$flag = isbot($host2) ? '***':'-';
$str = $flag."\t". date('Y-m-d H:i:s')."\t".$_SERVER["REMOTE_ADDR"]."\t".$bot."\t".'IP:'.$ip2.' HOST:'.$host2."\t".'url:http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."\t".$useragent."\r\n";
if(isset($bot)){
	//$str = date('Y-m-d H:i:s')."\t".$_SERVER["REMOTE_ADDR"]."\t".$bot."\t".' HOST:'.$host2."\t".'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."\r\n";
	//$fp = @fopen('spidertest.txt','a');
	//fwrite($fp,);
	//fclose($fp);
	file_put_contents("spidertest.txt",$str ,FILE_APPEND);
}