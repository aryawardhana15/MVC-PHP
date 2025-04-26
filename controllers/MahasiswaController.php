<?php
require_once 'models/Mahasiswa.php';

class MahasiswaController {
    private $model;

    public function __construct() {
        $this->model = new Mahasiswa();
    }

    public function index() {
        $page = $_GET['page'] ?? 1;
        $perPage = 5;
        $sortField = $_GET['sort'] ?? 'id';
        $sortOrder = $_GET['order'] ?? 'ASC';
        $filters = $_GET['filter'] ?? [];
        
        $mahasiswa = $this->model->all($page, $perPage, $sortField, $sortOrder, $filters);
        $total = $this->model->count($filters);
        $totalPages = ceil($total / $perPage);
        $jurusanList = $this->model->getJurusanList();
        $angkatanList = $this->model->getAngkatanList();
        $stats = $this->model->getStatistics();
        
        include 'views/mahasiswa/index.php';
    }

    public function create() {
        $jurusanList = $this->model->getJurusanList();
        include 'views/mahasiswa/create.php';
    }

    public function store() {
        try {
            if (empty($_POST['nama']) || empty($_POST['nim'])) {
                throw new Exception('Nama dan NIM wajib diisi');
            }
            
            if (!preg_match('/^[0-9]{8,}$/', $_POST['nim'])) {
                throw new Exception('NIM harus terdiri dari angka (min 8 digit)');
            }
            
            if ($this->model->store($_POST)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data mahasiswa berhasil ditambahkan'];
            } else {
                throw new Exception('Gagal menambahkan data mahasiswa');
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
        }
        header('Location: index.php');
    }

    public function edit($id) {
        $data = $this->model->find($id);
        $jurusanList = $this->model->getJurusanList();
        if (!$data) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Data mahasiswa tidak ditemukan'];
            header('Location: index.php');
            return;
        }
        include 'views/mahasiswa/edit.php';
    }

    public function update($id) {
        try {
            // Pastikan ID valid
            $id = $_POST['id'] ?? $id;
            if (empty($id)) {
                throw new Exception('ID mahasiswa tidak valid');
            }

            // Validasi input
            if (empty($_POST['nama']) || empty($_POST['nim'])) {
                throw new Exception('Nama dan NIM wajib diisi');
            }

            // Handle jurusan 'other'
            if (isset($_POST['jurusan']) && $_POST['jurusan'] === '_other' && !empty($_POST['jurusan_other'])) {
                $_POST['jurusan'] = $_POST['jurusan_other'];
            }

            // Data yang akan diupdate
            $data = [
                'nama' => $_POST['nama'],
                'nim' => $_POST['nim'],
                'jurusan' => $_POST['jurusan'] ?? null,
                'email' => $_POST['email'] ?? null,
                'alamat' => $_POST['alamat'] ?? null,
                'angkatan' => $_POST['angkatan'] ?? null,
                'jenis_kelamin' => $_POST['jenis_kelamin'] ?? null
            ];

            if ($this->model->update($id, $data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data mahasiswa berhasil diperbarui'];
            } else {
                throw new Exception('Gagal memperbarui data mahasiswa');
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
        }
        header('Location: index.php');
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data mahasiswa berhasil dihapus'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Gagal menghapus data mahasiswa'];
        }
        header('Location: index.php');
    }

    public function search($query) {
        $mahasiswa = $this->model->search($query);
        $jurusanList = $this->model->getJurusanList();
        $angkatanList = $this->model->getAngkatanList();
        $stats = $this->model->getStatistics();
        include 'views/mahasiswa/index.php';
    }

    public function filter($filters) {
        $mahasiswa = $this->model->all(1, 100, 'id', 'ASC', $filters);
        $jurusanList = $this->model->getJurusanList();
        $angkatanList = $this->model->getAngkatanList();
        $stats = $this->model->getStatistics();
        include 'views/mahasiswa/index.php';
    }

    public function export($type) {
        $mahasiswa = $this->model->all(1, 1000, 'id', 'ASC');
        
        if ($type === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="data_mahasiswa.pdf"');
            
            $html = '<h1>Data Mahasiswa</h1><table border="1">';
            $html .= '<tr><th>ID</th><th>Nama</th><th>NIM</th><th>Jurusan</th></tr>';
            foreach ($mahasiswa as $m) {
                $html .= '<tr>';
                $html .= '<td>'.$m['id'].'</td>';
                $html .= '<td>'.$m['nama'].'</td>';
                $html .= '<td>'.$m['nim'].'</td>';
                $html .= '<td>'.($m['jurusan'] ?? '-').'</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            echo $html;
            exit;
        } elseif ($type === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="data_mahasiswa.xls"');
            
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nama</th><th>NIM</th><th>Jurusan</th><th>Email</th></tr>";
            foreach ($mahasiswa as $m) {
                echo "<tr>";
                echo "<td>".$m['id']."</td>";
                echo "<td>".$m['nama']."</td>";
                echo "<td>".$m['nim']."</td>";
                echo "<td>".($m['jurusan'] ?? '-')."</td>";
                echo "<td>".($m['email'] ?? '-')."</td>";
                echo "</tr>";
            }
            echo "</table>";
            exit;
        }
        
        header('Location: index.php');
    }

    public function uploadPhoto($id) {
        try {
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $filename = 'photo_' . $id . '_' . time() . '.' . $ext;
                $targetPath = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
                    if ($this->model->updatePhoto($id, $targetPath)) {
                        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Foto berhasil diupload'];
                    } else {
                        throw new Exception('Gagal menyimpan data foto');
                    }
                } else {
                    throw new Exception('Gagal mengupload file');
                }
            } else {
                throw new Exception('Tidak ada file yang diupload atau terjadi error');
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
        }
        header("Location: index.php?action=edit&id=$id");
    }
}