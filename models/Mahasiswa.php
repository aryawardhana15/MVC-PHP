<?php
require_once 'config/database.php';

class Mahasiswa {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function all($page = 1, $perPage = 5, $sortField = 'id', $sortOrder = 'ASC', $filters = []) {
        $offset = ($page - 1) * $perPage;
        
        $where = [];
        $params = [];
        
        if (!empty($filters['jurusan'])) {
            $where[] = "jurusan = ?";
            $params[] = $filters['jurusan'];
        }
        
        if (!empty($filters['angkatan'])) {
            $where[] = "SUBSTRING(nim, 1, 2) = ?";
            $params[] = $filters['angkatan'];
        }
        
        $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
        
        $sql = "SELECT * FROM mahasiswa $whereClause ORDER BY $sortField $sortOrder LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count($filters = []) {
        $where = [];
        $params = [];
        
        if (!empty($filters['jurusan'])) {
            $where[] = "jurusan = ?";
            $params[] = $filters['jurusan'];
        }
        
        if (!empty($filters['angkatan'])) {
            $where[] = "SUBSTRING(nim, 1, 2) = ?";
            $params[] = $filters['angkatan'];
        }
        
        $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
        
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM mahasiswa $whereClause");
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store($data) {
        $stmt = $this->db->prepare("INSERT INTO mahasiswa (nama, nim, jurusan, email, alamat, angkatan, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama'], 
            $data['nim'],
            $data['jurusan'] ?? null,
            $data['email'] ?? null,
            $data['alamat'] ?? null,
            $data['angkatan'] ?? null,
            $data['jenis_kelamin'] ?? null
        ]);
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE mahasiswa SET 
                    nama = :nama, 
                    nim = :nim, 
                    jurusan = :jurusan, 
                    email = :email, 
                    alamat = :alamat, 
                    angkatan = :angkatan, 
                    jenis_kelamin = :jenis_kelamin 
                    WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':nim', $data['nim']);
            $stmt->bindParam(':jurusan', $data['jurusan']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':alamat', $data['alamat']);
            $stmt->bindParam(':angkatan', $data['angkatan']);
            $stmt->bindParam(':jenis_kelamin', $data['jenis_kelamin']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database error in update: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function search($query) {
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE nama LIKE ? OR nim LIKE ? OR jurusan LIKE ? OR email LIKE ?");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJurusanList() {
        $stmt = $this->db->query("SELECT DISTINCT jurusan FROM mahasiswa WHERE jurusan IS NOT NULL");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAngkatanList() {
        $stmt = $this->db->query("SELECT DISTINCT SUBSTRING(nim, 1, 2) as angkatan FROM mahasiswa WHERE nim IS NOT NULL");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getStatistics() {
        $stats = [];
        
        // Total students
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM mahasiswa");
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // By gender
        $stmt = $this->db->query("SELECT jenis_kelamin, COUNT(*) as count FROM mahasiswa GROUP BY jenis_kelamin");
        $stats['gender'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // By department
        $stmt = $this->db->query("SELECT jurusan, COUNT(*) as count FROM mahasiswa WHERE jurusan IS NOT NULL GROUP BY jurusan");
        $stats['jurusan'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // By year
        $stmt = $this->db->query("SELECT SUBSTRING(nim, 1, 2) as angkatan, COUNT(*) as count FROM mahasiswa WHERE nim IS NOT NULL GROUP BY SUBSTRING(nim, 1, 2)");
        $stats['angkatan'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $stats;
    }

    public function updatePhoto($id, $photoPath) {
        $stmt = $this->db->prepare("UPDATE mahasiswa SET foto = ? WHERE id = ?");
        return $stmt->execute([$photoPath, $id]);
    }
}