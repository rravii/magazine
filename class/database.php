<?php 
    class database{
        protected $conn;
        protected $stmt;
        protected $sql;
        protected $table;

        function __construct(){
            try{
                $this->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->exec('SET NAMES UTF8');
                // echo "Database connected Success";
                return true;
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (DB Connection) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }

        function runQuery($sql){
            try{
                $this->sql = $sql;
                $this->stmt = $this->conn->prepare($this->sql);
                $this->stmt->execute();
                return true;
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (run Query database) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }

        function getDataFromQuery($sql){
            try{
                $this->sql = $sql;
                $this->stmt = $this->conn->prepare($this->sql);
                $this->stmt->execute();
                $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (getDataFromQuery) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }

        protected function addData($data, $is_die=false){
            // INSERT INTO TABLE SET
            //     columnname = :columnname,
            //     columnname = :columnname,
         
            try{
                $this->sql = "INSERT INTO ";

                //table name start
                if(isset($this->table) && !empty($this->table)){
                    $this->sql.=$this->table;
                    $this->sql.=" SET ";
                }else{
                    throw new Exception("Data cannot be inserted without table name");
                }
                //table name ends


                if(isset($data) && !empty($data)){
                    if(is_array($data)){
                        $col = array();
                        //columnname = :columnname, //yasto print garna ko lagi 
                        //columnname = :columnname,
                        foreach ($data as $columnname => $value){
                            // $this->sql.=$columnname." = :".$columnname."," 
                            // yo mathi ko line ma problem k auxa bhanae append gardai garo last value ma chai , audinxa & we dont need that
                            //one method is conditional method other is down below
                            $col[] = $columnname." = :".$columnname; // $col[] this means append hudai janxa...yo ma last ma comma audaina check using debbuger function
                        } 
                        $this->sql.=implode(', ', $col); //$col ma bhakolai , ra whitspace le jodxa
                        // debugger(implode(', ', $col), true);
                    }else{
                        $this->sql.=$data; // string form ma data ayo bhane ***we cant deny wala part**
                    }
                }else{
                    throw new Exception('Data cannot be inserted without data');
                }

                if ($is_die){
                    echo $this->sql;
                    exit();
                }

                $this->stmt=$this->conn->prepare($this->sql); //statement ma gayo query

                //value bind
                if(isset($data) && !empty($data)){
                    if(is_array($data)){
                        foreach ($data as $columnname => $value){
                            if (is_int($value)){
                                $param = PDO::PARAM_INT;
                            }else if(is_bool($value)){
                                $param = PDO::PARAM_BOOL;
                            }else{
                                $param = PDO::PARAM_STR;
                            }
                            $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                        }
                    }
                }else{
                    throw new Exception('Data cannot be inserted without data');
                }

                //value bind ends
                $success = $this->stmt->execute();
                return $success;
               
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }catch(Exception $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }

        protected function getData($args, $is_die=false){ //$args is array here
            // SELECT fields(*) FROM Tablename
            //     WHERE
            //         columnname = :columnname and //yaha or in huna sakxa ani and or dubai ni huna sakxa
            //         columnname = :columnname and
            //         columnname = :columnname

                // OREDER by columnname ASC|DESC

                // LIMIT offset, no_of_data
                try{
                    $this->sql = "SELECT ";

                    //fields
                    if (isset($args['fields']) && !empty($args['fields'])){//args ma fields xa bhanae 
                        if(is_array($args['fields'])){
                            $this->sql.=implode(', ', $args['fields']);
                        }else{
                            $this->sql.=$args['fields']." ";
                        }
                    }else{//yadi xaina bhanae sabai fields lai set garnae, here * denotes all
                        $this->sql.=" * ";
                    }

                    //fields ends
    
                    $this->sql.=" FROM ";

                    //table name start
                    if(isset($this->table) && !empty($this->table)){
                        $this->sql.=$this->table;
                    }else{
                        throw new Exception("Data cannot be inserted without table name");
                    }
                    //table name ends
    
    
                    if(isset($args['where']) && !empty($args['where'])){
                        if (is_array($args['where'])){
                            $this->sql.=' WHERE ';
                            if(isset($args['where']['and']) && !empty($args['where']['and'])){
                                $col_and = array();
                                foreach($args['where']['and'] as $columnname => $value){
                                    $col_and[] = $columnname." = :".$columnname;
                                }
                                $this->sql.=implode(' and ', $col_and);
                            }

                            if(isset($args['where']['or']) && !empty($args['where']['or'])){
                                $col_or = array();
                                foreach($args['where']['or'] as $columnname => $value){
                                    $col_or[] = $columnname." = :".$columnname;
                                }
                                $this->sql.=implode(' or ', $col_or);
                            }
                        }else{
                            $this->sql.=$args['where'];
                        }
                    }

                    //Ordering

                    if(isset($args['order']) && !empty($args['order'])){
                        if($args['order'] == 'DESC'){
                            $this->sql.=" order by id DESC ";
                        }else{
                            $this->sql.=" order by id ASC ";
                        }
                    }else{
                        $this->sql.=" order by id DESC "; // why DESC default because news website recent news should be at the top of the page
                    }

                    //Ordering ends

                    if(isset($args['limit']) && !empty($args['limit'])){
                        $this->sql.=" LIMIT ".$args['limit']['offset'].", ".$args['limit']['no_of_data'];
                    }
    
                    if ($is_die){
                        echo $this->sql;
                        exit();
                    }
    
                    $this->stmt=$this->conn->prepare($this->sql); //statement ma gayo query
    
                    //value bind
                    if(isset($args['where']) && !empty($args['where'])){
                        if (is_array($args['where'])){
                            if(isset($args['where']['and']) && !empty($args['where']['and'])){
                                foreach ($args['where']['and'] as $columnname => $value){
                                    if (is_int($value)){
                                        $param = PDO::PARAM_INT;
                                    }else if(is_bool($value)){
                                        $param = PDO::PARAM_BOOL;
                                    }else{
                                        $param = PDO::PARAM_STR;
                                    }
                                    $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                                }
                            }

                            if(isset($args['where']['or']) && !empty($args['where']['or'])){
                                foreach ($args['where']['or'] as $columnname => $value){
                                    if (is_int($value)){
                                        $param = PDO::PARAM_INT;
                                    }else if(is_bool($value)){
                                        $param = PDO::PARAM_BOOL;
                                    }else{
                                        $param = PDO::PARAM_STR;
                                    }
                                    $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                                }
                            }
                        }
                    }
    
                    //value bind ends
                    $this->stmt->execute();
                    $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
                    return $data;
                   
                }catch(PDOException $e){
                    error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                    return false;
                }catch(Exception $e){
                    error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                    return false;
                }
        }

        protected function updateData($data,$args,$is_die=false){
            // UPDATE tablename SET
            //     columnname = :columnnames, // columnnames yo chai $data ko lagi bho
            //     columnname = :columnnames
            // where
            //     columnname = :columnname, // columnname yo chai $args ko lagi bho
            //     columnname = :columnname
            try{
                $this->sql = "UPDATE ";

                //table name start
                if(isset($this->table) && !empty($this->table)){
                    $this->sql.=$this->table;
                    $this->sql.=" SET ";
                }else{
                    throw new Exception("Data cannot be inserted without table name");
                }
                //table name ends


                if(isset($data) && !empty($data)){
                    if(is_array($data)){
                        $col = array();
                        //columnname = :columnname, //yasto print garna ko lagi 
                        //columnname = :columnname,
                        foreach ($data as $columnname => $value){
                            // $this->sql.=$columnname." = :".$columnname."," 
                            // yo mathi ko line ma problem k auxa bhanae append gardai garo last value ma chai , audinxa & we dont need that
                            //one method is conditional method other is down below
                            $col[] = $columnname." = :".$columnname."s"; // $col[] this means append hudai janxa...yo ma last ma comma audaina check using debbuger function
                        } 
                        $this->sql.=implode(', ', $col); //$col ma bhakolai , ra whitspace le jodxa
                        // debugger(implode(', ', $col), true);
                    }else{
                        $this->sql.=$data; // string form ma data ayo bhane ***we cant deny wala part**
                    }
                }else{
                    throw new Exception('Data cannot be inserted without data');
                }

                if(isset($args['where']) && !empty($args['where'])){
                    if (is_array($args['where'])){
                        $this->sql.=' WHERE ';
                        if(isset($args['where']['and']) && !empty($args['where']['and'])){
                            $col_and = array();
                            foreach($args['where']['and'] as $columnname => $value){
                                $col_and[] = $columnname." = :".$columnname;
                            }
                            $this->sql.=implode(' and ', $col_and);
                        }

                        if(isset($args['where']['or']) && !empty($args['where']['or'])){
                            $col_or = array();
                            foreach($args['where']['or'] as $columnname => $value){
                                $col_or[] = $columnname." = :".$columnname;
                            }
                            $this->sql.=implode(' or ', $col_or);
                        }
                    }else{
                        $this->sql.=$args['where'];
                    }
                }

                if ($is_die){
                    echo $this->sql;
                    exit();
                }

                $this->stmt=$this->conn->prepare($this->sql); //statement ma gayo query

                //value bind
                if(isset($data) && !empty($data)){
                    if(is_array($data)){
                        foreach ($data as $columnname => $value){
                            if (is_int($value)){
                                $param = PDO::PARAM_INT;
                            }else if(is_bool($value)){
                                $param = PDO::PARAM_BOOL;
                            }else{
                                $param = PDO::PARAM_STR;
                            }
                            $this->stmt->bindValue(":".$columnname."s", $value, $param); //statement binding
                        }
                    }
                }else{
                    throw new Exception('Data cannot be inserted without data');
                }

                if(isset($args['where']) && !empty($args['where'])){
                    if (is_array($args['where'])){
                        if(isset($args['where']['and']) && !empty($args['where']['and'])){
                            foreach ($args['where']['and'] as $columnname => $value){
                                if (is_int($value)){
                                    $param = PDO::PARAM_INT;
                                }else if(is_bool($value)){
                                    $param = PDO::PARAM_BOOL;
                                }else{
                                    $param = PDO::PARAM_STR;
                                }
                                $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                            }
                        }

                        if(isset($args['where']['or']) && !empty($args['where']['or'])){
                            foreach ($args['where']['or'] as $columnname => $value){
                                if (is_int($value)){
                                    $param = PDO::PARAM_INT;
                                }else if(is_bool($value)){
                                    $param = PDO::PARAM_BOOL;
                                }else{
                                    $param = PDO::PARAM_STR;
                                }
                                $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                            }
                        }
                    }
                }

                //value bind ends
                $success = $this->stmt->execute();
                return $success;
               
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }catch(Exception $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }

        }

        protected function deleteData($args,$is_die=false){
            // DELETE FROM tablename
            //     where

            try{
                $this->sql = "DELETE FROM ";

                //table name start
                if(isset($this->table) && !empty($this->table)){
                    $this->sql.=$this->table;
                }else{
                    throw new Exception("Data cannot be inserted without table name");
                }
                //table name ends


                if(isset($args['where']) && !empty($args['where'])){
                    if (is_array($args['where'])){
                        $this->sql.=' WHERE ';
                        if(isset($args['where']['and']) && !empty($args['where']['and'])){
                            $col_and = array();
                            foreach($args['where']['and'] as $columnname => $value){
                                $col_and[] = $columnname." = :".$columnname;
                            }
                            $this->sql.=implode(' and ', $col_and);
                        }

                        if(isset($args['where']['or']) && !empty($args['where']['or'])){
                            $col_or = array();
                            foreach($args['where']['or'] as $columnname => $value){
                                $col_or[] = $columnname." = :".$columnname;
                            }
                            $this->sql.=implode(' or ', $col_or);
                        }
                    }else{
                        $this->sql.=$args['where'];
                    }
                }

                if ($is_die){
                    echo $this->sql;
                    exit();
                }

                $this->stmt=$this->conn->prepare($this->sql); //statement ma gayo query

                //value bind
                if(isset($args['where']) && !empty($args['where'])){
                    if (is_array($args['where'])){
                        if(isset($args['where']['and']) && !empty($args['where']['and'])){
                            foreach ($args['where']['and'] as $columnname => $value){
                                if (is_int($value)){
                                    $param = PDO::PARAM_INT;
                                }else if(is_bool($value)){
                                    $param = PDO::PARAM_BOOL;
                                }else{
                                    $param = PDO::PARAM_STR;
                                }
                                $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                            }
                        }

                        if(isset($args['where']['or']) && !empty($args['where']['or'])){
                            foreach ($args['where']['or'] as $columnname => $value){
                                if (is_int($value)){
                                    $param = PDO::PARAM_INT;
                                }else if(is_bool($value)){
                                    $param = PDO::PARAM_BOOL;
                                }else{
                                    $param = PDO::PARAM_STR;
                                }
                                $this->stmt->bindValue(":".$columnname, $value, $param); //statement binding
                            }
                        }
                    }
                }

                //value bind ends
                $this->stmt->execute();
                return true;
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }catch(Exception $e){
                error_log(Date("M d, Y h:i:s a").' : (addData) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }
    }
?>