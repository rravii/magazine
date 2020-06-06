<?php
    class ads extends database{
        function __construct(){
            $this->table = 'advertisement';
            database::__construct();
        }

        public function addAds($data, $is_die=false){
            return $this->addData($data, $is_die);
        }

        public function getAdsbyId($ads_id, $is_die=false){
            $args = array(
                // 'fields' => array('adsname', 'email', 'password'),
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $ads_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllAds($is_die=false){
            $args = array(
                'fields' => ["id",
                            "url",
                            "adType",
                            "image"],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'status' => 'Active',
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAdsByAdtypeWidead($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            "adType" => 'widead'
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAdsByAdtypeSimplead($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            "adType" => 'simplead'
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function updateAdsById($data, $id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->updateData($data,$args,$is_die);
        }

        public function deleteAdsById($id, $is_die=false){
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