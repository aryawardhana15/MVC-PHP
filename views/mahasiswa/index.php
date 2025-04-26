<!DOCTYPE html>
<html lang="en" class="<?= isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'dark' : '' ?>">
<head>
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toggle-checkbox:checked {
            right: 0;
            border-color: #68D391;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #68D391;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="mb-6 fade-in">
                <div class="<?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?> p-4 rounded-lg shadow">
                    <?= $_SESSION['flash']['message'] ?>
                </div>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Manajemen Data Mahasiswa</h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Kelola data mahasiswa dengan mudah</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <div class="flex items-center">
                    <span class="mr-2 text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-sun"></i>
                    </span>
                    <div class="relative inline-block w-12 mr-2 align-middle select-none">
                        <input type="checkbox" id="darkModeToggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" <?= isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true' ? 'checked' : '' ?>/>
                        <label for="darkModeToggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fas fa-moon"></i>
                    </span>
                </div>
                
                <!-- Add Student Button -->
                <a href="index.php?action=create" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Mahasiswa
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Total Mahasiswa</p>
                        <h3 class="text-2xl font-bold mt-1"><?= $stats['total'] ?></h3>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                        <i class="fas fa-users text-blue-600 dark:text-blue-300"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Laki-laki</p>
                        <h3 class="text-2xl font-bold mt-1">
                            <?= array_reduce($stats['gender'], function($carry, $item) {
                                return $carry + ($item['jenis_kelamin'] === 'L' ? $item['count'] : 0);
                            }, 0) ?>
                        </h3>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                        <i class="fas fa-male text-green-600 dark:text-green-300"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-pink-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Perempuan</p>
                        <h3 class="text-2xl font-bold mt-1">
                            <?= array_reduce($stats['gender'], function($carry, $item) {
                                return $carry + ($item['jenis_kelamin'] === 'P' ? $item['count'] : 0);
                            }, 0) ?>
                        </h3>
                    </div>
                    <div class="bg-pink-100 dark:bg-pink-900 p-3 rounded-full">
                        <i class="fas fa-female text-pink-600 dark:text-pink-300"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Jurusan Terbanyak</p>
                        <h3 class="text-2xl font-bold mt-1">
                            <?= !empty($stats['jurusan']) ? $stats['jurusan'][0]['jurusan'] : '-' ?>
                        </h3>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                        <i class="fas fa-graduation-cap text-purple-600 dark:text-purple-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Distribusi Jurusan</h3>
                <canvas id="jurusanChart" height="250"></canvas>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Distribusi Angkatan</h3>
                <canvas id="angkatanChart" height="250"></canvas>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Toolbar -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <!-- Search Box -->
                <form method="GET" action="index.php" class="w-full md:w-auto">
                    <input type="hidden" name="action" value="search">
                    <div class="relative">
                        <input type="text" name="query" placeholder="Cari mahasiswa..." 
                               class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                               value="<?= $_GET['query'] ?? '' ?>">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </form>
                
                <!-- Filter and Export -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <!-- Filter Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-lg">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-10 hidden group-hover:block border border-gray-200 dark:border-gray-700">
                            <form method="GET" action="index.php" class="p-4">
                                <input type="hidden" name="action" value="filter">
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                                    <select name="filter[jurusan]" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
                                        <option value="">Semua Jurusan</option>
                                        <?php foreach ($jurusanList as $jurusan): ?>
                                            <option value="<?= $jurusan ?>" <?= isset($_GET['filter']['jurusan']) && $_GET['filter']['jurusan'] === $jurusan ? 'selected' : '' ?>>
                                                <?= $jurusan ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Angkatan</label>
                                    <select name="filter[angkatan]" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
                                        <option value="">Semua Angkatan</option>
                                        <?php foreach ($angkatanList as $angkatan): ?>
                                            <option value="<?= $angkatan ?>" <?= isset($_GET['filter']['angkatan']) && $_GET['filter']['angkatan'] === $angkatan ? 'selected' : '' ?>>
                                                <?= $angkatan ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    Terapkan Filter
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Export Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-lg">
                            <i class="fas fa-file-export"></i>
                            <span>Export</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-10 hidden group-hover:block border border-gray-200 dark:border-gray-700">
                            <div class="py-1">
                                <a href="index.php?action=export&type=excel" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-file-excel text-green-600 mr-2"></i> Excel
                                </a>
                                <a href="index.php?action=export&type=pdf" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-file-pdf text-red-600 mr-2"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reset -->
                    <a href="index.php" class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-sync-alt mr-2"></i> Reset
                    </a>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="?sort=id&order=<?= ($_GET['sort'] ?? '') === 'id' && ($_GET['order'] ?? 'ASC') === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    ID <?= ($_GET['sort'] ?? '') === 'id' ? ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓' : '' ?>
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Mahasiswa
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <a href="?sort=nim&order=<?= ($_GET['sort'] ?? '') === 'nim' && ($_GET['order'] ?? 'ASC') === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    NIM <?= ($_GET['sort'] ?? '') === 'nim' ? ($_GET['order'] ?? 'ASC') === 'ASC' ? '↑' : '↓' : '' ?>
                                </a>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Jurusan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach ($mahasiswa as $m): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    <?= $m['id'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <?php if (isset($m['foto']) && file_exists($m['foto'])): ?>
                                                <img class="h-10 w-10 rounded-full object-cover" src="<?= $m['foto'] ?>" alt="">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600 dark:text-blue-300"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?= $m['nama'] ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 capitalize"><?= $m['jenis_kelamin'] ?? '-' ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?= $m['nim'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="font-medium"><?= $m['jurusan'] ?? '-' ?></div>
                                    <div class="text-xs">Angkatan <?= substr($m['nim'], 0, 2) ?? '00' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div><?= $m['email'] ?? '-' ?></div>
                                    <div class="text-xs truncate max-w-xs"><?= $m['alamat'] ?? '-' ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="index.php?action=edit&id=<?= $m['id'] ?>" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?action=delete&id=<?= $m['id'] ?>" 
                                           class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium"><?= count($mahasiswa) ?></span> dari <span class="font-medium"><?= $total ?></span> data
                    </div>
                    <div class="flex items-center space-x-1">
                        <a href="?page=<?= max(1, $page - 1) ?><?= isset($_GET['sort']) ? '&sort='.$_GET['sort'].'&order='.$_GET['order'] : '' ?><?= isset($_GET['filter']) ? '&filter='.http_build_query($_GET['filter']) : '' ?>" 
                           class="px-3 py-1 border rounded <?= $page == 1 ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-700' ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        
                        <?php 
                        $start = max(1, min($page - 2, $totalPages - 4));
                        $end = min($start + 4, $totalPages);
                        
                        if ($start > 1): ?>
                            <a href="?page=1<?= isset($_GET['sort']) ? '&sort='.$_GET['sort'].'&order='.$_GET['order'] : '' ?><?= isset($_GET['filter']) ? '&filter='.http_build_query($_GET['filter']) : '' ?>" 
                               class="px-3 py-1 border rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                1
                            </a>
                            <?php if ($start > 2): ?>
                                <span class="px-3 py-1">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <a href="?page=<?= $i ?><?= isset($_GET['sort']) ? '&sort='.$_GET['sort'].'&order='.$_GET['order'] : '' ?><?= isset($_GET['filter']) ? '&filter='.http_build_query($_GET['filter']) : '' ?>" 
                               class="px-3 py-1 border rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'hover:bg-gray-50 dark:hover:bg-gray-700' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($end < $totalPages): ?>
                            <?php if ($end < $totalPages - 1): ?>
                                <span class="px-3 py-1">...</span>
                            <?php endif; ?>
                            <a href="?page=<?= $totalPages ?><?= isset($_GET['sort']) ? '&sort='.$_GET['sort'].'&order='.$_GET['order'] : '' ?><?= isset($_GET['filter']) ? '&filter='.http_build_query($_GET['filter']) : '' ?>" 
                               class="px-3 py-1 border rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                <?= $totalPages ?>
                            </a>
                        <?php endif; ?>
                        
                        <a href="?page=<?= min($totalPages, $page + 1) ?><?= isset($_GET['sort']) ? '&sort='.$_GET['sort'].'&order='.$_GET['order'] : '' ?><?= isset($_GET['filter']) ? '&filter='.http_build_query($_GET['filter']) : '' ?>" 
                           class="px-3 py-1 border rounded <?= $page == $totalPages ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-700' ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        darkModeToggle.addEventListener('change', function() {
            document.documentElement.classList.toggle('dark');
            document.cookie = `darkMode=${this.checked}; path=/; max-age=${60*60*24*365}`;
        });

        // Charts
        const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
        const jurusanChart = new Chart(jurusanCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_column($stats['jurusan'], 'jurusan')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($stats['jurusan'], 'count')) ?>,
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', 
                        '#EC4899', '#14B8A6', '#F97316', '#64748B', '#84CC16'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#374151'
                        }
                    }
                }
            }
        });

        const angkatanCtx = document.getElementById('angkatanChart').getContext('2d');
        const angkatanChart = new Chart(angkatanCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_map(function($a) { return '20'.$a['angkatan']; }, $stats['angkatan'])) ?>,
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: <?= json_encode(array_column($stats['angkatan'], 'count')) ?>,
                    backgroundColor: '#3B82F6',
                    borderColor: '#2563EB',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#374151'
                        },
                        grid: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(229, 231, 235, 0.1)' : 'rgba(209, 213, 219, 0.3)'
                        }
                    },
                    x: {
                        ticks: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#374151'
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#374151'
                        }
                    }
                }
            }
        });

        // Update charts on dark mode change
        darkModeToggle.addEventListener('change', function() {
            jurusanChart.options.plugins.legend.labels.color = this.checked ? '#E5E7EB' : '#374151';
            jurusanChart.update();
            
            angkatanChart.options.scales.y.ticks.color = this.checked ? '#E5E7EB' : '#374151';
            angkatanChart.options.scales.y.grid.color = this.checked ? 'rgba(229, 231, 235, 0.1)' : 'rgba(209, 213, 219, 0.3)';
            angkatanChart.options.scales.x.ticks.color = this.checked ? '#E5E7EB' : '#374151';
            angkatanChart.options.plugins.legend.labels.color = this.checked ? '#E5E7EB' : '#374151';
            angkatanChart.update();
        });
    </script>
</body>
</html>