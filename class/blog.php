<?php
    class blog extends database{
        function __construct(){
            $this->table = 'blogs';
            database::__construct();
        }

        public function addBlog($data, $is_die=false){
            return $this->addData($data, $is_die);
        }

        public function getBlogbyId($blog_id, $is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            'added_by',
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            "created_date"],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $blog_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        // SELECT * FROM `blogs` WHERE created_date LIKE '2020-05-30%'

        public function getBlogbyDate($date, $is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            "created_date"],
                'where' => " where created_date LIKE '".$date."%' "
            );

            return $this->getData($args, $is_die);
        }

        public function searchBlog($search,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            "created_date"],
                'where' => " where  status='Active' and title LIKE '%{$search}%' or title LIKE '".$search."%' or content LIKE '".$search."%'"
            );

            return $this->getData($args, $is_die);
        }


        public function getAllBlog($is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            "created_date"],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'status' => 'Active',
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllFeaturedBlogByCategoryWithLimit($cat_id,$offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'featured' => 'Featured',
                            'categoryid' => $cat_id,
                        )
                        ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllFeaturedBlogWithLimit($offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'featured' => 'Featured',
                        )
                        ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllRecentBlogByCategoryWithLimit($cat_id,$offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'featured' => 'notFeatured',
                            'categoryid' => $cat_id,
                        )
                        ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllRecentBlogWithLimit($offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                        )
                        ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        // SELECT COUNT(id) as total FROM blogs WHERE 'categoryid' = 6

        public function getNumberBlogByCategory($cat_id,$is_die=false){
            $args = array(
                'fields' => ['COUNT(id) as total'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'categoryid' => $cat_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllPopularBlogByCategoryWithLimit($cat_id,$offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'categoryid' => $cat_id,
                        )
                        ),
                'order' => array(
                        'columnname' => 'view',
                        'orderType' => 'DESC'
                ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllPopularBlogWithLimit($offset,$no_of_data,$is_die=false){
            $args = array(
                'fields' => ["id",
                            "title",
                            "content",
                            "featured",
                            "categoryid",
                            '(SELECT categoryname from categories
                                where id = categoryid) as category',
                            "view" ,
                            "image",
                            'created_date'],
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                        )
                        ),
                'order' => array(
                        'columnname' => 'view',
                        'orderType' => 'DESC'
                ),
                'limit' => array(
                        'offset' => $offset,
                        'no_of_data' => $no_of_data,
                )
            );

            return $this->getData($args, $is_die);
        }

        public function updateBlogById($data, $id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->updateData($data,$args,$is_die);
        }

        public function deleteBlogById($id, $is_die=false){
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