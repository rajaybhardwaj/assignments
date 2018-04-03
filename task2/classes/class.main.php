<?php

require $_SERVER['DOCUMENT_ROOT'] . "/src/aws/aws-autoloader.php";

class main {
    
    private $arrCsv = array();
    private $arrMysql = array();
    private $arrScp = array();
    private $arrAws = array();

    public function __construct(){
        $this->arrCsv   = array();
        $this->arrMysql = array();
        $this->arrScp   = array();
        $this->arrAws   = array();
        $this->error = '';
    }

    public function fetch_aws_data($params = array()) {

        $s3Client = new S3Client([
            'version'     => 'latest',
            'region'      => 'us-west-2',
            'credentials' => [
                'key'    => $params['access_key'],
                'secret' => $params['secret_key'],
            ],
        ]);

        $s3Client->registerStreamWrapper();
        
        $url = 's3://'.$params['bucket'].'/'.$params['csv_file'];
        
        $csv_file = fopen($url, 'r');
        
        $params = array('csv_col'=>$params['csv_col'],'csv_file'=>$csv_file,'csv_type'=>3);
        $this->fetch_csv_data($params);

    }

    public function fetch_mysql_data($params = array()) {
        
        $mysqli = new mysqli($params['host'],$params['user'],$params['password'],$params['database']);

        if($mysqli->connect_error){
            
            $this->error .= $mysqli->connect_error;
        } 

        $sql    = "SELECT ".$params['tbl_col']." FROM ".$params['tbl_name'];  
        $qry = $mysqli->query($sql);  
        if($qry->num_rows > 0){

            while($row = $qry->fetch_assoc()) {
                $this->arrMysql[] = $row[$params['tbl_col']];
            }

        }//end if 
    }

    public function fetch_scp_data($params = array()) {
        
        $connection = ssh2_connect($params['host'],$params['port']);
        if (ssh2_auth_password($connection, $params['user'], $params['password'])) {
                $sftp       = ssh2_sftp($connection);
                $csv_file   = fopen("ssh2.sftp://".intval($connection)."/home/".$params['csv_file'],'r');
                $paramArr     = array('csv_col'=>$params['csv_col'],'csv_file'=>$csv_file,'csv_type'=>2);
                $this->fetch_csv_data($paramArr);
        }
        

    }

    public function fetch_csv_data($params = array()) {
        extract($params);
        $checkRow = $colKey = 0;
        $is_col              = false;
        $returnArr          = array();
        while (($row = fgetcsv($csv_file, 0, ",")) !== FALSE) {
            if($checkRow == 0) {
                foreach($row as $col_key=>$col_val) {
                    if($csv_col == $col_val) {
                        $colKey = $col_key;
                        $is_col  = true; 
                    }
                }//end foreach

            } else {
                if($is_col) {
                    $returnArr[] = $row[$colKey]; 
                }
            }   //end if-else
            $checkRow++;
        }   //end while
        fclose($csv_file); 
        if($csv_type == 1){
            $this->arrCsv = $returnArr;

        }elseif($csv_type == 2){
            $this->arrScp = $returnArr;
            
        }elseif($csv_type == 3){
            $this->arrAws = $returnArr;
        }
        
    }

    public function submit_form() {
        
        if(count($_POST) > 0){
            foreach($_POST as $arrVal){
                if(is_array($arrVal)){
                    foreach($arrVal as $multiVal){
                        if(empty($multiVal)){
                            $this->error .= "Empty Field Value";
                        }
                    }
                }
            }
        }
        
        if(isset($_FILES["csv_file"])) {

            //if there was an error uploading the file
            if($_FILES["csv_file"]["error"] > 0) {
                echo "Error: " . $_FILES["csv_file"]["error"] . "<br />";

            }else{

                //Store file in directory "upload"
                $csv = "csv_".time().".csv";
                $csvUrl    = $_SERVER['DOCUMENT_ROOT']."/uploads/".$csv;
                $result      = move_uploaded_file($_FILES["csv_file"]["tmp_name"], $csvUrl);
                if($result) {

                    chmod($csvUrl,0777);
                    $csv_file = fopen($csvUrl, "r");
                    $params    = array('csv_col'=>$_POST['csv_col'],'csv_file'=>$csv_file,'csv_type'=>1);
                    
                    $this->fetch_csv_data($params);
                }
            }
        } else {
                $this->error .= "Not a valid csv file";
        }
        
        if($this->error == '') {
            $this->fetch_mysql_data($_POST['mysql']);
        }
        
        if($this->error == '') {
                $this->fetch_scp_data($_POST['scp']);
        }
        
        if($this->error == '') {
            $this->fetch_aws_data($_POST['s3']);
        }

        if($this->error == ''){
            $arrAws   = array_unique($this->arrAws);
            $arrMysql = array_unique($this->arrMysql);
            $sshArr   = array_unique($this->arrScp);
            $arrCsv   = array_unique($this->arrCsv);
                
            $newArr      = array_merge($arrAws,$arrMysql,$arrCsv);
            $tempArr     = array();
            $responseArr = array();
            foreach($newArr as $val){
                @$tempArr[$val]++;
                if(@$tempArr[$val] == 4){
                    $responseArr[] = $val;
                }
            }

            if(count($responseArr) > 0) {
                echo '<script>
                    var jsArr = '.json_encode($responseArr).';
                        var i = 0;
    
                        (function data() {
                            document.getElementById("output").innerHTML += "<tr><td>" + jsArr[i]+ "</td></tr>";
                            if (++i < jsArr.length) {
                                setTimeout(data, 3000); 
                            }
                        })(); 
                    </script>';
            }
        }
    }
}

?>