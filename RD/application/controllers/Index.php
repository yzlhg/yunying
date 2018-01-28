<?php
class IndexController extends Controller {

    //获取分支机构信息
    public function sonCompanyAction(){
        //获取请求的授权
        $request = file_get_contents('php://input');
        //数组化授权
        $requestArr = json_decode($request,true);
        $toKey = $requestArr['toKey'];
        $yac = new Yac();
        $yac->get($toKey.'IP') == Common::getIP() || exit('error');
        $toKeyValue = $yac->get($toKey);
        switch ($toKeyValue){
            case $this->surAuth['allEdit'] : $where = '';
                break;
            case $this->surAuth['allSelect'] : $where = '';
                break;
            case $this->surAuth['xlEdit'] : $where = ' WHERE FParentID = 437';
                break;
            case $this->surAuth['xlSelect'] : $where = ' WHERE FParentID = 437';
                break;
            default : $where = ' WHERE F_102 = '.$toKeyValue;
        }
        $sql = "SELECT FItemID,FName FROM t_sonCompany".$where;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $t_sonCompany = $sth->fetchAll();
        echo json_encode($t_sonCompany);
    }
    //处理得到的门店切换信息
    public function qhmdAction(){
        $params = file_get_contents('php://input');
        $params = json_decode($params,true);
        $toKey = $params['toKey'];
        $yac = new Yac();
        $clientIP = $yac->get($toKey.'IP');
        $clientIP == Common::getIP() || exit('error');
        $toKeyValue = $yac->get($toKey);
        $toKeyValue != $this->surAuth['allSelect'] || $toKeyValue != $this->surAuth['xlSelect'] || exit('error');
        $params['sonCompany'] = intval($params['sonCompany']);
        $params['sonCompany'] || exit('error');
        $params['emp'] = intval($params['emp']);
        $sql = "UPDATE t_LS_Cashier SET FBranchShop = ? WHERE FEmpID = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute(array($params['sonCompany'],$params['emp']));
        $response = $sth->fetch();
        echo $response;
    }
    //得到收银员信息
    public function cashierAction(){
        //获取请求的授权
        $request = file_get_contents('php://input');
        //数组化授权
        $requestArr = json_decode($request,true);
        $toKey = $requestArr['toKey'];
        $yac = new Yac();
        $yac->get($toKey.'IP') == Common::getIP() || exit('error');
        $sql = "SELECT t_LS_Cashier.FBranchShop as shopID,t_LS_Cashier.FEmpID as empID,t_Emp.FName as empName,t_sonCompany.FName as shopName FROM t_LS_Cashier INNER JOIN t_Emp ON t_LS_Cashier.FEmpID=t_Emp.FItemID LEFT JOIN t_sonCompany ON t_LS_Cashier.FBranchShop=t_sonCompany.FItemID";
        $toKeyValue = $yac->get($toKey);
        switch ($toKeyValue){
            case $this->surAuth['allEdit'] : $sql = $sql;
                break;
            case $this->surAuth['allSelect'] : $sql = $sql;
                break;
            case $this->surAuth['xlEdit'] : $sql = $sql.' WHERE t_Emp.FParentID = 320';
                break;
            case $this->surAuth['xlSelect'] :$sql = $sql.' WHERE t_Emp.FParentID = 320';
                break;
            default :$sql = $sql.' WHERE t_Emp.F_102 = '.$toKeyValue;
        }
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $cashier = $sth->fetchAll();
        echo json_encode($cashier);
    }
    //获取授权
    public function authAction(){
        //获取请求的授权
        $authCode = file_get_contents('php://input');
        //数组化授权
        $request = json_decode($authCode,true);
        $request['authCode'] = intval($request['authCode']);
        //对授权进行验证
        if ($request['authCode'] != ''){
            if (in_array($request['authCode'],$this->surAuth )){
                $cashier = $request['authCode'];
            } else {
                //获取收银员表的备注字段
                $sql = "SELECT F_102 FROM t_Emp WHERE F_102 = ?";
                $sth = $this->db->prepare($sql);
                $sth->execute([$request['authCode']]);
                $cashier = $sth->fetch();
            }
            if ($cashier){
                //获取客户端真实IP
                $clientIP = Common::getIP();
                //时间
                $clientTime = time();
                //进行yac缓存设置
                $yac = new Yac();
                $key = md5($authCode.$clientTime.$clientIP.'@seven');
                $keyIP = $key.'IP';
                $keyTime = $key.'Time';
                $yac->set(array($key=>$request['authCode'],$keyIP=>$clientIP,$keyTime=>$clientTime));
                echo $key;
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }


}
?>