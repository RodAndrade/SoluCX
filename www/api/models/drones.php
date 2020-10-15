<?php 
    class Drones {
        static $columns = [
                    'image',
                    'name',
                    'address',
                    'battery',
                    'max_speed',
                    'average_speed',
                    'status'
                ];
        
        public function get($request = null, $response = null, $args = []){
            // Create database class
            $DB = new Database();
            $params = $request->getQueryParams();
            
            if(@$args['id'] AND is_numeric(@$args['id'])){
                $data = $DB->select('drone',[
                    'id' => $args['id']
                ]);
                
                if(@$data['cod'] == 200 AND count($data['result']) > 0){
                    $response->getBody()->write(
                        json_encode([
                            'cod' => 200,
                            'result' => $data['result'][0]
                        ])
                    );
                } else {
                    $response->getBody()->write(
                        json_encode([
                            'cod' => 403,
                            'message' => 'Drone não encontrado'
                        ])
                    );
                }
            } else {
                $response->getBody()->write(
                    json_encode([
                        'cod' => 403,
                        'message' => 'Drone não encontrado'
                    ])
                );
            }
            
            
            return $response;
        }
        
        public function list($request = null, $response = null, $args = []){
            // Create database class
            $DB = new Database();
            $params = $request->getQueryParams();
            $params = $DB->scape_string($params);
            
            if(@$params['_sort'] AND @$params['_order']){
                $order[$params['_sort']] = $params['_order'];
            } else { $order = []; }
                        
            $data = $DB->select('drone',[
                'id'            => (@$params['id']) ? $params['id'] : '%%',
                'image'         => (@$params['image']) ? '%'.$params['image'].'%' : '%%',
                'name'          => (@$params['name']) ? '%'.$params['name'].'%' : '%%',
                'address'       => (@$params['address']) ? '%'.$params['address'].'%' : '%%',
                'battery'       => (@$params['battery']) ? $params['battery'] : '%%',
                'max_speed'     => (@$params['max_speed']) ? $params['max_speed'] : '%%',
                'average_speed' => (@$params['average_speed']) ? $params['max_speed'] : '%%',
                'status'        => (@$params['status']) ? $params['status'] : '%%'
            ], $order, 'LIKE', [
                'page' => (@$params['_page']) ? $params['_page'] : 1,
                'limit' => (@$params['_limit']) ? $params['_limit'] : 10
            ]);
            
            if(@$data['cod'] AND @$data['cod'] == '200'){
                $response->getBody()->write(
                    json_encode($data)
                );
            } else {
                $response->getBody()->write(
                    json_encode($data)
                );
            }
            
            return $response;
        }
        
        public function insert($request = null, $response = null, $args = []){
            // Create database class
            $DB = new Database();
            $params = $request->getQueryParams();
            $params = $DB->scape_string($params);
            
            $required = [];
            foreach($params as $key => $par){
                if(@$par != ''){
                    $required[] = $key;
                }
            }
            $compare_parametros = array_diff(self::$columns, $required);
            if(count($compare_parametros) > 0){
                $response->getBody()->write(
                    json_encode([
                        'cod' => 400,
                        'message' => 'Por favor, informe o(s) campo(s): '.(implode(', ', $compare_parametros))
                    ])
                );
            } else {
                $insert = [];
                foreach($params as $key => $par){
                    if(@$par != '' AND in_array($key, self::$columns)){
                        $insert[$key] = $par;
                    }
                }
                
                if(count($insert) > 0){
                    $dataInsert = $DB->insert('drone', $insert);
                    
                    $response->getBody()->write(
                        json_encode($dataInsert)
                    );
                } else {
                    $response->getBody()->write(
                        json_encode([
                            'cod' => 404,
                            'message' => 'Nenhum dado informado para cadastro'
                        ])
                    );
                }
            }
            
            return $response;
        }
        
        public function update($request = null, $response = null, $args = []){
            // Create database class
            $DB = new Database();
            $params = $request->getQueryParams();
            $params = $DB->scape_string($params);
            
            if( @$args['id'] AND is_numeric($args['id'])){
                $update = [];
                foreach($params as $key => $par){
                    if(@$par != '' AND in_array($key, self::$columns)){
                        $update[$key] = $par;
                    }
                }
                
                if(count($update) > 0){
                    $dataUpdate = $DB->update('drone', $update, [
                        'id' => $args['id']
                    ]);
                    
                    $response->getBody()->write(
                        json_encode($dataUpdate)
                    );
                } else {
                    $response->getBody()->write(
                        json_encode([
                            'cod' => 404,
                            'message' => 'Nenhum dado informado para atualização'
                        ])
                    );
                }
            } else {
                $response->getBody()->write(
                    json_encode([
                        'cod' => 404,
                        'message' => 'Por favor, informe o id do drone'
                    ])
                );
            }
            
            return $response;
            
        }
        
        public function delete($request = null, $response = null, $args = []){
            // Create database class
            $DB = new Database();
            $params = $request->getQueryParams();
            
            if(@$args['id'] AND is_numeric(@$args['id'])){
                $data = $DB->delete('drone',[
                    'id' => $args['id']
                ]);
                
                if(@$data['cod'] == 200){
                    $response->getBody()->write(
                        json_encode([
                            'cod' => 200,
                            'message' => 'Drone deletado com sucesso'
                        ])
                    );
                } else {
                    $response->getBody()->write(
                        json_encode($data)
                    );
                }
            } else {
                $response->getBody()->write(
                    json_encode([
                        'cod' => 403,
                        'message' => 'Drone não encontrado'
                    ])
                );
            }
            
            
            return $response;
        }
    }
?>