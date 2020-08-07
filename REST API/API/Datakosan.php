<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Datakosan extends REST_Controller
{
    public function __construct()
    { 
        parent::__construct();
        $this->load->model('Kosan_model','kosan');
    }

    public function index_get()
    {
        $id_kos = $this->get('id_kos'); 
        if($id_kosan === null){
        $kosan = $this->kosan->getDatakosan();
        } else {
            $kosan = $this->kosan->getDatakosan($id_kos);
        }
        
        if($kosan){
            $this->response([
                'status' => TRUE,
                'data' => $kosan
            ], REST_Controller::HTTP_NOT_FOUND);
        } else{
            $this->response([
                'status' => FALSE,
                'message' => 'id kosan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id_kos = $this->delete('id_kos');

        if($id_kos === null){
            $this->response([
                'status' => FALSE,
                'message' => 'pilih id terlebih dulu!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else{
            if($this->kosan->deleteDatakosan($id_kos) > 0){
                //ok
                $this->response([
                    'status' => TRUE,
                    'id_kos' => $id_kos,
                    'message' => 'kosan telah dihapus'
                ], REST_Controller::HTTP_OK);
            } else {
                //id not found
                $this->response([
                    'status' => FALSE,
                    'message' => 'id kos tidak ditemukan!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'namakos' => $this->post('namakos'),
            'kategori_kos' => $this->post('kategori_kos'),
            'alamat' => $this->post('alamat'),
            'deskripsi' => $this->post('deskripsi'),
            'gambar' => $this->post('gambar')
        ];

        if( $this->kosan->createdDatakosan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'kosan baru telah ditambahkan.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => FALSE,
                'message' => 'gagal menambahkan kosan.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id_kos = $this->put('id_kos');
        $data = [
            'namakos' => $this->post('namakos'),
            'kategori_kos' => $this->post('kategori_kos'),
            'alamat' => $this->post('alamat'),
            'deskripsi' => $this->post('deskripsi'),
            'gambar' => $this->post('gambar')
        ];

        if( $this->kosan->updateDatakosan($data, $id_kos) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'data kosan telah di update.'
            ], REST_Controller::HTTP_OK);
        } else {
            //id not found
            $this->response([
                'status' => FALSE,
                'message' => 'gagal update kuliner.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}

?>