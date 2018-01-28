<?php
    class Common{
        
        /**
         * @access public 
         * @param string $dir_path 文件夹
         * @return array 二维数组
         */

        public static function get_dirs($dir_path) {
            $res = array();
            $res_lists = array();
        
            foreach(glob("$dir_path/*") as $item) {
                if(is_dir($item)) {
                    $folder = end(explode('/', $item));
                    $res[$folder] =get_dirs($item);
                    continue;
                }
                $res[] = basename($item);
            }    
            return $res;   
        }

        // 定义一个函数getIP()获取客户端真实IP
        public static function getIP(){
            global $ip;
            if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
            else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
            else $ip = "Unknow";
            return $ip;
        }


}

?>