<?php
    class category extends database{
        function __construct(){
            $this->table = 'categories';
            database::__construct();
        }

        public function addCategory($data, $is_die=false){
            return $this->addData($data, $is_die);
        }

        public function getCategorybyId($category_id, $is_die=false){
            $args = array(
                // 'fields' => array('categoryname', 'email', 'password'),
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $category_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllCategory($is_die=false){
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

        public function countCategory(){
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

        public function updateCategoryById($data, $id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->updateData($data,$args,$is_die);
        }

        public function deleteCategoryById($id, $is_die=false){
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