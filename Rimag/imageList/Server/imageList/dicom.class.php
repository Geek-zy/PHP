<?php
class DicomService {
    
//   protected static $nurseAPI = '/imageList/getCountByAet.php?aetitle=';
//   protected static $hospitalAPI = '/imageList/json.php';
//    protected $hospitalAPI = '/test/json1.php';
//    protected static $patientAPI = '/imageList/patientJson.php';
//    protected $patientAPI = '/patientJson.php';
    public static $oviyamPort = 9527;
    public static $oviyamMobilePath = '/rms/series.html?studyUID=';
    public static $oviyamPath = '/rmsweb/viewer.html?studyUID=';
    public static $weasisPort = 9527;
    public static $weasisPath = '/weasis-pacs-connector/viewer.jnlp?studyUID=';
//    protected static $infinittURL = 'http://117.41.184.222/pkg_pacs/external_interface.aspx?LID=med&LPW=med&PID=__PATIENTID__&studyUID=__UUID__';
    public static $infinittURL = 'http://117.41.184.222/pkg_pacs/external_interface.aspx?LID=med&LPW=med&STUID=__UUID__';


    /*
     *功能：生成欧维雅影像链接
     *参数：$dcmIp:dcm IP,$UUID:影像instance_uid
     *返回：欧维雅链接
     */
    public static function getOviyam($dcmIp, $UUID) {
        if (!empty($dcmIp) and ! empty($UUID)) {
            $url = 'http://' . $dcmIp . ':' . self::$oviyamPort . self::$oviyamPath . $UUID;
            return $url;
        }
        return null;
    }

    /*
     *功能：生戺端欧维雅影像链接
     *参数：$dcmIp:dcm IP,$UUID:影像instance_uid
     *返回：手机端欧维雅链接
     */
    public static function getMobileOviyam($dcmIp, $UUID) {
        if (!empty($dcmIp) and ! empty($UUID)) {
            $url = 'http://' . $dcmIp . ':' . self::$oviyamPort . self::$oviyamMobilePath. $UUID;
            return $url;
        }
        return null;
    }

    /*
     *功能：生成一脉影像链接
     *参数：$dcmIp:dcm IP,$UUID:影像instance_uid
     *返回：一脉链接
     */
    public static function getWeasis($dcmIp, $UUID) {
        if (!empty($dcmIp) and ! empty($UUID)) {
            $url = 'http://' . $dcmIp . ':' . self::$weasisPort . self::$weasisPath . $UUID;
            return $url;
        }
        return null;
    }

    /*
     *功能：生成英飞达影像链接
     *参数：$patientId:患者院内ID号,$UUID:影像instance_uid
     *返回：英飞达链接
     */
    public static function getInfinitt($patientId, $UUID) {
        if (!empty($UUID)) {
            $needle = array( '__UUID__');
            $value = array($UUID);
            $url = str_replace($needle, $value, self::$infinittURL);
            return $url;
        }
        return null;
    }
}
