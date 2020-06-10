<?php
    class subscribe extends database{
        function __construct(){
            $this->table = 'subscribes';
            database::__construct();
        }

        public function addSubscribe($data, $is_die=false){
            return $this->addData($data, $is_die);
        }

        public function searchSubscribeByEmail($email, $is_die=false){
            $args = array(
                'where' => " where email LIKE '".$email."%' "
            );

            return $this->getData($args, $is_die);
        }

        public function getSubscribebyId($subscribe_id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $subscribe_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllSubscribe($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'status' => 'Active',
                        )
                        ),
                'order' => 'ASC',
            );

            return $this->getData($args, $is_die);
        }

        public function countSubscribe(){
            try{
                $this->sql = 'select count(*) from '.$this->table;
                $this->stmt = $this->conn->prepare($this->sql);
                $this->stmt->execute();
                $data = $this->stmt->fetchColumn(); 
                return $data;
            }catch(PDOException $e){
                error_log(Date("M d, Y h:i:s a").' : (getDataFromQuery) : '.$e->getMessage()."\r\n", 3, ERROR_PATH.'error.log');
                return false;
            }
        }

        public function updateSubscribeById($data, $id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->updateData($data,$args,$is_die);
        }

        public function deleteSubscribeById($id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->deleteData($args,$is_die);
        }
    }
?>