<!DOCTYPE html>
<html lang="en" class="<?= isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : '' ?>">
<head>
    <title>Edit Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="mb-6 fade-in">
                <div class="<?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?> p-4 rounded-lg shadow">
                    <?= $_SESSION['flash']['message'] ?>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Data Mahasiswa</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Perbarui informasi mahasiswa</p>
            </div>
            <a href="index.php" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <form method="POST" action="index.php?action=update&id=<?= $data['id'] ?>" class="p-6 space-y-6">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                               required>
                    </div>
                    
                    <!-- NIM -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            NIM <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nim" value="<?= htmlspecialchars($data['nim']) ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                               required
                               pattern="[0-9]{8,}"
                               title="NIM harus terdiri dari angka (min 8 digit)">
                    </div>
                    
                    <!-- Jurusan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                        <div class="relative">
                            <select name="jurusan" class="w-full px-4 py-2 border rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Pilih Jurusan</option>
                                <?php foreach ($jurusanList as $jurusan): ?>
                                    <option value="<?= $jurusan ?>" <?= isset($data['jurusan']) && $data['jurusan'] === $jurusan ? 'selected' : '' ?>>
                                        <?= $jurusan ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="_other" <?= isset($data['jurusan']) && !in_array($data['jurusan'], $jurusanList) ? 'selected' : '' ?>>
                                    Lainnya...
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <input type="text" name="jurusan_other" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 mt-2 <?= isset($data['jurusan']) && !in_array($data['jurusan'], $jurusanList) ? '' : 'hidden' ?>"
                               placeholder="Masukkan nama jurusan"
                               value="<?= isset($data['jurusan']) && !in_array($data['jurusan'], $jurusanList) ? htmlspecialchars($data['jurusan']) : '' ?>">
                    </div>
                    
                    <!-- Angkatan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Angkatan</label>
                        <input type="text" name="angkatan" value="<?= htmlspecialchars($data['angkatan'] ?? '') ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                               placeholder="20xx">
                    </div>
                    
                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin</label>
                        <div class="flex space-x-4 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="L" class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600" <?= isset($data['jenis_kelamin']) && $data['jenis_kelamin'] === 'L' ? 'checked' : '' ?>>
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="P" class="text-pink-600 focus:ring-pink-500 dark:focus:ring-pink-600" <?= isset($data['jenis_kelamin']) && $data['jenis_kelamin'] === 'P' ? 'checked' : '' ?>>
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
                
                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                    <textarea name="alamat" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>
                </div>
                
                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="index.php" class="px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-yellow-600 to-yellow-500 text-white rounded-lg hover:from-yellow-700 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                        <i class="fas fa-sync-alt mr-2"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show/hide other jurusan input
        const jurusanSelect = document.querySelector('select[name="jurusan"]');
        const jurusanOtherInput = document.querySelector('input[name="jurusan_other"]');
        
        jurusanSelect.addEventListener('change', function() {
            if (this.value === '_other') {
                jurusanOtherInput.classList.remove('hidden');
                jurusanOtherInput.required = true;
            } else {
                jurusanOtherInput.classList.add('hidden');
                jurusanOtherInput.required = false;
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (jurusanSelect.value === '_other') {
                jurusanOtherInput.classList.remove('hidden');
                jurusanOtherInput.required = true;
            }
        });
    </script>
</body>
</html>