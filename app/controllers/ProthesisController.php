<?php

class ProthesisController extends Controller {
    private $prothesisModel;

    public function __construct() {
        parent::__construct();
        $this->prothesisModel = new ProthesisModel();
    }

    public function index() {
        $data = [
            'protheses' => $this->prothesisModel->all(),
            'lowStock' => $this->prothesisModel->getLowStockItems(),
            'expiring' => $this->prothesisModel->getExpiringItems()
        ];
        return $this->view('prothesis/index', $data);
    }

    public function create() {
        if ($this->request['method'] === 'POST') {
            $this->verifyCsrf();
            
            $data = $this->request['body'];
            $id = $this->prothesisModel->create($data);
            
            if ($id) {
                return $this->redirect('/prothesis');
            }
            
            return $this->view('prothesis/create', [
                'error' => 'Error al crear la prótesis',
                'data' => $data
            ]);
        }
        
        return $this->view('prothesis/create', [
            'csrf_token' => $this->csrf()
        ]);
    }

    public function edit($id) {
        $prothesis = $this->prothesisModel->find($id);
        if (!$prothesis) {
            return $this->redirect('/prothesis');
        }

        if ($this->request['method'] === 'POST') {
            $this->verifyCsrf();
            
            $data = $this->request['body'];
            if ($this->prothesisModel->update($id, $data)) {
                return $this->redirect('/prothesis');
            }
            
            return $this->view('prothesis/edit', [
                'error' => 'Error al actualizar la prótesis',
                'prothesis' => $prothesis,
                'data' => $data
            ]);
        }
        
        return $this->view('prothesis/edit', [
            'prothesis' => $prothesis,
            'csrf_token' => $this->csrf()
        ]);
    }

    public function delete($id) {
        if ($this->request['method'] === 'POST') {
            $this->verifyCsrf();
            
            if ($this->prothesisModel->delete($id)) {
                return $this->json(['success' => true]);
            }
        }
        
        return $this->json(['success' => false], 400);
    }

    public function search() {
        $code = $this->request['query']['code'] ?? '';
        $results = $this->prothesisModel->searchByCode($code);
        return $this->json($results);
    }

    public function updateStock($id) {
        if ($this->request['method'] !== 'POST') {
            return $this->json(['error' => 'Método no permitido'], 405);
        }

        $this->verifyCsrf();
        $data = $this->request['body'];
        
        if (!isset($data['quantity']) || !isset($data['operation'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        if ($this->prothesisModel->updateStock($id, $data['quantity'], $data['operation'])) {
            return $this->json(['success' => true]);
        }
        
        return $this->json(['error' => 'Error al actualizar el stock'], 400);
    }

    public function report() {
        $report = $this->prothesisModel->getInventoryReport();
        return $this->view('prothesis/report', ['report' => $report]);
    }
}