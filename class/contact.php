<?php
    class contact extends database{
        function __construct(){
            $this->table = 'contacts';
            database::__construct();
        }

        public function addContact($data, $is_die=false){
            return $this->addData($data, $is_die);
        }

        public function getContactbyId($contact_id, $is_die=false){
            $args = array(
                // 'fields' => array('contactname', 'email', 'password'),
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $contact_id,
                        )
                    )
            );

            return $this->getData($args, $is_die);
        }

        public function getAllContact($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                        )
                        ),
                'order' => 'ASC',
            );

            return $this->getData($args, $is_die);
        }

        public function getAllAcceptContact($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'state' => 'accept',
                            'commentType' => 'comment',
                            'commentReplied' => 'notreplied'
                        )
                        ),
                'order' => 'ASC',
            );

            return $this->getData($args, $is_die);
        }

        public function getAllAcceptContacts($is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'state' => 'accept',
                            'commentType' => 'comment',
                        )
                        ),
                'order' => 'ASC',
            );

            return $this->getData($args, $is_die);
        }

        public function getAllAcceptReplyByComment($comment_id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'and' => array(
                            'status' => 'Active',
                            'state' => 'accept',
                            'commentType' => 'reply',
                            'commentid' => $comment_id
                        )
                        ),
                'order' => 'ASC',
            );

            return $this->getData($args, $is_die);
        }

        public function updateContactById($data, $id, $is_die=false){
            $args = array(
                'where' => array( //kun kun column and le jodnae nabhayae or le jodnae
                        'or' => array(
                            'id' => $id,
                        )
                    )
            );
            return $this->updateData($data,$args,$is_die);
        }

        public function deleteContactById($id, $is_die=false){
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