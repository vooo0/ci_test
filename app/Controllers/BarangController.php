<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Barang;

class BarangController extends BaseController
{
    public function index()
    {	
		return view('data');
    }
	
	public function CreateBarang()
    {
        $Barang = new Barang();

        $data = [
            'name' => $this->request->getPost("name"),
			'kategori' => $this->request->getPost("kategori"),
			'harga' => $this->request->getPost("harga"),
			'diskon' => $this->request->getPost("diskon"),
			'foto' => $this->request->getPost("foto"),
        ];

		$Barang->save($data);

		$output = array('status' => 'Barang Inserted Successfully', 'data' => $data);
				
		return $this->response->setJSON($output);
	
    }

	public function ReadBarang()
	{
		$Barang = new Barang();
		
		$data['allBarang'] = $Barang->findAll();
		
		return $this->response->setJSON($data);
	}
	
	public function EditBarang()
	{
		$Barang = new Barang();
		
		$id = $this->request->getGet('sid');
		
		$data['row'] = $Barang->find($id);
		
		return $this->response->setJSON($data);
		
	}

    public function UpdateBarang()
    {
        $Barang = new Barang();

		$id = $this->request->getPost("update_id");

        $data = [
            'name' => $this->request->getPost("name"),
			'kategori' => $this->request->getPost("kategori"),
			'harga' => $this->request->getPost("harga"),
			'diskon' => $this->request->getPost("diskon"),
			'foto' => $this->request->getPost("foto"),
        ];

        $Barang->update($id, $data);

		$output = array('status' => 'Barang Updated Successfully', 'data' => $data);
				
		return $this->response->setJSON($output);
		
    }

    public function DeleteSBarang()
    {
        $Barang = new Barang();

		$id = $this->request->getGet("delete_id");
		
        $Barang->delete($id);

		$output = array('status' => 'Deleted Successfully');
				
		return $this->response->setJSON($output);
    }
}