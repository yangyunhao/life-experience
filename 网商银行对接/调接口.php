<?php
    class bank {
        private $original = [
            'version'    => '2.0',
            'partner_id' => '200001220534', //  合作者ID
            'charset'    => 'UTF-8', //
        ];
        private $url       = 'http://test.tc.mybank.cn/gop/gateway.do';
        private $uid       = '2c7e7482cbad43f4b0ebb7793a00277c'; // 合作方企业平台ID 随便来的一个  2c7e7482cbad43f4b0ebb7793a00277c
        //private $signUrl = 'http://192.168.1.106:8080/forwarder/getSign'; // 获取签名URL
        //private $signUrl = 'http://192.168.1.10:8888/forwarder/getSign'; // 获取签名URL
        private $signUrl   = 'http://101.251.247.162:8000/forwarder/getSign'; // 获取签名URL
        private $sign_type = 'TWSIGN'; // 签名类型
        private $method    = 'POST'; // 请求类型

        /*
         * Effect 开户
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function open(){
            $parameter              = [
                'charset'                    => 'UTF-8', //
                'partner_id'                 => '200001220534', //  合作者ID
                'service'                    => 'mybank.tc.user.enterprise.register', // 请求地址
                'version'                    => '2.0',
                'uid'                        => '2c7e7482cbad43f4b0ebb7793a00277c', // 合作方企业平台ID 随便来的一个  2c7e7482cbad43f4b0ebb7793a00277c
                'enterprise_name'            => '*****幼儿园', // 企业名称
                'unified_social_credit_code' => '132' // 统一社会信用代码
            ]; // 组装参数
            $sign                   = $this->curl($this->signUrl,$parameter,$this->method); // 获取签名
            $parameter['sign']      = $sign; // 签名
            $parameter['sign_type'] = $this->sign_type; // 签名类型
            $result                 = $this->curl($this->url,$parameter,$this->method); // 进行开户
            print_r($result);die; // {"charset":"UTF-8","is_success":"T","member_id":"200001240098"}
        }

        /*
         * Effect 绑卡
         * author yangyunhao
         * time   2017-11-3 17:25:15
         * */
        public function tieCard(){
            $parameter         = [
                'service'         => 'mybank.tc.user.bankcard.bind', // 接口名称
                'uid'             => '****************************', // 业务平台用户ID
                'bank_name'       => '民生银行', // 银行全称
                'branch_no'       => '***********', // 联行号
                'bank_account_no' => '*******',// 银行卡号
                'account_name'    => '北京***在线教育有限公司', // 开户名
                'card_type'       => 'DC', // 卡类型
                'card_attribute'  => 'B', // 卡属性
            ];// 组装请求参数
            $data              = array_merge($parameter,$this->original);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            print_r($result);die;
            //{"bank_id":"1261","charset":"UTF-8","is_success":"T"}
        }

        /*
         * Effect 省市查询
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function area(){
            $parameter         = [
                'service'              => 'mybank.tc.user.area.query',
                'parent_district_code' => 'ROOT'
            ]; // 参数组装 北京 为 110000 河北为 130000 承德为 130800
            $data              = array_merge($parameter,$this->original);
            $sign              = $this->curl($this->signUrl,$data,'POST');
            $data['sign']      = $sign; // 签名
            $data['sign_type'] = $this->sign_type; // 签名类型
            $result            = $this->curl($this->url,$data,$this->method);
            $result            = json_decode($result,true);
            $result            = isset($result['district_list'])?$result['district_list']:[]; // 数据检测降维
            print_r($result);die;
        }

        /*
         * Effect 银行列表查询
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function bankList(){
            $parameter         = [
                'service'          => 'mybank.tc.user.area.bank.query',
                'parent_branch_no' => 'ROOT', // 父连号
                'area_code'        => '110108', // 区域编码
            ]; // 参数组装
            $data              = array_merge($parameter,$this->original);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            $result            = json_decode($result,true);
            print_r($result);die;
        }

        /*
         * Effect 银行卡列表
         * author yangyunhao
         * time   2017-11-3 21:07:53
         * */
        public function bankCardList(){
            $parameter         = [
                'uid'     => $this->uid,
                'service' => 'mybank.tc.user.bankcard.query',
            ];
            $data              = array_merge($this->original,$parameter);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            $result            = json_decode($result,true);
            print_r($result);die;
        }

        /*
         * Effect 解绑
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function destroy(){
            $parameter         = [
                'uid'     => $this->uid, // 合作方业务平台ID
                'bank_id' => '1261', // 银行卡编号
                'service' => 'mybank.tc.user.bankcard.unbind', // 接口地址
            ]; // 组装参数
            $data              = array_merge($this->original,$parameter); // 合并公共请求参数 与 此接口请求参数
            $sign              = $this->curl($this->signUrl,$data,$this->method); // 获取签名
            $data['sign']      = $sign; // 组装签名
            $data['sign_type'] = $this->sign_type; // 组装签名类型
            $result            = $this->curl($this->url,$data,$this->method); // 解绑银行卡
            print_r($result);die;
        }

        /*
         * Effect 获取银行卡列表
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function getBankList(){
            $parameter         = [
                'uid'     => '1653053daa784899ab1a2bfc4ac2e8c2',
                'service' => 'mybank.tc.user.bankcard.query', // 接口地址
            ];
            $data              = array_merge($this->original,$parameter);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            print_r($result);die;
        }

        /*
         * Effect 提现
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function withdrawals(){
            $trade_no          = md5(time());
            $parameter         = [
                'outer_trade_no'      => $trade_no,
                'uid'                 => '27166d815c9b440bba37678099ad3e6c',
                'outer_inst_order_no' => $trade_no,
                'white_channel_code'  => 'MYBANK00055',
                'account_type'        => 'BASIC',
                'bank_id'             => '1328',
                'amount'              => '1.00',
                'notify_url'          => 'http://xfb.xiaohe.com/Bank/withdrawalsNotify',
                'service'             => 'mybank.tc.trade.paytocard',
            ];
            $data              = array_merge($parameter,$this->original);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            $result            = json_decode($result,true);
            print_r($result);die;
        }

        /*
         * Effect CURL 请求
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function query(){
            $parameter         = [
                'start_time' => '20140101020101',
                'end_time'   => '20140617020101',
                'service'    => 'mybank.tc.trade.query', // 接口地址
            ];
            $data              = array_merge($this->original,$parameter);
            $sign              = $this->curl($this->signUrl,$data,$this->method);
            $data['sign']      = $sign;
            $data['sign_type'] = $this->sign_type;
            $result            = $this->curl($this->url,$data,$this->method);
            $result            = json_decode($result,true);
            print_r($result);die;
        }

        /*
         * Effect CURL 请求
         * author yangyunhao
         * time   2017-11-3 15:43:23
         * */
        public function curl($url,$data,$method){
            $ch = curl_init();   //1.初始化
            curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式
            //4.参数如下
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

            if($method=="POST"){//5.post方式的时候添加数据
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo = curl_exec($ch);//6.执行

            if (curl_errno($ch)) {//7.如果出错
                return curl_error($ch);
            }
            curl_close($ch);//8.关闭
            return $tmpInfo;
        }
    }

    $bank = new bank();
    //$bank->open(); // 开户
    //$bank->tieCard(); // 绑卡
    //$bank->area(); // 省市查询
    //$bank->bankList(); // 银行列表
    //$bank->bankCardList(); // 银行卡列表
    //$bank->getBankList(); // 获取银行卡列表
    //$bank->destroy(); // 解绑
    //$bank->withdrawals(); // 提现
    $bank->query(); // 提现
?>